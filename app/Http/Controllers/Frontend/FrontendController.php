<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cta;
use App\Models\Faq;
use App\Models\Post;
use App\Models\About;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Category;
use App\Models\WhyChoseUs;
use App\Models\Achievement;
use App\Models\Promobanner;
use App\Models\ProjectVideo;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use App\Models\WebsiteSocialIcon;
use App\Http\Controllers\Controller;
use App\Models\Privacypolicy;
use App\Models\Returnrefund;
use App\Models\Termscondition;

class FrontendController extends Controller
{
    public function index()
    {
        $banner = Banner::select(['id', 'title', 'sub_title', 'description', 'button_name', 'button_url', 'image'])->first();
        $categories = Category::with('products')->where('category_slug', '!=', 'default')->select('id', 'category_name', 'image', 'category_slug')->get();

        $promobanners = Promobanner::where('is_active', 1)
            ->latest()
            ->get(['id', 'image', 'url']);

        $about = About::first();
        $social_icon = WebsiteSocialIcon::select(['id', 'messanger_url'])->first();
        $website_setting = WebsiteSetting::select(['id', 'phone'])->first();

        $featured_products = Product::with(['category:id,category_name'])
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->latest()
            ->limit(8)
            ->get(['id', 'category_id', 'product_name', 'product_slug', 'regular_price', 'discount_price', 'discount_type', 'thumbnail']);

        // $project_videos = ProjectVideo::latest()->limit(8)->get(['id', 'video_url']);

        // $whychoses = WhyChoseUs::where('is_active', 1)->latest()->get(['id', 'title', 'description', 'image']);

        $achievements = Achievement::where('is_active', 1)
            ->latest()
            ->get(['id', 'title', 'count_number', 'image']);

        $reviews = Review::latest()->get(['id', 'name', 'profession', 'review', 'image']);

        $cta = Cta::where('is_active', 1)->first();

        // $faqs = Faq::latest()->get(['id', 'question', 'answer']);

        $blogs = Post::latest()->take(3)->get();

        return view('website.home', compact(['banner', 'categories', 'achievements', 'reviews', 'about', 'featured_products', 'blogs', 'promobanners', 'social_icon', 'website_setting', 'cta']));
    }

    public function shopPage(Request $request)
    {
        $pageTitle = 'Shop';
        $products = Product::where('is_active', 1)
            ->latest()
            ->select(['id', 'category_id', 'product_name', 'product_slug', 'regular_price', 'discount_price', 'discount_type', 'thumbnail'])
            ->paginate(12);

        if ($request->ajax()) {
            return view('website.layouts.pages.product.partials.products', compact('products'))->render();
        }

        $categories = Category::get(['id', 'category_name', 'category_slug']);
        $brands = Brand::with('products')->get(['id', 'brand_name']);

        return view('website.layouts.pages.product.shop-page', compact('products', 'categories', 'brands', 'pageTitle'));
    }

    public function productSinglePage($id)
    {
        $product = Product::with(['category:id,category_name'])->findOrFail($id);
        $relatedProducts = Product::where('id', '!=', $product->id)->latest()->take(4)->get();
        return view('website.layouts.pages.product.product-single-page', compact('product', 'relatedProducts'));
    }

    // Product search

    public function search(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $suggestions = Product::where('product_name', 'LIKE', '%' . $query . '%')
                ->orWhere('regular_price', 'LIKE', '%' . $query . '%')
                ->limit(5)
                ->get(['id', 'product_name', 'regular_price', 'discount_price', 'discount_type', 'thumbnail']);

            $formattedSuggestions = $suggestions->map(function ($product) {
                $final_price = $product->regular_price;
                $has_discount = false;

                if ($product->discount_price > 0) {
                    if ($product->discount_type === 'percent') {
                        $final_price = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
                    } elseif ($product->discount_type === 'flat') {
                        $final_price = $product->regular_price - $product->discount_price;
                    }

                    // যদি ডিসকাউন্ট করার পরেও ফাইনাল প্রাইস রেগুলার প্রাইসের চেয়ে কম হয়, তাহলেই ডিসকাউন্ট ধরবো
                    $has_discount = $final_price < $product->regular_price;
                }

                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'regular_price' => $product->regular_price,
                    'discount_price' => $has_discount ? $final_price : null,
                    'final_price' => $has_discount ? $final_price : $product->regular_price,
                    'thumbnail' => $product->thumbnail ? asset($product->thumbnail) : asset('default.jpg'),
                    'url' => route('product_single.page', $product->id),
                ];
            });

            return response()->json(['suggestions' => $formattedSuggestions]);
        }

        return response()->json(['suggestions' => []]);
    }

    public function priceFilter(Request $request)
    {
        $min = (float) $request->min_price;
        $max = (float) $request->max_price;

        $products = Product::all()->filter(function ($product) use ($min, $max) {
            // Default price is regular
            $final_price = $product->regular_price;

            // Calculate final price based on discount type
            if ($product->discount_price > 0) {
                if ($product->discount_type === 'percent') {
                    $final_price = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
                } elseif ($product->discount_type === 'flat') {
                    $final_price = $product->regular_price - $product->discount_price;
                }
            }

            // Filter by final calculated price
            return $final_price >= $min && $final_price <= $max;
        });

        $html = '';
        foreach ($products as $product) {
            $html .= view('website.layouts.partials.product_shop', compact('product'))->render();
        }

        return $html;
    }

    // Categorywise product filter
    public function multiCategoryFilter(Request $request)
    {
        // Get the category_ids from the request, default to empty array if not present
        $categoryIds = $request->input('category_ids', []);

        // If no categories are selected, fetch all products
        if (empty($categoryIds)) {
            $products = Product::all(); // This will return all products
        } else {
            // If categories are selected, filter products by selected categories
            $products = Product::whereIn('category_id', $categoryIds)->get();
        }

        $html = '';
        foreach ($products as $product) {
            $final_price = $product->regular_price;

            // Apply discount if available
            if ($product->discount_price > 0) {
                if ($product->discount_type === 'percent') {
                    $final_price = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
                } elseif ($product->discount_type === 'flat') {
                    $final_price = $product->regular_price - $product->discount_price;
                }
            }

            // Append the rendered HTML for each product
            $html .= view('website.layouts.partials.product_search_by_category', compact('product', 'final_price'))->render();
        }

        return response()->json(['html' => $html]);
    }

    // Product filter by brand

    public function multiBrandFilter(Request $request)
    {
        // Get the category_ids from the request, default to empty array if not present
        $brandIds = $request->input('brand_ids', []);

        // If no categories are selected, fetch all products
        if (empty($brandIds)) {
            $products = Product::all(); // This will return all products
        } else {
            // If categories are selected, filter products by selected categories
            $products = Product::whereIn('brand_id', $brandIds)->get();
        }

        $html = '';
        foreach ($products as $product) {
            $final_price = $product->regular_price;

            // Apply discount if available
            if ($product->discount_price > 0) {
                if ($product->discount_type === 'percent') {
                    $final_price = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
                } elseif ($product->discount_type === 'flat') {
                    $final_price = $product->regular_price - $product->discount_price;
                }
            }

            // Append the rendered HTML for each product
            $html .= view('website.layouts.partials.product_search_by_brand', compact('product', 'final_price'))->render();
        }

        return response()->json(['html' => $html]);
    }

    public function getCategoryProducts($id)
    {
        $pageTitle = 'Product Page';
        $category = Category::with('products')->findOrFail($id);
        return view('website.layouts.partials.get_category_products', compact('category', 'pageTitle'));
    }

    public function termsAndCondtion()
    {
        $pageTitle = 'Term & Condition';
        $termsAndCondition = Termscondition::first();
        return view('website.layouts.terms_and_condition', compact('termsAndCondition', 'pageTitle'));
    }

    // Privacy policy page method
    public function privacyPolicyPage()
    {
        $pageTitle = 'Privacy policy';
        $privacyPolicy = Privacypolicy::first();
        return view('website.layouts.privacy_policy', compact('privacyPolicy', 'pageTitle'));
    }

    public function returnRefund()
    {
        $pageTitle = 'Return & Refund';
        $returnRefund = Returnrefund::first();
        return view('website.layouts.return_refund', compact('returnRefund', 'pageTitle'));
    }
}

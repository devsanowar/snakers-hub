<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;


class CartController extends Controller
{
    public function cartPage()
    {
        $cartContents = session()->get('cart', []);

        $totalAmount = 0;
        foreach ($cartContents as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }


        return view('website.layouts.pages.cart.cart_page', compact('cartContents', 'totalAmount'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $qty = $request->order_qty ?? 1;

        // Determine final price based on discount
        $final_price = $product->regular_price;

        if ($product->discount_price > 0) {
            if ($product->discount_type === 'percent') {
                $final_price = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
            } elseif ($product->discount_type === 'flat') {
                $final_price = $product->regular_price - $product->discount_price;
            }
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name' => $product->product_name,
                'price' => $final_price,
                'quantity' => $qty,
                'thumbnail' => $product->thumbnail,
                'regular_price' => $product->regular_price,
                'discount_price' => $product->discount_price,
                'discount_type' => $product->discount_type,
            ];
        }

        session()->put('cart', $cart);

        $itemCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => count($cart),
            'itemCount' => $itemCount,
        ]);
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        // Remove the item if it exists in the cart
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            Toastr::success('Product removed from cart successfully!', 'Success');
        } else {
            Toastr::warning('Product not found in cart!', 'Warning');
        }
        return back();
    }


    // public function cartUpdate(Request $request)
    // {
    //     // dd($request->all());
    //     foreach ($request->quantities as $rowId => $qty) {
    //         // Cart::update($rowId, $qty);
    //     }

    //     Toastr::success('Cart Successfully Updated!!');

    //     return redirect()->back();
    // }


    public function updateCart(Request $request)
{
    $cart = session()->get('cart', []);

    $productId = $request->product_id;
    $action = $request->action;

    if (isset($cart[$productId])) {
        if ($action === 'increase') {
            $cart[$productId]['quantity'] += 1;
        } elseif ($action === 'decrease' && $cart[$productId]['quantity'] > 1) {
            $cart[$productId]['quantity'] -= 1;
        }

        session()->put('cart', $cart);

        $subtotal = $cart[$productId]['price'] * $cart[$productId]['quantity'];
        $totalAmount = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $itemCount = array_sum(array_column($cart, 'quantity'));


        return response()->json([
            'success' => true,
            'quantity' => $cart[$productId]['quantity'],
            'subtotal' => $subtotal,
            'totalAmount' => $totalAmount,
            'itemCount' => $itemCount,
        ]);
    }

    return response()->json(['success' => false]);
}













}

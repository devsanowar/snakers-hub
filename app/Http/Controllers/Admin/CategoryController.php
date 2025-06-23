<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Intervention\Image\Laravel\Facades\Image;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('position')->get();
        return view('admin.layouts.pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.layouts.pages.category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $newCategoryImage = $this->categoryImage($request);
        Category::create([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
            'description' => $request->description,
            'image' => $newCategoryImage,
            'is_active' => $request->is_active,
        ]);

        Toastr::success('Category added successfully.');
        return redirect()->back();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.layouts.pages.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        $categoryNewImage = $this->categoryImage($request);
        if ($categoryNewImage) {
            if (!empty($category->image)) {
                $oldImagePath = public_path($category->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $category->image = $categoryNewImage;
        }

        $category->update([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
            'description' => $request->description,
            'image' => $category->image,
            'is_active' => $request->is_active,
        ]);

        Toastr::success('Category updated successfully.');
        return redirect()->route('category.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category->category_slug == 'default') {
            Toastr::error('Default category cannot be deleted.');
            return back();
        }

        $defaultCategory = Category::where('category_slug', 'default')->first();
        if (!$defaultCategory) {
            Toastr::error('Category deleted successfully.');
            return back();
        }
        $category->products()->update([
            'category_id' => $defaultCategory->id,
        ]);

        if ($category) {
            if (!empty($category->image)) {
                $oldImagePath = public_path($category->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $category->delete();
        Toastr::success('Category deleted successfully.');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No categories selected.']);
        }

        // Get default category
        $defaultCategory = Category::where('category_slug', 'default')->first();

        if (!$defaultCategory) {
            return response()->json(['success' => false, 'message' => 'Default category not found.']);
        }

        // Check if default category is in selected IDs
        if (in_array($defaultCategory->id, $ids)) {
            return response()->json(['success' => false, 'message' => 'Please do not select the default category.']);
        }

        // Now safe to delete others
        $deletedCount = 0;

        foreach ($ids as $id) {
            $category = Category::find($id);

            if (!$category) {
                continue;
            }

            // Transfer products to default category
            $category->products()->update([
                'category_id' => $defaultCategory->id,
            ]);

            // Delete category image from storage
            if (!empty($category->image)) {
                $oldImagePath = public_path($category->image);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $category->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            return response()->json(['success' => true, 'message' => "$deletedCount category(s) deleted successfully."]);
        }

        return response()->json(['success' => false, 'message' => 'No valid category was deleted.']);
    }

    // Category orderBy position
    public function updateOrder(Request $request)
    {
        if (!$request->has('position') || !is_array($request->position)) {
            return response()->json(['success' => false, 'message' => 'Invalid data received.'], 400);
        }

        foreach ($request->position as $index => $id) {
            Category::where('id', $id)->update(['position' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Position updated successfully.',
        ]);
    }

    public function categoryChangeStatus(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Category not found.']);
        }

        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Status changed successfully.',
            'new_status' => $category->is_active ? 'Active' : 'DeActive',
            'class' => $category->is_active ? 'btn-success' : 'btn-danger',
        ]);
    }

    // Image add and update code here
    private function categoryImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = Image::read($request->file('image'));
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('uploads/category_image/');
            $image->save($destinationPath . $imageName);
            return 'uploads/category_image/' . $imageName;
        }
        return null;
    }
}

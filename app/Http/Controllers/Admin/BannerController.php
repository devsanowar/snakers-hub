<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Laravel\Facades\Image;

class BannerController extends Controller
{
    public function index(){
        $banner = Banner::first();
        return view('admin.layouts.pages.banner.index', compact('banner'));
    }

    public function update(Request $request){
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:150',
        ]);

        $banner  = Banner::first();
        $newImage = $this->bannerImage($request);
        if ($newImage) {
            $oldImagePath = public_path($banner->image);
            if ($banner->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $banner->image = $newImage;
        }

        $banner->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
            'image' => $banner->image,
            'button_name' => $request->button_name,
            'button_url'=> $request->button_url,
        ]);

        Toastr::success('Banner updated successfully.');
        return redirect()->back();

    }


    private function bannerImage(Request $request){
        if ($request->hasFile('image')) {
            $image = Image::read($request->file('image'));
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path('uploads/banner_image/');
            $image->save($destinationPath . $imageName);

            return 'uploads/banner_image/' . $imageName;

        }
        return null;
    }


}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Chairman;
use App\Models\MissionAndVission;
use App\Models\Review;
use App\Models\WhyChoseUs;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function aboutPage(){
        $pageTitle = 'About Us';
        $chairman = Chairman::first();
        $about = About::first();
        $missionVission = MissionAndVission::first();
        $whychoseuses = WhyChoseUs::Where('is_active', 1)->latest()->get();
        $reviews = Review::latest()->get();
        return view('website.layouts.about', compact([
            'pageTitle',
            'chairman',
            'about',
             'missionVission',
             'reviews',
             'whychoseuses'
        ]));
    }
}


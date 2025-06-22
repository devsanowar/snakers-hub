@php
    use App\Models\WebsiteSetting;
    $website_setting = WebsiteSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title') {{ $website_setting->website_title }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset($website_setting->website_favicon)}}" />
    @include('website.layouts.inc.style')
</head>

<body id="home-page">

    <!--==================== Overlay Start ====================-->
    <div class="body-overlay"></div>
    <!--==================== Overlay End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <!-- ==================== Scroll to Top End Here ==================== -->
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>
    <!-- ==================== Scroll to Top End Here ==================== -->

    <!-- ==================== Header Top Start Here ==================== -->
@include('website.layouts.inc.navber')
    <!-- ==================== Bottom Header End Here ==================== -->

    <!--========================== Search Modal Start ==========================-->
@include('website.layouts.inc.search-modal')
    <!--========================== Search Modal End ==========================-->





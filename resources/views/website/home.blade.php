@include('website.layouts.inc.header')
<!--==================== Preloader Start ====================-->
<div class="preloader">
    <div class="loader-p"></div>
</div>

<div class="floating-icons">
    <a href="https://wa.me/{{ $website_setting->phone }}" target="_blank" class="icon whatsapp">
        <i class="fab fa-whatsapp" style="font-size: 25px"></i>
    </a>
    <a href="tel:{{ $website_setting->phone }}" class="icon call">
        <i class="fas fa-phone-alt" style="font-size: 15px"></i>
    </a>
    <a href="{{ $social_icon->messanger_url }}" target="_blank" class="icon call2">
        <i class="fa-brands fa-facebook-messenger" style="font-size: 22px"></i>
    </a>

</div>



<!--==================== Preloader End ====================-->
<!--========================== Banner Section Start ==========================-->
<section class="banner-section pt-2 pb-60" style="background-color: #f8f9fa">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-3">
                <nav class="category">
                    <span class="close-sidebar d-lg-none d-block"><i class="fa-solid fa-xmark"></i></span>
                    <ul class="category-menu">

                        @foreach ($categories as $category)
                            <li class="category-menu__item">
                                <a href="{{ route('get_category.products', $category->id) }}"
                                    class="category-menu__link">
                                    <span class="category-menu__thumb"><img src="{{ asset($category->image) }}"
                                            alt="" width="30" /></span>
                                    {{ $category->category_name }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </nav>
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="banner">
                    <div class="banner-content" data-aos="fade-up">
                        <h4 class="banner-content__subtitle">{{ $banner->sub_title }}</h4>
                        <h2 class="banner-content__title">{{ $banner->title }}</h2>
                        <p class="banner-content__desc">
                            {!! $banner->description !!}
                        </p>
                        <div class="banner-content__buttons">
                            <a href="{{ $banner->button_url }}"
                                class="btn-snekers btn-snekers-primary">{{ $banner->button_name }}</a>
                        </div>
                    </div>
                    <div class="banner-thumb">
                        <img src="{{ asset($banner->image) }}" alt="" />
                        {{-- <div class="banner-thumb__shape">
                            <img src="{{ asset('frontend') }}/assets/images/shapes/banner-shape.png" alt="" />
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Banner Section End ==========================-->

<!--==============================offer-section start  here=============================-->
<div class="offer-section pt-60 pb-60" style="overflow:hidden">
    <div class="container">
        <div class="row gy-4">
            @forelse ($promobanners as $promobanner)
                <div class="col-lg-6" data-aos="fade-right">
                    <a href="{{ $promobanner->url }}" class="offer">
                        <img src="{{ asset($promobanner->image) }}" alt="" />
                    </a>
                </div>
            @empty
            @endforelse

        </div>
    </div>
</div>
<!--======================product sections start here =================-->
<div class="product-section py-60" style="background-color: #f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="section-heading" data-aos="fade-up">
                    {{-- <h4 class="section-heading__subtitle">Special products</h4> --}}
                    <h3 class="section-heading__title style-two">
                        Featured Products<span class="section-heading__bars"></span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gy-4" data-aos="fade-up">

            @forelse($featured_products as $key => $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xsm-6 mob-version-product">
                    <div class="product-item">
                        <div class="product-item__thumb">
                            <a href="{{ route('product_single.page', $product->id) }}"
                                class="product-item__thumb-link">
                                <img src="{{ asset($product->thumbnail) }}" alt="" />
                            </a>
                            <button class="product-item__icon">
                                <span class="product-item__icon-style">
                                    <i class="las la-heart"></i>
                                </span>
                            </button>
                        </div>
                        <div class="product-item__content">
                            <h5 class="product-item__title">
                                <a href="{{ route('product_single.page', $product->id) }}"
                                    class="product-item__title-link">
                                    {{ $product->product_name }}
                                </a>
                            </h5>

                            <h6 class="product-item__price">
                                @if ($product->discount_price && $product->discount_type === 'flat')
                                    @php
                                        $product_discount_price = $product->regular_price - $product->discount_price;
                                    @endphp
                                    <span
                                        class="product-item__price-new">৳{{ number_format($product_discount_price, 2) }}</span>
                                    <span
                                        class="text-decoration-line-through">৳{{ number_format($product->regular_price, 2) }}</span>
                                @elseif ($product->discount_price && $product->discount_type === 'percent')
                                    @php
                                        $discount_amount = ($product->regular_price * $product->discount_price) / 100;
                                        $product_discount_price = $product->regular_price - $discount_amount;
                                    @endphp
                                    <span
                                        class="product-item__price-new">৳{{ number_format($product_discount_price, 2) }}</span>
                                    <span
                                        class="text-decoration-line-through">৳{{ number_format($product->regular_price, 2) }}</span>
                                @else
                                    <span class="">৳{{ number_format($product->regular_price, 2) }}</span>
                                @endif

                            </h6>
                            <form class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="order_qty" value="1">
                                <button type="submit" class="btn-snekers btn-snekers-primary btn--sm btn-buy">
                                    Add to Cart
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>

                            </form>

                        </div>
                    </div>
                </div>
            @empty

                <div class="col-lg-3 col-md-4 col-sm-6 col-xsm-6">
                    <div class="product-item">
                        <div class="product-item__thumb">
                            <a href="/product-details.html" class="product-item__thumb-link">
                                <img src="{{ asset('frontend') }}/assets/images/thumbs/product/product08.png"
                                    alt="" />
                            </a>
                            <button class="product-item__icon">
                                <span class="product-item__icon-style">
                                    <i class="las la-heart"></i>
                                </span>
                            </button>
                        </div>
                        <div class="product-item__content">
                            <h5 class="product-item__title">
                                <a href="/product-details.html" class="product-item__title-link">
                                    Moderna Trendy Story
                                </a>
                            </h5>
                            {{-- <ul class="product-info__rating justify-content-center">
                                <li class="product-info__rating-item">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="product-info__rating-item">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="product-info__rating-item">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="product-info__rating-item">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="product-info__rating-item">
                                    <i class="fas fa-star"></i>
                                </li>
                                <li class="product-info__number">4.8</li>
                            </ul> --}}
                            <h6 class="product-item__price">
                                <span class="product-item__price-new">$620</span> $520
                            </h6>
                            <a href="cart.html" class="btn-snekers btn-snekers-primary btn--sm">Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse



        </div>
    </div>
</div>

<!-- Cta -->
<div>
    <div id="cta-section" class="bg-position" style="background-image: url('{{ asset($cta->image) }}')">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-7">
                    <div class="hurry" data-aos="fade-up">
                        <h2 class="section-heading__title">{{ $cta->title }}</h2>
                        <h4 class="heading-four">
                            {{ $cta->sub_title }}
                        </h4>
                        <p>
                            {!! $cta->content !!}
                        </p>
                        <div class="banner-content__buttons">
                            <a href="{{ $cta->button_url }}"
                                class="btn-snekers btn-snekers-primary">{{ $cta->button_name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===================== deal section end Here ====================-->
<!--==========================new arrival section start here======================-->
<div class="new-arrival-section py-60" style="background-color: #f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading" data-aos="fade-up">
                    <h4 class="section-heading__subtitle">Special products</h4>
                    <h3 class="section-heading__title style-two">
                        New Arrivals product<span class="section-heading__bars"></span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-12" data-aos="fade-up">
            <div class="filter text-center mb-4">
                <button type="button" class="mixitup-control-active category-button" data-filter="*">All</button>
                @foreach ($categories as $category)
                    <button type="button" class="category-button" data-filter=".{{ $category->category_slug }}">
                        {{-- <span class="category-menu__thumb"><img src="{{ asset($category->image) }}" alt=""
                                width="20px" /></span> --}}
                        {{ $category->category_name }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="product" data-aos="zoom-in">
            <div class="row justify-content-center gy-4 mix-container">
                @foreach ($categories as $category)
                    @foreach ($category->products as $product)
                        <div
                            class="mob-version-product col-lg-3 col-md-6 col-sm-6 mix {{ $category->category_slug }}">
                            <div class="product-item">
                                <div class="product-item__thumb">
                                    <a href="{{ route('product_single.page', $product->id) }}"
                                        class="product-item__thumb-link">
                                        <img src="{{ asset($product->thumbnail) }}" alt="" />
                                    </a>
                                    <button class="product-item__icon">
                                        <span class="product-item__icon-style">
                                            <i class="las la-heart"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="product-item__content text-center">
                                    <h5 class="product-item__title">
                                        <a
                                            href="{{ route('product_single.page', $product->id) }}">{{ $product->product_name }}</a>
                                    </h5>
                                    <h6 class="product-item__price">
                                        <span class="product-item__price-new">৳{{ $product->regular_price }}</span>
                                        <span
                                            class="text-decoration-line-through">৳{{ $product->discount_price }}</span>
                                    </h6>
                                    <form class="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="order_qty" value="1">
                                        <button type="submit"
                                            class="btn-snekers btn-snekers-primary btn--sm btn-buy">
                                            Add to Cart
                                            <span class="spinner-border spinner-border-sm d-none"></span>
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>
</div>
<!-- ==================new offer section start here==================-->

<!-- ===================new offer section end here =====================-->
<!-- ==========================testimonial section start here=======================-->
<div class="testimonial-section py-60">
    <div class="container">
        <div class="row align-items-center flex-wrap">
            <div class="col-lg-6">
                <div class="testimonials-thumb-slider">
                    @foreach ($reviews as $review)
                        <div class="testimonial-thumb">
                            <img src="{{ asset($review->image) }}" alt="" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testimonial-slick-slider">

                    @foreach ($reviews as $review)
                        <div class="testimonial-slider">
                            <div class="testimonial-slider__icon">
                                <img src="{{ asset('frontend') }}/assets/images/icons/testimonial-icon.png"
                                    alt="" />
                            </div>
                            <p class="testimonial-slider__desc">
                                {!! $review->review !!}
                            </p>
                            <div class="testimonial-slider__details">
                                <h4 class="testimonial-slider__name">{{ $review->name }}</h4>
                                <span class="testimonial-slider__designation">{{ $review->profession }} </span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== Blog Start Here ==================== -->
<section class="blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="section-heading">
                    <h2 class="section-heading__subtitle">Blog Post</h2>
                    <h3 class="section-heading__title style-two">
                        Latest news post <span class="section-heading__bars"></span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center align-items-center">

            @forelse ($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xsm-6">
                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <a href="blog-details.html" class="blog-item__thumb-link">
                                <img src="{{ asset($blog->image) }}" alt="" />
                            </a>
                        </div>
                        <div class="blog-item__date">
                            <span
                                class="blog-item__month">{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span>
                            <span
                                class="blog-item__month">{{ \Carbon\Carbon::parse($blog->created_at)->format('M') }}</span>
                        </div>
                        <div class="blog-item__content">
                            <h4 class="blog-item__title">
                                <a href="blog-details.html" class="blog-item__title-link">{{ $blog->post_title }}
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            @empty
                <h4 class="mt-4">Blog post not found!!</h4>
            @endforelse


        </div>
    </div>
</section>
<!-- ==================== Blog End Here ==================== -->
<!--============================feature section start here =======================-->
<div class="feature-section bg-img py-60"
    style="
        background-image: url({{ asset('frontend') }}/assets/images/home/bg-banner.jpg);
      ">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f04.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">FREE SHIPPING</h5>
                        <span class="feature-item__payment">
                            For All Order Over $99
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f03.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">FRIENDLY SUPPORT</h5>
                        <span class="feature-item__payment">
                            24/7 Customer Support
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f02.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">SECURE PAYMENT</h5>
                        <span class="feature-item__payment">100% Secure Payment</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xxsm-6">
                <div class="feature-item">
                    <div class="feature-item__thumb">
                        <img src="{{ asset('frontend') }}/assets/images/thumbs/feature/f01.png" alt="" />
                    </div>
                    <div class="feature-item__info">
                        <h5 class="feature-item__title">SHIPPING & RETURN</h5>
                        <span class="feature-item__payment">
                            within 30days For Refund
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================feature setion end here ============================-->

@push('scripts')
    <script>
        const icons = document.querySelector(".floating-icons");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 140) {
                icons.classList.add("visible");
            } else {
                icons.classList.remove("visible");
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $(document).on('submit', '.add-to-cart-form', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                let button = form.find('.btn-buy');
                let spinner = button.find('.spinner-border');

                button.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: "{{ route('addToCart') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message, '', {
                            timeOut: 1500
                        });
                        $('#cart-count').text(response.cart_count);

                        // Optionally display the updated cart content if needed
                        console.log(response.cart_contents);

                        spinner.addClass('d-none');
                        button.prop('disabled', false);

                        $('#cart-count').text(response.itemCount);
                    },
                    error: function() {
                        toastr.error('Failed to add product.', '', {
                            timeOut: 2000
                        });
                        spinner.addClass('d-none');
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush

@include('website.layouts.inc.footer')

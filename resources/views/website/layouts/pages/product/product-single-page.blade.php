@section('title')
    Product Single Page
@endsection

@include('website.layouts.inc.header')

<style>
    .product-qty-wrapper {
        height: 40px;
    }

    .btn-qty {
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
        color: #333;
        background-color: #f8f9fa;
        border: none;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-qty:hover {
        background-color: #007bff;
        color: white;
    }

    .qty-input {
        width: 60px;
        text-align: center;
        font-weight: 500;
        font-size: 16px;
        padding: 0;
        outline: none;
    }
</style>

<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb py-120 bg-img"
    style="background-image: url({{ asset('frontend') }}/assets/images/thumbs/breadcumb-img.png)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcumb__wrapper">
                    <h1 class="breadcumb__title">{{ $product->product_name }}</h1>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item">
                            <a href="index.html" class="breadcumb__link">
                                <i class="las la-home"></i> Home</a>
                        </li>
                        <li class="breadcumb__item">/</li>
                        <li class="breadcumb__item">
                            <span class="breadcumb__item-text">
                                {{ $product->product_name }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->

@php
    $images = json_decode($product->images, true);
@endphp


<!-- ======================product details two section start here ====================-->
<div class="product-details-section">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7 pe-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-9 order-lg-2">
                        <div class="product-details__thumb">
                            @if (!empty($images) && is_array($images))
                                @foreach ($images as $key => $image)
                                    <a href="javascript:void(0)"
                                        class="product-details__image {{ $key == 0 ? 'show active' : '' }}">
                                        <img src="{{ asset($image) }}" alt="" />
                                    </a>
                                @endforeach
                            @else
                                <a href="javascript:void(0)" class="product-details__image">
                                    <img src="{{ asset($product->thumbnail) }}" alt="" />
                                </a>
                            @endif

                        </div>
                    </div>

                    <div class="col-lg-3 order-lg-1">
                        <ul class="product-details-gallery">
                            @if (!empty($images) && is_array($images) && count($images) > 0)
                                @foreach ($images as $key => $image)
                                    <li class="product-details-gallery__image {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image) }}" alt="" />
                                    </li>
                                @endforeach
                            @else
                                <li class="product-details-gallery__image active">
                                    <img src="{{ asset($product->thumbnail) }}" alt="" />
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>



            <div class="col-lg-5">
                <div class="product-info">
                    <h3 class="product-info__title">{{ $product->product_name }}</h3>
                    <div class="product-style">
                        <span class="product-style__title">Category : </span>
                        <span class="product-style__size">{{ $product->category->category_name }}</span>
                    </div>

                    <h6 class="product-info__price">
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

                    <p class="product-info__desc">
                        {!! $product->short_description !!}
                    </p>



                    <form class="add-to-cart-form mt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div
                            class="product-qty-wrapper d-inline-flex align-items-center border rounded overflow-hidden">
                            <button type="button" class="btn-qty minus px-3 py-2 border-end bg-light">
                                <i class="las la-minus"></i>
                            </button>
                            <input type="number" name="order_qty"
                                class="form-control text-center qty-input quantity-imput border-0" value="1"
                                min="1" style="max-width: 60px;">
                            <button type="button" class="btn-qty plus px-3 py-2 border-start bg-light">
                                <i class="las la-plus"></i>
                            </button>
                        </div>

                        {{-- <input type="hidden" name="order_qty" value="1"> --}}
                        <button type="submit" class="btn-snekers btn-snekers-primary btn--sm btn-buy">
                            Add To Cart
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>

                    </form>

                    {{-- <div class="product-info__button">
                        <a href="index.html" class="btn-snekers btn-snekers-primary product-info__link">BUY NOW</a>
                        <a href="wishlist.html" class="product-info__heart product-info__link"><i
                                class="fas fa-heart"></i></a>
                        <a href="cart.html" class="product-info__cart product-info__link"><i
                                class="fas fa-shopping-cart"></i></a>
                    </div> --}}
                    <div class="product-info__share">
                        <h6 class="product-info__share-text">Share :</h6>
                        <ul class="social-list style-four">
                            <li class="social-list__item">
                                <a href="https://www.facebook.com/" class="social-list__link"><i
                                        class="fab fa-facebook-f"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="https://www.twitter.com/" class="social-list__link">
                                    <i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="https://www.linkedin.com/" class="social-list__link">
                                    <i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="https://www.pinterest.com/" class="social-list__link">
                                    <i class="fab fa-pinterest-p"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================product details two section end here ====================-->

<!-- =====================tab section start here ========================-->
<div class="tab-section">
    <div class="container">
        <ul class="nav nav-pills mb-3 custom--tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                    Description
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-change-tab" data-bs-toggle="pill" data-bs-target="#pills-change"
                    type="button" role="tab" aria-controls="pills-change" aria-selected="false">
                    Faq
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <p class="tab-desc">
                    {!! $product->long_description !!}
                </p>
            </div>

            <div class="tab-pane fade" id="pills-change" role="tabpanel" aria-labelledby="pills-change-tab"
                tabindex="0">
                <p class="tab-desc">
                    pharetra gravida, orci magna rhoncus neque, id pulvinar odio lorem
                    non turpis. Nullam sit amet enim. Suspendisse id velit vitae
                    ligula volutpat condimentum. Aliquam erat volutpat. Sed quis
                    velit. Nulla facilisi. Nulla libero. Vivamus pharetra posuere
                    sapien. Nam consectetuer. Sed aliquam, nunc eget euismod
                    ullamcorper.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ==============tab section end here ==============-->

<!-- ==============related product section start here =========-->
<div class="related-product-custom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading style-two">
                    <h4 class="section-heading__title style-two">
                        Related Products<span class="section-heading__bars style-two"></span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row gy-4">

            @foreach ($relatedProducts as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xsm-6">
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
                            <div class="product-item__badge">
                                <span class="badge badge--base">Sale</span>
                            </div>
                        </div>
                        <div class="product-item__content">
                            <h5 class="product-item__title">
                                <a href="{{ route('product_single.page', $product->id) }}"
                                    class="product-item__title-link">
                                    {{ $product->product_name }}
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
                                <i class="fas fa-star-half-alt"></i>
                            </li>
                            <li class="product-info__number">4.8</li>
                        </ul> --}}
                            {{-- <h6 class="product-item__price">
                            <span class="product-item__price-new">$360</span> $310
                        </h6> --}}
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
            @endforeach
        </div>
    </div>
</div>
<!-- ===========related product section start here ===========-->


<!--============================feature section start here =======================-->
<div class="feature-section bg-img py-60"
    style="
        background-image: url({{ asset('frontend') }}/assets/images/thumbs/feature/feature-img.png);
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












@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const qtyWrappers = document.querySelectorAll(".product-qty-wrapper");

            qtyWrappers.forEach(wrapper => {
                const minusBtn = wrapper.querySelector(".minus");
                const plusBtn = wrapper.querySelector(".plus");
                const qtyInput = wrapper.querySelector(".qty-input");

                minusBtn.addEventListener("click", function() {
                    let currentVal = parseInt(qtyInput.value);
                    if (currentVal > 1) {
                        qtyInput.value = currentVal - 1;
                    }
                });

                plusBtn.addEventListener("click", function() {
                    let currentVal = parseInt(qtyInput.value);
                    qtyInput.value = currentVal + 1;
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            // Quantity increment
            $(document).on('click', '.plus', function() {
                let input = $(this).closest('form').find('.quantity-input');
                let current = parseInt(input.val()) || 1;
                input.val(current + 1);
            });

            // Quantity decrement
            $(document).on('click', '.minus', function() {
                let input = $(this).closest('form').find('.quantity-input');
                let current = parseInt(input.val()) || 1;
                if (current > 1) {
                    input.val(current - 1);
                }
            });

            // AJAX add to cart
            $(document).on('submit', '.add-to-cart-form', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                let button = form.find('.btn-add-to-cart');
                let spinner = button.find('.spinner-border');

                button.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: "{{ route('addToCart') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message, 'Success', {
                            timeOut: 1500
                        });

                        $('#cart-count').text(response.itemCount);
                        $('.cart-count').text(response.itemCount);

                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                    },
                    error: function() {
                        toastr.error('Failed to add product.', 'Error', {
                            timeOut: 2000
                        });
                        button.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
@endpush

@include('website.layouts.inc.footer')

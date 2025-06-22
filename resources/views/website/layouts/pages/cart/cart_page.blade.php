@section('title')
    Shoping Cart
@endsection

@include('website.layouts.inc.header')



<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb py-120 bg-img"
    style="background-image: url({{ asset('frontend') }}/assets/images/thumbs/breadcumb-img.png)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcumb__wrapper">
                    <h1 class="breadcumb__title">Your Shoping Cart</h1>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item">
                            <a href="{{ route('home') }}" class="breadcumb__link">
                                <i class="las la-home"></i> Home</a>
                        </li>
                        <li class="breadcumb__item">/</li>
                        <li class="breadcumb__item">
                            <span class="breadcumb__item-text"> Your Shoping Cart </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->

<!-- ================cart-section start here================ -->
<div class="cart-section" style="background-color: #f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="section-heading">
                    <h3 class="section-heading__title style-two">
                        Your Cart Items <span class="section-heading__bars"></span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table--responsive--lg cart-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Until Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="quantity-input-field">
                        @forelse ($cartContents as $productId => $cartItem)
                            <tr data-id="{{ $productId }}">
                                <td data-label="Product Name">
                                    <div class="customer">
                                        <div class="customer__thumb">
                                            <img src="{{ asset($cartItem['thumbnail']) }}" alt="" />
                                        </div>
                                        <div class="customer__content">
                                            <h6 class="customer__name">{{ $cartItem['name'] }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Until Price ">৳{{ number_format($cartItem['price'], 2) }}</td>
                                <td data-label="Qty">
                                    <div class="qty-cart d-flex style-two">
                                        <div class="product-qty product-quantity-form">
                                            <button type="button" class="cart-minus product-qty__decrement"
                                                data-action="decrease">
                                                <i class="las la-angle-down"></i>
                                            </button>
                                            <span class="custom-qty-input-field"><input type="number"
                                                    class="product-qty__value cart-qty"
                                                    value="{{ $cartItem['quantity'] }}" readonly /></span>
                                            <button type="button" class="cart-plus product-qty__increment"
                                                data-action="increase">
                                                <i class="las la-angle-up"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>


                                <td class="amount cart-price" data-label="Subtotal">
                                    ৳{{ number_format($cartItem['price'] * $cartItem['quantity'], 2) }}</td>

                                <td class="product-remove">
                                    <a class="remove-button" href="{{ route('removefrom.cart', $productId) }}"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <h4>Your cart is empty!</h4>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="continue-shoping-button">
                    <div class="shopping-cart mb-0">
                        <a href="{{ route('shop_page') }}"
                            class="btn-snekers btn-snekers-primary shopping-cart__pr mb-3">CONTINUE
                            SHOPPING</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="order-summery ms-auto">
                    <div class="order-summery__one d-flex justify-content-between">
                        <h6 class="order-summery__title">Subtotal</h6>
                        <span class="order-summery__number cart-subtotal">৳{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <div class="order-summery__two d-flex justify-content-between">
                        <h6 class="order-summery__title-two">Grand Total :</h6>
                        <span class="order-summery__number-two cart-total">৳{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <div class="checkout text-center">
                        <a href="{{ route('checkout.page') }}" class="btn-snekers btn-snekers-primary">PROCEED TO
                            CHECKOUT</a>
                        <p class="checkout__desc">Checkout With Multiple Addresses</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ===============cart section end here ==================-->

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

<!-- ==========================feature setion end here ============================-->


@push('scripts')
    <script>
        $(document).on('click', '.cart-minus, .cart-plus', function(e) {
            e.preventDefault();

            let $btn = $(this);
            let $row = $btn.closest('tr');
            let productId = $row.data('id');
            let action = $btn.data('action');

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    action: action,
                },
                success: function(response) {
                    if (response.success) {
                        $row.find('.cart-qty').val(response.quantity);
                        $row.find('.cart-price').text('৳' + response.subtotal);

                        // Update total amount
                        $('.cart-subtotal').text('৳' + response.totalAmount);
                        $('.cart-total').text('৳' + response.totalAmount);

                        $('#cart-count').text(response.itemCount);
                    }
                }
            });
        });
    </script>
@endpush


@include('website.layouts.inc.footer')

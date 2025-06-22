@include('website.layouts.inc.header')
<!-- ==================== Breadcumb Start Here ==================== -->
<section class="breadcumb py-120 bg-img" style="background-image: url({{ asset('frontend') }}/assets/images/thumbs/breadcumb-img.png)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcumb__wrapper">
                    <h1 class="breadcumb__title">Order Confirmation</h1>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item">
                            <a href="{{ route('home') }}" class="breadcumb__link">
                                <i class="las la-home"></i> Home</a>
                        </li>
                        <li class="breadcumb__item">/</li>
                        <li class="breadcumb__item">
                            <span class="breadcumb__item-text"> Confrimation </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcumb End Here ==================== -->

<section id="confirmation-page-section" class="mt-5 mb-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 p-5 text-center bg-light">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success confirm-icon" style="font-size: 4rem;"></i>
                <h2 class="mt-3 text-success confirm-icon">Order Placed Successfully!</h2>
            </div>

            @if (isset($order))
                <p class="lead">
                    Thank you for shopping with <strong>Munna And Brothers</strong>.<br>
                    Your order ID is <span class="badge bg-danger">{{ $order->order_id }}</span>.
                </p>

                @if ($order->orderItems && count($order->orderItems) > 0)
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->product_name ?? 'Product not found' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 2) }} TK</td>
                                        <td>{{ number_format($item->quantity * $item->price, 2) }} TK</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-end">Shipping Cost:</th>
                                    <th>{{ number_format($order->shipping_charge, 2) }} TK</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Grand Total:</th>
                                    <th class="text-success confirm-icon">{{ number_format($order->total_price, 2) }} TK</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-danger">No items found in this order.</p>
                @endif
            @else
                <p class="text-danger">Order information not found.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('shop_page') }}" class="btn btn-lg px-4 continue-shoping">
                    <i class="fas fa-shopping-cart me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</section>

@include('website.layouts.inc.footer')

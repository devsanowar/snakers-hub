<div class="col-lg-4 col-md-6 col-sm-6 col-xsm-6 mob-version-product">
    <div class="product-item">
        <div class="product-item__thumb">
            <a href="{{ route('product_single.page', $product->id) }}" class="product-item__thumb-link">
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
                <a href="{{ route('product_single.page', $product->id) }}" class="product-item__title-link">
                    {{ $product->product_name }}
                </a>
            </h5>

            <h6 class="product-item__price">
                @if ($product->discount_price && $product->discount_type === 'flat')
                    @php
                        $product_discount_price = $product->regular_price - $product->discount_price;
                    @endphp
                    <span class="product-item__price-new">৳{{ number_format($product_discount_price, 2) }}</span>
                    <span class="text-decoration-line-through">৳{{ number_format($product->regular_price, 2) }}</span>
                @elseif ($product->discount_price && $product->discount_type === 'percent')
                    @php
                        $discount_amount = ($product->regular_price * $product->discount_price) / 100;
                        $product_discount_price = $product->regular_price - $discount_amount;
                    @endphp
                    <span class="product-item__price-new">৳{{ number_format($product_discount_price, 2) }}</span>
                    <span class="text-decoration-line-through">৳{{ number_format($product->regular_price, 2) }}</span>
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

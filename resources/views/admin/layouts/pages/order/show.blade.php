@extends('admin.layouts.app')
@section('title', 'Order Details Page')
@push('styles')
<!-- Print Styling to hide button-->
<style>
    @media print {
        body {
            visibility: hidden;
        }

        .container {
            visibility: visible;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        button {
            display: none;
            /* Hide buttons */
        }



    }
</style>
@endpush

@section('admin_content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
            @php
                $setting = App\Models\WebsiteSetting::first();
            @endphp

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Payment Information</h4>
                    <button class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
                </div>
                <div class="card-body" id="invoice">
                    <div class="container border p-4">
                        <h2 class="text-center mb-4"><img style="width:20%" src="{{ asset($setting->website_logo) }}" alt="Logo" /></h2>
                        <h5 class="text-center text-muted mb-4">Invoice</h5>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Customer Information</h5>
                                <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                                <p><strong>Address:</strong> {{ $order->address }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5>Invoice Information</h5>
                                <p><strong>Invoice Number: </strong>#{{ $order->order_id }}</p>
                                <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
                                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            </div>
                        </div>

                        <table class="table table-bordered mt-4">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            @php
                                $subtotal = 0;
                            @endphp

                            <tbody>
                                @foreach ($order->orderItems as $key => $orderItem)
                                 @php
                                    $total = $orderItem->price * $orderItem->quantity;
                                    $subtotal += $total;
                                @endphp

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $orderItem->product->product_name }}</td>
                                    <td>{{ $orderItem->price }}</td>
                                    <td>{{ $orderItem->quantity }}</td>
                                    <td>{{ $orderItem->quantity * $orderItem->price }}</td>
                                </tr>
                                @endforeach
                                <tr class="custom-tr-class">
                                    <th colspan="4" style="text-align:right">Sub Total:</th>
                                    <th>{{ number_format($subtotal, 2)}} TK</th>
                                </tr>

                                <tr class="custom-tr-class">
                                    <th colspan="4" style="text-align:right">Shipping Cost:</th>
                                    <th>{{ number_format($order->shipping_charge, 2) }} TK</th>
                                </tr>
                                <tr class="custom-tr-class">
                                    <th colspan="4" style="text-align:right">Grand Total:</th>
                                    <th class="text-success">{{ number_format($order->total_price, 2) }} TK</th>
                                </tr>

                            </tbody>
                        </table>

                        {{-- <div class="row mt-3">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">
                                <p><strong>Shipping Charge:</strong> TK.</p>
                                <h5><strong>Total: TK.</strong></h5>
                            </div>
                        </div> --}}

                        <p class="text-center mt-4">Thank you for your purchase!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')

<script>
    function printInvoice() {
        var printContent = document.getElementById('invoice').innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>

@endpush

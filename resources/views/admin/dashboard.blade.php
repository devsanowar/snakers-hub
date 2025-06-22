@extends('admin.layouts.app')


@section('admin_content')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <h2>Dashboard
                    <small class="text-muted">Welcome to {{ $website_setting->website_title }} web application</small>
                </h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="breadcrumb" id="dashboard-tabs" style="gap: 10px;">
                    <li><button class="btn btn-primary filter-btn active" data-days="1">1 Day</button></li>
                    <li><button class="btn btn-primary filter-btn" data-days="7">7 Days</button></li>
                    <li><button class="btn btn-primary filter-btn" data-days="15">15 Days</button></li>
                    <li><button class="btn btn-primary filter-btn" data-days="{{ now()->daysInMonth }}">30/31 Days</button></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" target="_blank">
                        <i class="zmdi zmdi-home"></i> {{ $website_setting->website_title }}</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix" id="dashboard-stats">
            @php
                $cards = [
                    ['icon' => 'zmdi-money-box', 'value' => $total_order_amount, 'label' => 'Total Sale'],
                    ['icon' => 'zmdi-shopping-cart', 'value' => $order_count, 'label' => 'Total Orders'],
                    ['icon' => 'zmdi-shopping-cart', 'value' => $pending_order_count, 'label' => 'Pending Orders'],
                    ['icon' => 'zmdi-shopping-cart', 'value' => $cancelled_order_count, 'label' => 'Cancelled Orders'],
                    ['icon' => 'zmdi-confirmation-number', 'value' => $confirmed_order_count, 'label' => 'Confirmed Order'],
                    ['icon' => 'zmdi-shopping-cart', 'value' => $shipped_order_count, 'label' => 'Shipped Order'],
                    ['icon' => 'zmdi-check-all', 'value' => $delivered_order_count, 'label' => 'Delivered Orders'],
                    ['icon' => 'zmdi-accounts', 'value' => $user_count, 'label' => 'Users'],
                    ['icon' => 'zmdi-email', 'value' => $message_count, 'label' => 'Inbox'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                    <div class="card tasks_report">
                        <div class="body">
                            <span class="dashboard-icons"><i class="zmdi {{ $card['icon'] }}"></i></span>
                            <h2 class="mt-3">{{ $card['value'] }}</h2>
                            <p>{{ $card['label'] }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function loadDashboardStats(days = 1) {
        $.ajax({
            url: "{{ route('admin.dashboard.filter') }}",
            method: "GET",
            data: { days: days },
            success: function(response) {
                let statsHtml = '';
                const cards = [
                    { icon: 'zmdi-money-box', value: response.total_order_amount, label: 'Total Sale' },
                    { icon: 'zmdi-shopping-cart', value: response.order_count, label: 'Total Orders' },
                    { icon: 'zmdi-shopping-cart', value: response.pending_order_count, label: 'Pending Orders' },
                    { icon: 'zmdi-shopping-cart', value: response.cancelled_order_count, label: 'Cancelled Orders' },
                    { icon: 'zmdi-confirmation-number', value: response.confirmed_order_count, label: 'Confirmed Order' },
                    { icon: 'zmdi-shopping-cart', value: response.shipped_order_count, label: 'Shipped Order' },
                    { icon: 'zmdi-check-all', value: response.delivered_order_count, label: 'Delivered Orders' },
                    { icon: 'zmdi-accounts', value: response.user_count, label: 'Users' },
                    { icon: 'zmdi-email', value: response.message_count, label: 'Inbox' },
                ];

                cards.forEach(card => {
                    statsHtml += `
                        <div class="col-lg-3 col-md-6 col-sm-12 text-center">
                            <div class="card tasks_report">
                                <div class="body">
                                    <span class="dashboard-icons"><i class="zmdi ${card.icon}"></i></span>
                                    <h2 class="mt-3">${card.value}</h2>
                                    <p>${card.label}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#dashboard-stats').html(statsHtml);
            },
            error: function() {
                alert("Something went wrong while fetching dashboard data.");
            }
        });
    }

    $(document).ready(function() {
        // প্রথমে ডিফল্ট ডাটা লোড করুন
        loadDashboardStats(1);

        // বাটনে ক্লিক ইভেন্ট হ্যান্ডল করুন
        $('.filter-btn').on('click', function() {
            // active ক্লাস পরিবর্তন
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');

            let days = $(this).data('days');
            loadDashboardStats(days);
        });
    });
</script>
@endpush

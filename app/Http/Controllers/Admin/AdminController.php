<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user_count = User::count();
        $order_count = Order::count();
        $total_order_amount = Order::sum('total_price');
        $message_count = Contact::count();
        $website_setting = WebsiteSetting::first();

        $status_counts = Order::select('status', DB::raw('count(*) as count'))
            ->whereIn('status', ['pending', 'cancelled', 'confirmed', 'shipped', 'delivered'])
            ->groupBy('status')
            ->pluck('count', 'status');

        $pending_order_count = $status_counts['pending'] ?? 0;
        $cancelled_order_count = $status_counts['cancelled'] ?? 0;
        $confirmed_order_count = $status_counts['confirmed'] ?? 0;
        $shipped_order_count = $status_counts['shipped'] ?? 0;
        $delivered_order_count = $status_counts['delivered'] ?? 0;

        return view('admin.dashboard', compact(
            'user_count',
            'order_count',
            'total_order_amount',
            'message_count',
            'website_setting',
            'pending_order_count',
            'cancelled_order_count',
            'confirmed_order_count',
            'shipped_order_count',
            'delivered_order_count'
        ));
    }


public function filterDashboardData(Request $request)
{
    $days = (int) $request->input('days', 1);

    if ($days === 1) {
        $fromDate = Carbon::today(); // আজকের শুরু
        $toDate = Carbon::now();     // এখন পর্যন্ত
    } else {
        $fromDate = Carbon::now()->subDays($days);
        $toDate = Carbon::now();
    }

    $user_count = User::whereBetween('created_at', [$fromDate, $toDate])->count();
    $order_count = Order::whereBetween('created_at', [$fromDate, $toDate])->count();
    $total_order_amount = Order::whereBetween('created_at', [$fromDate, $toDate])->sum('total_price');
    $message_count = Contact::whereBetween('created_at', [$fromDate, $toDate])->count();

    // $status_counts = Order::select('status', DB::raw('count(*) as count'))
    //     ->whereBetween('created_at', [$fromDate, $toDate])
    //     ->whereIn('status', ['pending', 'cancelled', 'confirmed', 'shipped', 'delivered'])
    //     ->groupBy('status')
    //     ->pluck('count', 'status');

    $status_counts = Order::select('status', DB::raw('count(*) as count'))
                ->whereBetween(DB::raw('COALESCE(status_updated_at, updated_at)'), [$fromDate, $toDate])
                ->whereIn('status', ['pending', 'cancelled', 'confirmed', 'shipped', 'delivered'])
                ->groupBy('status')
                ->pluck('count', 'status');


    return response()->json([
        'user_count' => $user_count,
        'order_count' => $order_count,
        'total_order_amount' => $total_order_amount,
        'message_count' => $message_count,
        'pending_order_count' => $status_counts['pending'] ?? 0,
        'cancelled_order_count' => $status_counts['cancelled'] ?? 0,
        'confirmed_order_count' => $status_counts['confirmed'] ?? 0,
        'shipped_order_count' => $status_counts['shipped'] ?? 0,
        'delivered_order_count' => $status_counts['delivered'] ?? 0,
    ]);
}



}

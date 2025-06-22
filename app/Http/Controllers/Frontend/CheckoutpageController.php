<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Shipping;
use App\Models\Orderitem;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Models\Paymentmethod;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Blocklist;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutpageController extends Controller
{
    public function checkoutPage()
    {
        $cartContents = session()->get('cart', []);

        if (empty($cartContents)) {
            return back()->with('error', 'আপনার কার্টে কোনো পণ্য নেই! অনুগ্রহ করে প্রথমে পণ্য যোগ করুন।');
        }

        $totalAmount = 0;
        foreach ($cartContents as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $districts = District::with('upazilas')->get();
        $shippings = Shipping::where('is_active', 1)->get();
        $paymentMethods = Paymentmethod::where('is_active', 1)->get(['id', 'name', 'method_type']);
        return view('website.layouts.pages.checkout.checkout', compact(['cartContents', 'totalAmount', 'districts', 'shippings', 'paymentMethods']));
    }

    public function getUpazilas($district_id)
    {
        $upazilas = Upazila::where('district_id', $district_id)->select('id', 'upazila_name')->get();

        return response()->json($upazilas);
    }

    public function placeOrder(Request $request, SmsService $smsService)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => ['required', 'regex:/^(01[3-9][0-9]{8}|\+8801[3-9][0-9]{8})$/'],
            'district_id' => 'required|exists:districts,id',
            'upazila_id' => 'required|exists:upazilas,id',
            'address' => 'required|string',
            'payment_method' => 'required|string|max:50',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'কার্ট খালি!');
        }

        $blockNumber = Blocklist::pluck('number')->toArray();

        if (in_array($request->phone, $blockNumber)) {
            return back()->with('error', 'দুঃখিত, মোবাইল নম্বরটি ব্লক করা হয়েছে। অনুগ্রহ করে একটি বৈধ নম্বর প্রদান করুন।');
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // শিপিং চার্জ
        $shipping_charge = 0;
        if ($request->has('shipping_charge') && floatval($request->shipping_charge) > 0) {
            $shipping_charge = floatval($request->shipping_charge);
            $total += $shipping_charge;
        }

        $order = Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'district_id' => $request->district_id,
            'upazila_id' => $request->upazila_id,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'transaction_number' => $request->transaction_number ?? null,
            'transaction_id' => $request->transaction_id ?? null,
            'shipping_charge' => $shipping_charge,
            'total_price' => $total,
            'status' => 'pending',
            'order_id' => 'MB-' . strtoupper(uniqid()),
        ]);

        foreach ($cart as $item) {
            Orderitem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        // $this->sendOrderConfirmationSMS($request->phone, $order);

        $smsService->sendOrderConfirmationSMS($request->phone, $order);

        return redirect()->route('order.confirmation', $order->id)->with('success', 'অর্ডার সফল হয়েছে!');
    }

    public function showOrderConfirmation($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        return view('website.layouts.pages.order.confirmation', compact('order'));
    }

    // private function sendOrderConfirmationSMS($mobile, $order)
    // {
    //     $apiUrl = 'https://portal.adnsms.com/api/v1/secure/send-sms';

    //     $message = "সম্মানিত গ্রাহক,\n" . 'আপনার অর্ডারটি সফলভাবে গ্রহন করা হয়েছে।' . "আপনার অর্ডার নং: #$order->order_id\n\n" . 'বিল এমাউন্ট: ' . "$order->total_price" . " টাকা\n\n" . "\n Mymensingh Pet Shop \n" . '01610608606';

    //     $data = [
    //         'api_key' => 'KEY-gtdu11carybws8n5hm31h8z3qpn51x0e',
    //         'api_secret' => 'eGLXoyke0eRzYZI5',
    //         'request_type' => 'single_sms',
    //         'message_type' => 'UNICODE',
    //         'mobile' => $mobile,
    //         'message_body' => $message,
    //     ];

    //     $curl = curl_init();

    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl, CURLOPT_URL, $apiUrl);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($curl, CURLOPT_POST, 1);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    //     $response = json_decode(curl_exec($curl), true); // Decode response to array

    //     $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //     curl_close($curl);

    //     if ($httpCode == 200 && isset($response['api_response_code']) && $response['api_response_code'] == 200) {
    //         Log::info('SMS sent successfully: ' . json_encode($response));
    //     } else {
    //         Log::error('SMS sending failed: ' . json_encode($response));
    //     }
    // }


}

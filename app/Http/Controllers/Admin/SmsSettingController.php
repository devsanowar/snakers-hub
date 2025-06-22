<?php

namespace App\Http\Controllers\Admin;

use App\Models\SmsLog;
use Illuminate\Support\Carbon;
use App\Models\SmsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class SmsSettingController extends Controller
{
    public function edit()
    {
        $setting = SmsSetting::first(); // একটাই row থাকবে ধরে নিচ্ছি
        return view('admin.layouts.pages.sms-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
            'api_key' => 'required',
            'api_secret' => 'required',
            'request_type' => 'required',
            'message_type' => 'required',
            'default_message' => 'required',
        ]);

        $setting = SmsSetting::first();

        $setting->update([
            'api_url' => $request->api_url,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'request_type' => $request->request_type,
            'message_type' => $request->message_type,
            'default_message' => $request->default_message,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'SMS Settings updated successfully!');
    }

    public function moblie_sms()
    {
        return view('admin.layouts.pages.sms.moblie_sms');
    }

    public function custom_sms()
    {
        return view('admin.layouts.pages.sms.custom_sms');
    }

    public function sendCustomSms(Request $request)
    {
        $request->validate([
            'mobile_numbers' => 'required|string',
            'message' => 'required|string|max:1080',
        ]);

        $apiKey = 'KEY-gtdu11carybws8n5hm31h8z3qpn51x0e';
        $apiSecret = 'eGLXoyke0eRzYZI5';
        $apiUrl = 'https://portal.adnsms.com/api/v1/secure/send-sms';

        $mobileNumbers = explode(',', str_replace(' ', '', $request->mobile_numbers));
        $message = $request->input('message');
        $totalCharacters = strlen($message);
        $totalMessageParts = ceil($totalCharacters / 160); // SMS message part calculation

        foreach ($mobileNumbers as $mobile) {
            if (!preg_match('/^\d{10,15}$/', $mobile)) {
                return back()->with('error', "Invalid mobile number: $mobile");
            }

            $data = [
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
                'request_type' => 'single_sms',
                'message_type' => 'UNICODE',
                'mobile' => $mobile,
                'message_body' => $message,
            ];

            $response = Http::post($apiUrl, $data);

            if ($response->failed()) {
                return back()->with('error', "Failed to send SMS to $mobile");
            }

            // Save SMS details in the database
            SmsLog::create([
                'delivery_date' => Carbon::now()->toDateString(),
                'delivery_time' => Carbon::now()->toTimeString(),
                'mobile' => $mobile,
                'message' => $message,
                'total_characters' => $totalCharacters,
                'total_message' => $totalMessageParts,
                'delivery_report' => $response->json()['status'] ?? 'success', // Adjust based on API response
            ]);
        }

        return back()->with('success', 'SMS sent successfully!');
    }

    public function sms_report()
    {
        return view('admin.layouts.pages.sms.sms_report');
    }
}

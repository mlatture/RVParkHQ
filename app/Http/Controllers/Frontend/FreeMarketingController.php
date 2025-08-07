<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class FreeMarketingController extends Controller
{
    public function index()
    {
        return view('frontend.pages.free-marketing.index');
    }

    public function marketingSchedule(Request $request)
    {
        SystemLog::create([
            'transaction_type' => 'marketing_schedule',
            'ip_address' => $request->Ip(),
            'page' => $request->input('page'),
        ]);

        return response()->json(['status' => 'logged']);
    }

}

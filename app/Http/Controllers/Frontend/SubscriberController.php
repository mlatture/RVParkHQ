<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Services\Frontend\SubscriberService;

class SubscriberController extends Controller
{
    protected $service;

    public function __construct(SubscriberService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $response = $this->service->handleStore($request->email);

            return redirect()->back()->with([
                'icon' => $response['type'],
                'success' => $response['message']
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'icon' => 'error',
                'success' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function conformSubscribe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'required|email',
            'token' => 'required|string|uuid',
        ]);

        try {
            $response = $this->service->handleConfirmation([
                'name' => $request->name,
                'zip_code' => $request->zip_code,
                'email' => $request->email,
                'token' => $request->token,
            ]);

            return redirect()->route('rv-park.home')->with([
                'icon' => $response['type'],
                'success' => $response['message']
            ]);
        } catch (\Exception $e) {
            return redirect()->route('rv-park.home')->with([
                'icon' => 'error',
                'success' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function index(Request $request)
    {
        $pending = Subscriber::where('token', $request->token)->first();

        if (!$pending) {
            return redirect()->route('rv-park.home')->with([
                'icon' => 'success',
                'success' => "You are already subscribed."
            ]);
        }

        return view('frontend.pages.subscription.index', compact('pending'));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdInquiries;
use App\Mail\AdvertiseStatusChangedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['advertise.view']);
        $advertise = AdInquiries::search($request->search)->paginate(10);
        return view('backend.pages.advertise.index', compact('advertise'));
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['advertise.edit']);
        $advertise = AdInquiries::findOrFail($id);
        return view('backend.pages.advertise.edit', compact('advertise'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['advertise.edit']);
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'company'  => 'nullable|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:50',
            'interest' => 'required|in:featured,banner,sponsored,newsletter,sponsorship,other',
            'message'  => 'nullable|string|max:1000',
            'status'   => 'required|in:pending,approved,rejected',
        ]);

        $inquiry = AdInquiries::findOrFail($id);
        $inquiry->update($validated);
        
        $data = [
            'name' => $inquiry->name,
            'company' => $inquiry->company,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'interest' => $inquiry->interest,
            'message' => $inquiry->message,
            'status' => $inquiry->status,
        ];
        Mail::to($inquiry->email)->send(new AdvertiseStatusChangedMail($data));

        return redirect()
            ->route('admin.advertise.index')
            ->with('success', 'Advertise inquiry updated successfully.');
    }


    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['advertise.delete']);
        $advertise = AdInquiries::findOrFail($id);
        $advertise->delete();

        return redirect()->back()->with('success', 'Advertise deleted successfully.');
    }
}
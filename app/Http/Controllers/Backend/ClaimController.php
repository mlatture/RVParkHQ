<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Mail\ClaimStatusUpdatedMail;
use App\Models\ClaimPark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $claimParks = ClaimPark::with(['park', 'user'])
            ->filter($request->only(['park', 'user']))
            ->paginate(10);

        return view('backend.pages.claimPark.index', compact('claimParks'));
    }

    public function edit($id)
    {
        $claimPark = ClaimPark::findorFail($id)->with(['park', 'user'])->first();
        return view('backend.pages.claimPark.edit', compact('claimPark'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $claimPark = ClaimPark::findorFail($id);
        $claimPark->update(['status' => $validated['status']]);

        Mail::to($claimPark->user)->send(new ClaimStatusUpdatedMail($claimPark));

        return redirect()->route('admin.claim.index')->with([
            'icon' => 'success',
            'success' => 'Status updated successfully'
        ]);
    }

    public function destroy($id)
    {
        ClaimPark::findorFail($id)->delete();

        return redirect()->route('admin.claim.index')->with([
            'icon' => 'success',
            'success' => 'Claim Park delete successfully'
        ]);
    }
}

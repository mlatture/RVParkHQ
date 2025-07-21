<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Mail\ClaimStatusUpdatedMail;
use App\Models\ClaimPark;
use App\Models\ClaimParkSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['claim_park.view']);
        
        $claimParks = ClaimPark::with(['park', 'user'])
            ->filter($request->only(['park', 'user']))
            ->paginate(10);

        return view('backend.pages.claimPark.index', compact('claimParks'));
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['claim_park.edit']);
        
        $claimPark = ClaimPark::findorFail($id)->with(['park', 'user'])->first();
        return view('backend.pages.claimPark.edit', compact('claimPark'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['claim_park.edit']);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $claimPark = ClaimPark::findorFail($id);
        $claimPark->update(['status' => $validated['status']]);
        if ($claimPark->status == 'approved') {
            $user = User::where('email', $claimPark->contact_email)->first();
            $ClaimParkSubmission = ClaimParkSubmission::where('email', $claimPark->contact_email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => explode('@', $claimPark->contact_email)[0],
                    'username' => explode('@', $claimPark->contact_email)[0],
                    'email' => $claimPark->contact_email,
                    'phone' => $claimPark->contact_phone,
                    'password' => $ClaimParkSubmission->password,
                    'email_verified_at' => now(),
                    'type' => 'owner',
                ]);
                $user->assignRole('owner');
            }
            $claimPark->update(['user_id' => $user->id]);
        }

        Mail::to($claimPark->contact_email)->send(new ClaimStatusUpdatedMail($claimPark));

        return redirect()->route('admin.claim.index')->with([
            'icon' => 'success',
            'success' => 'Status updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['claim_park.delete']);
        
        ClaimPark::findorFail($id)->delete();

        return redirect()->route('admin.claim.index')->with([
            'icon' => 'success',
            'success' => 'Claim Park delete successfully'
        ]);
    }
}

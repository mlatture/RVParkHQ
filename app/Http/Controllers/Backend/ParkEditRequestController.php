<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ParkEditRequest;
use App\Models\Park;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ParkRequestToAdminMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParkRequestStatusToOwnerMail;

class ParkEditRequestController extends Controller
{
    public function index(Request $request)
    {
        $ParkEditRequests = ParkEditRequest::with('park', 'owner')
            ->search($request->search)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('backend.pages.parkRequest.index', compact('ParkEditRequests'));
    }

    public function edit($id)
    {
        $ParkEditRequest = ParkEditRequest::with('park', 'owner')->findOrFail($id);
        return view('backend.pages.parkRequest.edit', compact('ParkEditRequest'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $editRequest = ParkEditRequest::findOrFail($id);
        $editRequest->status = $request->status;
        $editRequest->save();

        // Send email to owner when approved/rejected
        if (in_array($editRequest->status, ['approved', 'rejected'])) {
            $owner = $editRequest->owner;
            $park = $editRequest->park;
            if ($owner && $park) {
                \Mail::to($owner->email)->send(new ParkRequestStatusToOwnerMail($owner, $park, $editRequest->status));
            }
        }

        return redirect()->route('admin.park-request.index')
            ->with('success', 'Park request status updated successfully.');
    }

    public function destroy($id)
    {
        $editRequest = ParkEditRequest::findOrFail($id);
        $editRequest->delete();

        return redirect()->route('admin.park-request.index')
            ->with('success', 'Park request deleted successfully.');
    }


    public function suggest($parkId)
    {
        $user = auth()->user();
        $park = Park::findOrFail($parkId);
        if ($park->owner_id == $user->id) {
            return redirect()->back()->with('error', 'You already own this park.');
        }
        $existing = ParkEditRequest::where('park_id', $parkId)
            ->where('owner_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Request already exists or approved.');
        }
        ParkEditRequest::create([
            'park_id' => $parkId,
            'owner_id' => $user->id,
            'status' => 'pending',
        ]);

        Mail::to('mark@latture.com')->send(new ParkRequestToAdminMail($user, $park));

        return redirect()->back()->with('success', 'Request sent to admin.');
    }

}

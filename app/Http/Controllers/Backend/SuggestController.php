<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ParkRequestToAdminMail;
use App\Mail\SuggestMail;
use App\Mail\SuggestStatusChangeMail;
use App\Models\Park;
use App\Models\SuggestPark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SuggestController extends Controller
{
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['suggest-park.view']);
        
        $suggests = SuggestPark::search($request->search)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('backend.pages.suggest-park.index', compact('suggests'));
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['suggest-park.edit']);
        
        $suggest = SuggestPark::findOrFail($id);
        return view('backend.pages.suggest-park.edit', compact('suggest'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['suggest-park.edit']);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $editRequest = SuggestPark::findOrFail($id);
        $editRequest->status = $request->status;
        $editRequest->save();

        if (in_array($request->status, ['approved', 'rejected'])) {
            $park = Park::where('name', $editRequest->park_name)->first();
            if ($park) {
                Mail::to($editRequest->user_email)->send(new SuggestStatusChangeMail($park, $editRequest->status));
            }
        }

        if ($editRequest->status === 'approved') {
            $existingPark = Park::where('name', $editRequest->park_name)->first();

            if (!$existingPark) {
                $slug = Str::slug($editRequest->park_name);

                $slugCount = Park::where('slug', $slug)->count();
                if ($slugCount > 0) {
                    $slug .= '-' . ($slugCount + 1);
                }

                $slugPath = implode('-', array_filter([
                    Str::slug($editRequest->country),
                    Str::slug($editRequest->state),
                    Str::slug($editRequest->city),
                    $slug,
                ]));

                $park = Park::create([
                    'name'              => $editRequest->park_name,
                    'slug'              => $slug,
                    'description'       => null,
                    'short_description' => null,
                    'address'           => null,
                    'city'              => $editRequest->city,
                    'state'             => $editRequest->state,
                    'country'           => $editRequest->country,
                    'postal_code'       => $editRequest->zip,
                    'latitude'          => null,
                    'longitude'         => null,
                    'phone'             => $editRequest->phone,
                    'email'             => $editRequest->email,
                    'website_url'       => $editRequest->website_url,
                    'status'            => 'active',
                    'is_featured'       => false,
                    'main_image_url'    => null,
                    'slug_path'         => $slugPath,
                ]);
            }
        }

        return redirect()->route('admin.suggest-park.index')->with('success', 'Suggest Park status updated successfully.');
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['suggest-park.delete']);
        
        $editRequest = SuggestPark::findOrFail($id);
        $editRequest->delete();

        return redirect()->route('admin.suggest-park.index')->with('success', 'Suggest Park deleted successfully.');
    }

    public function suggest()
    {
        $suggest = SuggestPark::where('user_email', auth()->user()->email)->exists();
        if ($suggest){
            return redirect()->back()->with('success', 'You Already Suggestion Park.');
        }
        return view('backend.pages.suggest-park.apply');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'park_name'      => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:100',
            'zip'            => 'nullable|string|max:20',
            'website_url'    => 'nullable|url|max:255',
            'email'             => 'required|email|max:255|unique:suggest_park,email',
            'phone'          => 'nullable|string|max:20',
            'user_name'      => 'required|string|max:255',
            'user_email'     => 'required|email|max:255',
            'submitted_by'     => 'required',
            'address_line_1'     => 'required|string|max:255',
            'address_line_2'     => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:1000',
        ]);

        $validated['user_name'] = auth()->user()->name;
        $validated['user_email'] = auth()->user()->email;

        SuggestPark::create($validated);
        
        Mail::to(config('mail.notification_email'))->send(new SuggestMail((object)$validated));
        
        return redirect()->route('admin.parks.index')->with([
            'icon' => 'success',
            'success' => 'Thank you! Your suggested park has been submitted.'
        ]);
    }
}

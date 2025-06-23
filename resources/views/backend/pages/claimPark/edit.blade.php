@extends('backend.layouts.app')

@section('title')
    {{ __('Claim Park View') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Claim Park View') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Claim Park Details') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                               href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                               href="{{ route('admin.claim.index') }}">
                                {{ __('Claim Parks') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('View') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Park Claim Details') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')
                    <form action="{{ route('admin.claim.update', $claimPark->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-4 mb-5">
                            <div class="flex-1">
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Status') }}
                                </label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                                    <option value="pending" {{ $claimPark->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="approved" {{ $claimPark->status == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                    <option value="rejected" {{ $claimPark->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Park Name') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->park->name ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('User Email') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->user->email ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Contact & Ownership Verification -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Contact & Ownership Verification') }}</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Full Name') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->contact_name ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Email Address') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->contact_email ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Phone Number') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->contact_phone ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Role at Park') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->contact_role ?? 'N/A' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Own or Manage Park?') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->is_owner_or_manager ? 'Yes' : 'No' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Booking URL') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    @if($claimPark->booking_url)
                                        <a href="{{ $claimPark->booking_url }}" target="_blank"
                                           class="text-blue-600 hover:underline">{{ $claimPark->booking_url }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Facebook Page') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    @if($claimPark->facebook_url)
                                        <a href="{{ $claimPark->facebook_url }}" target="_blank"
                                           class="text-blue-600 hover:underline">{{ $claimPark->facebook_url }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Instagram Page') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    @if($claimPark->instagram_url)
                                        <a href="{{ $claimPark->instagram_url }}" target="_blank"
                                           class="text-blue-600 hover:underline">{{ $claimPark->instagram_url }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>

                            <!-- RV & Tent Site Inventory -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('RV & Tent Site Inventory') }}</h4>
                            </div>

                            @php
                                $siteTypes = [
                                    'sites_50amp_full' => '50 Amp Full Hookup Sites',
                                    'sites_30amp_full' => '30 Amp Full Hookup Sites',
                                    'sites_30amp_water_electric' => '30 Amp Water & Electric Sites',
                                    'sites_50amp_water_electric' => '50 Amp Water & Electric Sites',
                                    'sites_30amp_electric' => '30 Amp Electric Only Sites',
                                    'sites_50amp_electric' => '50 Amp Electric Only Sites',
                                    'sites_dry_camping' => 'No Hookup RV Sites (Dry Camping)',
                                    'tent_sites_utilities' => 'Tent Sites (with utilities)',
                                    'tent_sites_primitive' => 'Tent Sites (primitive)',
                                    'seasonal_sites' => 'Seasonal RV Sites',
                                    'group_campsites' => 'Group Campsites'
                                ];
                            @endphp

                            @foreach($siteTypes as $field => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __($label) }}
                                    </label>
                                    <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                        {{ $claimPark->$field ?? 0 }}
                                    </div>
                                </div>
                            @endforeach

                        <!-- Cabins & Rentals -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Cabins & Rentals') }}</h4>
                            </div>

                            @php
                                $rentalTypes = [
                                    'deluxe_cabins' => 'Deluxe Cabins (AC & Bath)',
                                    'primitive_cabins' => 'Primitive Cabins',
                                    'yurts_glamping' => 'Yurts / Glamping Tents'
                                ];
                            @endphp

                            @foreach($rentalTypes as $field => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __($label) }}
                                    </label>
                                    <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                        {{ $claimPark->$field ?? 0 }}
                                    </div>
                                </div>
                            @endforeach

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Other Rentals') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->other_rentals ?? 'N/A' }}
                                </div>
                            </div>

                            <!-- Waterfront & Marina -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Waterfront & Marina') }}</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Boat Slips') }}
                                </label>
                                <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                    {{ $claimPark->boat_slips ?? 0 }}
                                </div>
                            </div>

                            @php
                                $waterfrontFeatures = [
                                    'canoe_kayak_rental' => 'Canoes/Kayaks for Rent',
                                    'paddle_boats' => 'Paddle Boats',
                                    'boat_ramp' => 'Boat Ramp/Launch',
                                    'fishing_available' => 'Fishing Available'
                                ];
                            @endphp

                            @foreach($waterfrontFeatures as $field => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __($label) }}
                                    </label>
                                    <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                        {{ $claimPark->$field ? 'Yes' : 'No' }}
                                    </div>
                                </div>
                        @endforeach

                        <!-- Amenities -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Amenities') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @forelse(json_decode($claimPark->amenities, true) ?? [] as $amenity)
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                        {{ $amenity }}
                                    </span>
                                    @empty
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400">No amenities listed</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Photos & Logo -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Photos & Logo') }}</h4>

                                @if($claimPark->logo)
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            {{ __('Logo') }}
                                        </label>
                                        <div class="mt-1">
                                            <img src="{{ asset('storage/' . $claimPark->logo) }}"
                                                 class="h-20 w-auto rounded-md">
                                        </div>
                                    </div>
                                @endif

                                @if($claimPark->park_photos)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            {{ __('Park Photos') }}
                                        </label>
                                        <div class="mt-1 grid grid-cols-2 sm:grid-cols-3 gap-4">
                                            @foreach(json_decode($claimPark->park_photos, true) as $photo)
                                                <img src="{{ asset('storage/' . $photo) }}"
                                                     class="h-32 w-full object-cover rounded-md">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Reservation System -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Reservation System') }}</h4>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Current Reservation Provider') }}
                                    </label>
                                    <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                        {{ $claimPark->reservation_provider ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Happy with current provider?') }}
                                    </label>
                                    <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                        {{ $claimPark->happy_with_provider ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Contact about reservation systems?') }}
                                    </label>
                                    <div class="mt-1 p-2 bg-gray-100 rounded-md dark:bg-gray-800">
                                        {{ $claimPark->contact_about_reservation ? 'Yes' : 'No' }}
                                    </div>
                                </div>

                                @php
                                    $photos = json_decode($claimPark->images ?? '[]', true);
                                    $logo = $claimPark->logo_path;
                                @endphp

                                @if(count($photos) || $logo)
                                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md overflow-hidden">
                                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                                                Uploaded Assets
                                            </h2>
                                        </div>

                                        <div class="px-6 py-5 space-y-6">
                                            @if($logo)
                                                <div>
                                                    <h3 class="text-md font-medium text-gray-600 dark:text-gray-300 mb-2">Park Logo</h3>
                                                    <div class="flex items-center gap-4">
                                                        <img src="{{ asset('storage/' . $logo) }}"
                                                             alt="Park Logo"
                                                             class="h-28 w-auto rounded-xl border shadow-sm p-2 bg-white dark:bg-gray-800">
                                                    </div>
                                                </div>
                                            @endif

                                            @if(count($photos))
                                                <div>
                                                    <h3 class="text-md font-medium text-gray-600 dark:text-gray-300 mb-2">Park Gallery</h3>
                                                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                                        @foreach ($photos as $photo)
                                                            <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 shadow-sm hover:shadow-md transition">
                                                                <img src="{{ asset('storage/' . $photo['path']) }}"
                                                                     alt="{{ $photo['original_name'] }}"
                                                                     class="w-full h-44 object-cover">
                                                                <div class="p-4 text-sm text-gray-700 dark:text-gray-300">
                                                                    <p><strong>Name:</strong> {{ $photo['original_name'] }}</p>
                                                                    <p><strong>Size:</strong> {{ number_format($photo['size'] / 1024, 2) }} KB</p>
                                                                    <p><strong>Uploaded:</strong> {{ \Carbon\Carbon::parse($photo['uploaded_at'])->format('M d, Y H:i') }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('admin.parks.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

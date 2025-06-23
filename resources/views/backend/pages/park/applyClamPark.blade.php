@extends('backend.layouts.app')

@section('title')
    {{ __('Park Create') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Clam Park') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Clam Park') }}</h2>
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
                               href="{{ route('admin.parks.index') }}">
                                {{ __('Parks') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Clam Park') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="max-w-4xl mx-auto my-10">
              <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                  <h4 class="text-lg font-semibold mb-0">Award Criteria</h4>
                </div>
                <div class="p-6 overflow-x-auto">
                  <table class="min-w-full table-auto text-left text-sm align-middle">
                    <thead class="bg-gray-100">
                      <tr>
                        <th class="w-2/5 px-4 py-3 font-medium text-gray-700">Criteria</th>
                        <th class="px-4 py-3 font-medium text-gray-700">Example</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      <tr>
                        <td class="px-4 py-3">
                          <span class="text-xl" title="Average rating threshold">⭐</span>
                          <span class="ml-2">Average rating threshold</span>
                        </td>
                        <td class="px-4 py-3">
                          4.6+ for <span class="font-semibold text-yellow-500">Gold</span>,
                          4.2–4.59 for <span class="font-semibold text-gray-600">Silver</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3">
                          <span class="text-xl" title="Minimum number of reviews">📈</span>
                          <span class="ml-2">Minimum number of reviews</span>
                        </td>
                        <td class="px-4 py-3">e.g. at least 10</td>
                      </tr>
                      <tr>
                        <td class="px-4 py-3">
                          <span class="text-xl" title="Time-based filter">📅</span>
                          <span class="ml-2">Time-based filter</span>
                        </td>
                        <td class="px-4 py-3">Only reviews within the past 12 months</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Clam Park') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Park Name') }}
                        </label>
                        <input type="text" id="park" value="{{ $park->name }}" readonly
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white" required>
                    </div>

                    <form action="{{ route('admin.claim.park.store') }}" method="POST" enctype="multipart/form-data" id="park_form">
                        @csrf
                        <input type="hidden" name="park_id" id="park_id" value="{{ $park->id }}">

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Contact & Ownership Verification') }}</h4>
                            </div>

                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Full Name (First, Last)') }} (required)
                                </label>
                                <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white" required>
                            </div>

                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Email Address') }} (required)
                                </label>
                                <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white" required>
                            </div>

                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Phone Number') }}
                                </label>
                                <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="contact_role" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Role at Park') }}
                                </label>
                                <input type="text" name="contact_role" id="contact_role" value="{{ old('contact_role') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Do you own or manage this park?') }}
                                </label>
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="is_owner_or_manager" value="1" class="form-radio" {{ old('is_owner_or_manager') == '1' ? 'checked' : '' }}>
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="is_owner_or_manager" value="0" class="form-radio" {{ old('is_owner_or_manager') == '0' ? 'checked' : '' }}>
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label for="booking_url" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Online Booking Page URL') }}
                                </label>
                                <input type="url" name="booking_url" id="booking_url" value="{{ old('booking_url') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Facebook Page') }}
                                </label>
                                <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Instagram / Other Social Media') }}
                                </label>
                                <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <!-- Section 3: RV & Tent Site Inventory -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('RV & Tent Site Inventory') }}</h4>
                            </div>

                            <div>
                                <label for="sites_50amp_full" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('50 Amp Full Hookup Sites') }}
                                </label>
                                <input type="number" name="sites_50amp_full" id="sites_50amp_full" value="{{ old('sites_50amp_full', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="sites_30amp_full" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('30 Amp Full Hookup Sites') }}
                                </label>
                                <input type="number" name="sites_30amp_full" id="sites_30amp_full" value="{{ old('sites_30amp_full', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="sites_30amp_water_electric" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('30 Amp Water & Electric Sites') }}
                                </label>
                                <input type="number" name="sites_30amp_water_electric" id="sites_30amp_water_electric" value="{{ old('sites_30amp_water_electric', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="sites_50amp_water_electric" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('50 Amp Water & Electric Sites') }}
                                </label>
                                <input type="number" name="sites_50amp_water_electric" id="sites_50amp_water_electric" value="{{ old('sites_50amp_water_electric', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="sites_30amp_electric" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('30 Amp Electric Only Sites') }}
                                </label>
                                <input type="number" name="sites_30amp_electric" id="sites_30amp_electric" value="{{ old('sites_30amp_electric', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="sites_50amp_electric" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('50 Amp Electric Only Sites') }}
                                </label>
                                <input type="number" name="sites_50amp_electric" id="sites_50amp_electric" value="{{ old('sites_50amp_electric', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="sites_dry_camping" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('No Hookup RV Sites (Dry Camping)') }}
                                </label>
                                <input type="number" name="sites_dry_camping" id="sites_dry_camping" value="{{ old('sites_dry_camping', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="tent_sites_utilities" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Tent Sites (with utilities)') }}
                                </label>
                                <input type="number" name="tent_sites_utilities" id="tent_sites_utilities" value="{{ old('tent_sites_utilities', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="tent_sites_primitive" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Tent Sites (primitive)') }}
                                </label>
                                <input type="number" name="tent_sites_primitive" id="tent_sites_primitive" value="{{ old('tent_sites_primitive', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="seasonal_sites" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Seasonal RV Sites') }}
                                </label>
                                <input type="number" name="seasonal_sites" id="seasonal_sites" value="{{ old('seasonal_sites', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="group_campsites" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Group Campsites') }}
                                </label>
                                <input type="number" name="group_campsites" id="group_campsites" value="{{ old('group_campsites', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <!-- Section 4: Cabins & Rentals -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Cabins & Rentals') }}</h4>
                            </div>

                            <div>
                                <label for="deluxe_cabins" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Deluxe Cabins (AC & Bath)') }}
                                </label>
                                <input type="number" name="deluxe_cabins" id="deluxe_cabins" value="{{ old('deluxe_cabins', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="primitive_cabins" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Primitive Cabins') }}
                                </label>
                                <input type="number" name="primitive_cabins" id="primitive_cabins" value="{{ old('primitive_cabins', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="yurts_glamping" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Yurts / Glamping Tents') }}
                                </label>
                                <input type="number" name="yurts_glamping" id="yurts_glamping" value="{{ old('yurts_glamping', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="other_rentals" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Other Rentals (describe)') }}
                                </label>
                                <input type="text" name="other_rentals" id="other_rentals" value="{{ old('other_rentals') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <!-- Section 5: Waterfront & Marina -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Waterfront & Marina') }}</h4>
                            </div>

                            <div>
                                <label for="boat_slips" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Boat Slips') }}
                                </label>
                                <input type="number" name="boat_slips" id="boat_slips" value="{{ old('boat_slips', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Canoes / Kayaks for Rent') }}
                                </label>
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="canoe_kayak_rental" value="1" class="form-radio" {{ old('canoe_kayak_rental') == '1' ? 'checked' : '' }}>
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="canoe_kayak_rental" value="0" class="form-radio" {{ old('canoe_kayak_rental') == '0' ? 'checked' : '' }}>
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Paddle Boats') }}
                                </label>
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="paddle_boats" value="1" class="form-radio" {{ old('paddle_boats') == '1' ? 'checked' : '' }}>
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="paddle_boats" value="0" class="form-radio" {{ old('paddle_boats') == '0' ? 'checked' : '' }}>
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Boat Ramp / Launch') }}
                                </label>
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="boat_ramp" value="1" class="form-radio" {{ old('boat_ramp') == '1' ? 'checked' : '' }}>
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="boat_ramp" value="0" class="form-radio" {{ old('boat_ramp') == '0' ? 'checked' : '' }}>
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Fishing Available') }}
                                </label>
                                <div class="mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="fishing_available" value="1" class="form-radio" {{ old('fishing_available') == '1' ? 'checked' : '' }}>
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="fishing_available" value="0" class="form-radio" {{ old('fishing_available') == '0' ? 'checked' : '' }}>
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Section 6: Amenities -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Amenities') }}</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @php
                                        $amenities = [
                                            'Swimming Pool',
                                            'Heated Pool',
                                            'Lake / Waterfront Access',
                                            'Beach / Swimming Area',
                                            'Volleyball',
                                            'Horseshoes',
                                            'Archery',
                                            'Laser Tag',
                                            'Basketball Court',
                                            'Pickleball',
                                            'Tennis',
                                            'Badminton',
                                            'Playground',
                                            'Mini Golf',
                                            'Game Room / Arcade',
                                            'Water Slide',
                                            'Bounce Pillow / Jump Pad',
                                            'Bocce',
                                            'Crafts / Organized Activities',
                                            'Movie Nights',
                                            'Live Music',
                                            'Themed Events (Weekends/Holidays)',
                                            'Camp Store',
                                            'Snack Bar / Food Stand',
                                            'Café or Restaurant',
                                            'Laundry Facilities',
                                            'Dump Station',
                                            'Propane for Sale',
                                            'Bathhouses / Showers',
                                            'Gated Entry',
                                            'Security Patrol',
                                            'Pet Friendly',
                                            'Dog Park',
                                            'Nature Trails',
                                            'Hayrides / Wagon Rides',
                                            'Petting Zoo',
                                            'Group Event Facilities',
                                            'Online Reservations',
                                            'Seasonal Rentals'
                                        ];
                                    @endphp

                                    @foreach($amenities as $amenity)
                                        @php
                                            $fieldName = 'amenity_' . Str::slug($amenity, '_');
                                        @endphp
                                        <div class="flex items-center">
                                            <input type="checkbox" name="amenities[]" id="{{ $fieldName }}" value="{{ $amenity }}"
                                                   class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700"
                                                {{ in_array($amenity, old('amenities', [])) ? 'checked' : '' }}>
                                            <label for="{{ $fieldName }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $amenity }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Section 7: Photos & Logo Upload -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Photos & Logo Upload') }}</h4>

                                <div class="mb-4">
                                    <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Logo or sign photo (recommended)') }}
                                    </label>
                                    <input type="file" name="logo" id="logo"
                                           class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                                </div>

                                <div>
                                    <label for="park_photos" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Up to 5 park photos') }}
                                    </label>
                                    <input type="file" name="park_photos[]" id="park_photos" multiple accept="image/jpeg,image/png"
                                           class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                                </div>
                            </div>

                            <!-- Section 8: Reservation System & Sales Opportunity -->
                            <div class="sm:col-span-2 mt-6">
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Reservation System') }}</h4>

                                <div class="mb-4">
                                    <label for="reservation_provider" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Current Online Reservation Provider') }}
                                    </label>
                                    <select name="reservation_provider" id="reservation_provider"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                                        <option value="">Select provider</option>
                                        <option value="ReserveAmerica" {{ old('reservation_provider') == 'ReserveAmerica' ? 'selected' : '' }}>ReserveAmerica</option>
                                        <option value="CampgroundBooking" {{ old('reservation_provider') == 'CampgroundBooking' ? 'selected' : '' }}>CampgroundBooking</option>
                                        <option value="RecreationGov" {{ old('reservation_provider') == 'RecreationGov' ? 'selected' : '' }}>Recreation.gov</option>
                                        <option value="Other" {{ old('reservation_provider') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Are you happy with your current provider?') }}
                                    </label>
                                    <div class="mt-2 space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="happy_with_provider" value="1" class="form-radio" {{ old('happy_with_provider') == '1' ? 'checked' : '' }}>
                                            <span class="ml-2">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="happy_with_provider" value="0" class="form-radio" {{ old('happy_with_provider') == '0' ? 'checked' : '' }}>
                                            <span class="ml-2">No</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="contact_about_reservation" id="contact_about_reservation" value="1"
                                           class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700"
                                        {{ old('contact_about_reservation') ? 'checked' : '' }}>
                                    <label for="contact_about_reservation" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Yes, contact me with information on modern reservation systems.') }}
                                    </label>
                                </div>
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

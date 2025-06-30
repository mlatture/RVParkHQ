@extends('backend.layouts.app')

@section('title')
    {{ __('Park Request Edit') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-7xl md:p-6">
        <div x-data="{ pageName: '{{ __('Edit Park Request') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit Park Request') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.suggest-park.index') }}">
                                {{ __('Park Requests') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">
                            {{ __('Edit Park Request') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="px-5 py-2.5 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white">
                        {{ __('Edit Park Request') }} - {{ $suggest->park_name ?? $suggest->name }}
                    </h3>
                </div>

                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.suggest-park.update', $suggest->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        {{-- 🟢 Status Section --}}
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-white mb-2">🟢 Status</h5>
                            <select name="status" id="status"
                                    class="form-control" required>
                                @foreach (['pending', 'approved', 'rejected'] as $status)
                                    <option value="{{ $status }}" {{ $suggest->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 🧾 Basic Information --}}
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">🧾 Basic Information</h5>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="form-label">Park Name</label>
                                    <input type="text" name="park_name" value="{{ $suggest->park_name }}" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" value="{{ $suggest->city }}" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">State / Province</label>
                                    <input type="text" name="state" value="{{ $suggest->state }}" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" value="{{ $suggest->country }}" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">ZIP / Postal Code</label>
                                    <input type="text" name="zip" value="{{ $suggest->zip }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- 🌐 Online Presence --}}
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">🌐 Online Presence</h5>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="form-label">Website URL</label>
                                    <input type="url" name="website_url" value="{{ $suggest->website_url }}" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Facebook or Instagram URL</label>
                                    <input type="url" name="social_url" value="{{ $suggest->social_url }}" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" value="{{ $suggest->email }}" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ $suggest->phone }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- 👤 User Info (Read-Only) --}}
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">👤 User Information</h5>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="form-label">Submitted By</label>
                                    <input type="text" value="{{ $suggest->user_name }}" class="form-control" readonly>
                                </div>
                                <div>
                                    <label class="form-label">User Email</label>
                                    <input type="email" value="{{ $suggest->user_email }}" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex gap-4">
                            <button type="submit" class="btn-primary">Save</button>
                            <a href="{{ route('admin.suggest-park.index') }}" class="btn-default">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

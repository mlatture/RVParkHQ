@extends('backend.layouts.app')

@section('title')
    {{ __('Create Park Request') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-7xl md:p-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Create Park Request') }}</h2>
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
                        {{ __('Create Park Request') }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="px-5 py-2.5 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white">{{ __('Create Park Request') }}</h3>
                </div>

                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.suggest-park.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">👤 User Info</h5>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="form-label">User Name</label>
                                    <input type="text" name="user_name" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">User Email</label>
                                    <input type="email" name="user_email" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Submitted By</label>
                                    <select name="submitted_by" class="form-control" required>
                                        <option value="" disabled selected>-- Select Submitter --</option>
                                        <option value="park_owner">Park Owner</option>
                                        <option value="guest">Guest</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">🧾 Park Info</h5>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="form-label">Park Name</label>
                                    <input type="text" name="park_name" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Address Line 1</label>
                                    <input type="text" name="address_line_1" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="address_line_2" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">State / Province</label>
                                    <input type="text" name="state" class="form-control" required>
                                </div>
                                <div>
                                    <label class="form-label">ZIP / Postal Code</label>
                                    <input type="text" name="zip" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="form-label">Website URL</label>
                                    <input type="url" name="website_url" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div>
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Enter any additional park information or notes here..."></textarea>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="btn-primary">Create</button>
                            <a href="{{ route('admin.suggest-park.index') }}" class="btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
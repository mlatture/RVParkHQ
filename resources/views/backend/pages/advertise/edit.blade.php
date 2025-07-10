@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Advertising Inquiry') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-screen-xl md:p-6">
        <div x-data="{ pageName: '{{ __('Edit Advertising Inquiry') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit Advertising Inquiry') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.advertise.index') }}">
                                {{ __('Inquiries') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">
                            {{ __('Edit') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Inquiry Details') }}</h3>
            </div>
            <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                <form action="{{ route('admin.advertise.update', $advertise->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center gap-4 mb-5">
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                {{ __('Status') }}
                            </label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                                <option value="pending" {{ $advertise->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="approved" {{ $advertise->status == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                <option value="rejected" {{ $advertise->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $advertise->name) }}"
                                   class="form-control" required>
                        </div>

                        <div>
                            <label for="company" class="form-label">{{ __('Company') }}</label>
                            <input type="text" name="company" id="company" value="{{ old('company', $advertise->company) }}"
                                   class="form-control">
                        </div>

                        <div>
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $advertise->email) }}"
                                   class="form-control" required>
                        </div>

                        <div>
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $advertise->phone) }}"
                                   class="form-control">
                        </div>

                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                {{ __('Advertising Interest') }}
                            </label>
                            <select name="interest" id="interest" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                                <option value="">Select an option</option>
                                <option value="featured" {{ old('interest', $advertise->interest) == 'featured' ? 'selected' : '' }}>Featured Listing</option>
                                <option value="banner" {{ old('interest', $advertise->interest) == 'banner' ? 'selected' : '' }}>Banner Ads</option>
                                <option value="sponsored" {{ old('interest', $advertise->interest) == 'sponsored' ? 'selected' : '' }}>Sponsored Content</option>
                                <option value="newsletter" {{ old('interest', $advertise->interest) == 'newsletter' ? 'selected' : '' }}>Newsletter Ads</option>
                                <option value="sponsorship" {{ old('interest', $advertise->interest) == 'sponsorship' ? 'selected' : '' }}>Category Sponsorship</option>
                                <option value="other" {{ old('interest', $advertise->interest) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="message" class="form-label">{{ __('Message') }}</label>
                            <textarea name="message" id="message" rows="5" class="form-control">{{ old('message', $advertise->message) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-start gap-4">
                        <button type="submit" class="btn-primary">{{ __('Update Advertise') }}</button>
                        <a href="{{ route('admin.advertise.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
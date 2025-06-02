@extends('backend.layouts.app')

@section('title')
    {{ __('Park Create') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('New Campground') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('New Campground') }}</h2>
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
                               href="{{ route('admin.campground.index') }}">
                                {{ __('Campgrounds') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('New Campground') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Create New Campground') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.campground.store') }}" method="POST" enctype="multipart/form-data"
                          id="park_form">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Name') }}
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('State') }}
                                </label>
                                <input type="text" name="state" id="state" value="{{ old('state') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('City') }}
                                </label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="postal_code"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Zip') }}
                                </label>
                                <input type="text" name="zip" id="zip" value="{{ old('zip') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="latitude"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Latitude') }}
                                </label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="longitude"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Longitude') }}
                                </label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('admin.campground.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#latitude').on('input', function () {
                $(this).val($(this).val().replace(/[^0-9.-]/g, ''));
            });

            $('#longitude').on('input', function () {
                $(this).val($(this).val().replace(/[^0-9.-]/g, ''));
            });
        });
    </script>
@endsection

@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Park') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Edit Park') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit Park') }}</h2>
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
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Edit Park') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Update Park Information') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.parks.update', $park->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Park Name') }}
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $park->name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Slug') }}
                                </label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $park->slug) }}" readonly
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Description') }}
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">{{ old('description', $park->description) }}</textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Short Description') }}
                                </label>
                                <textarea name="short_description" id="short_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">{{ old('short_description', $park->short_description) }}</textarea>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Address') }}
                                </label>
                                <input type="text" name="address" id="address" value="{{ old('address', $park->address) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('City') }}
                                </label>
                                <input type="text" name="city" id="city" value="{{ old('city', $park->city) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('State') }}
                                </label>
                                <input type="text" name="state" id="state" value="{{ old('state', $park->state) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Country') }}
                                </label>
                                <input type="text" name="country" id="country" value="{{ old('country', $park->country) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Postal Code') }}
                                </label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $park->postal_code) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Latitude') }}
                                </label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $park->latitude) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Longitude') }}
                                </label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $park->longitude) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Phone') }}
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $park->phone) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Email') }}
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $park->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="website_url" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Website URL') }}
                                </label>
                                <input type="text" name="website_url" id="website_url" value="{{ old('website_url', $park->website_url) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Status') }}
                                </label>
                                <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white">
                                    <option value="active" {{ old('status', $park->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $park->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div>
                                <label for="is_featured" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Featured') }}
                                </label>
                                <select name="is_featured" id="is_featured"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white">
                                    <option value="0" {{ old('is_featured', $park->is_featured) == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_featured', $park->is_featured) == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="main_image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Main Image') }}
                                </label>
                                <input type="file" name="main_image_url" id="main_image_url"
                                       class="mt-1 block w-full text-sm text-gray-800 file:mr-4 file:rounded file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-700">

                                @if($park->main_image_url)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $park->main_image_url) }}" class="h-20 rounded" alt="Current Image">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-md bg-brand-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                                {{ __('Update Park') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('input', function () {
                let slug = nameInput.value
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-');

                slugInput.value = slug;
            });
        });

        document.getElementById('latitude').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9.-]/g, '');
        });

        document.getElementById('longitude').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9.-]/g, '');
        });
    </script>
@endsection

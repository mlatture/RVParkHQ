@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Amenity') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Edit Amenity') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Edit Amenity') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.amenities.index') }}">
                                {{ __('Amenities') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">
                            {{ __('Edit Amenity') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Amenity Information') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')
                    <form action="{{ route('admin.amenities.update', $amenity->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="amenity" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Amenity Name') }}</label>
                                <input type="text" name="amenity" id="amenity" required value="{{ old('amenity', $amenity->amenity) }}" class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Amenity Category') }}</label>
                                <select name="category" id="category" required class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:text-white/90">
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach([
                                        'Water & Recreation',
                                        'Sports & Games',
                                        'Convenience & Comfort',
                                        'Experiences & Events',
                                        'Kid & Family Friendly',
                                        'Other Features'
                                    ] as $category)
                                        <option value="{{ $category }}" {{ $amenity->category == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="blackicon" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Black Icon') }}</label>
                                <input type="file" name="blackicon" id="blackicon"
                                       class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                                @if ($amenity->blackicon)
                                    @php
                                        $blackIconPath = $amenity->blackicon;
                                        $blackIconImage = !empty($blackIconPath) && preg_match('/^https?:\/\//', $blackIconPath) ? $blackIconPath : asset('storage/' . $blackIconPath);
                                    @endphp
                                    <img src="{{ $blackIconImage }}" class="mt-2 w-10 h-10 object-contain" alt="Black Icon">
                                @endif
                            </div>

                            <div>
                                <label for="whiteicon" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('White Icon') }}</label>
                                <input type="file" name="whiteicon" id="whiteicon"
                                       class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                                @if ($amenity->whiteicon)
                                    @php
                                        $whiteIconPath = $amenity->whiteicon;
                                        $whiteIconImage = !empty($whiteIconPath) && preg_match('/^https?:\/\//', $whiteIconPath) ? $whiteIconPath : asset('storage/' . $blackIconPath);
                                    @endphp
                                    <img src="{{ $whiteIconImage }}" class="mt-2 w-10 h-10 object-contain" alt="White Icon">
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Update') }}</button>
                            <a href="{{ route('admin.amenities.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

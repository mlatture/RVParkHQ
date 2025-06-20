@extends('backend.layouts.app')

@section('title')
    {{ __('Amenities') }} | {{ config('app.name') }}
@endsection

@section('admin-content')

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: {{ __('Amenities') }} }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Amenities') }}
                    @if (request('role'))
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                        {{ ucfirst(request('role')) }}
                    </span>
                    @endif
                </h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                               href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Amenities') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- park Table -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Amenities') }}</h3>

                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by name, category'),
                    ])

                    <div class="flex items-center gap-2">

                        @if (auth()->user()->can('user.edit'))
                            <a href="{{ route('admin.amenities.create') }}" class="btn-primary">
                                <i class="bi bi-plus-circle mr-2"></i>
                                {{ __('New Amenities') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')
                    <table id="dataTable" class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th width="5%"
                                class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Sl') }}</th>
                            <th width="10%"
                                class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Name') }}</th>
                            <th width="25%"
                                class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Category') }}</th>
                            <th width="30%"
                                class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Black Icon') }}</th>
                            <th width="30%"
                                class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('White Icon') }}</th>
                            @php ld_apply_filters('user_list_page_table_header_before_action', '') @endphp
                            <th width="15%"
                                class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Action') }}</th>
                            @php ld_apply_filters('user_list_page_table_header_after_action', '') @endphp
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($amenities as $amenitie)
                            <tr class="'border-b border-gray-100 dark:border-gray-800'">
                                <td class="px-5 py-4 sm:px-6">{{ $loop->index + 1 }}</td>
                                <td class="px-5 py-4 sm:px-6 flex items-center md:min-w-[200px]">{{ $amenitie->amenity }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ $amenitie->category }}</td>
                                <td class="px-5 py-4 sm:px-6">
                                    @php
                                        $blackIconPath = $amenitie->blackicon;
                                        $blackIconImage = !empty($blackIconPath) && preg_match('/^https?:\/\//', $blackIconPath) ? $blackIconPath : asset('storage/' . $blackIconPath);
                                    @endphp
                                    <img src="{{ $blackIconImage }}" alt="Black Icon" width="40" height="40">
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @php
                                        $whiteIconPath = $amenitie->whiteicon;
                                        $whiteIconImage = !empty($whiteIconPath) && preg_match('/^https?:\/\//', $whiteIconPath) ? $whiteIconPath : asset('storage/' . $blackIconPath);
                                    @endphp
                                    <img src="{{ $whiteIconImage }}" alt="White Icon" width="40" height="40">
                                </td>

                                <td class="flex px-5 py-4 sm:px-6 text-center gap-1">

                                    <a data-tooltip-target="tooltip-edit-park-{{ $amenitie->id }}" class="btn-default !p-3"
                                       href="{{ route('admin.amenities.edit', $amenitie->id) }}">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </a>
                                    <div id="tooltip-edit-park-{{ $amenitie->id }}" role="tooltip"
                                         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        {{ __('Edit User') }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>

                                    <a data-modal-target="delete-modal-{{ $amenitie->id }}"
                                       data-modal-toggle="delete-modal-{{ $amenitie->id }}"
                                       data-tooltip-target="tooltip-delete-park-{{ $amenitie->id }}" class="btn-danger !p-3"
                                       href="javascript:void(0);">
                                        <i class="bi bi-trash text-sm"></i>
                                    </a>
                                    <div id="tooltip-delete-park-{{ $amenitie->id }}" role="tooltip"
                                         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        {{ __('Delete Park') }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>

                                    <div id="delete-modal-{{ $amenitie->id }}" tabindex="-1"
                                         class="hidden fixed inset-0 z-50 flex items-center justify-center">
                                        <!-- Modal Content -->
                                        <div
                                            class="relative p-4 w-full max-w-md bg-white rounded-lg shadow-lg dark:bg-gray-700 z-60">
                                            <button type="button"
                                                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="delete-modal-{{ $amenitie->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-width="2"
                                                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">{{ __('Close modal') }}</span>
                                            </button>
                                            <div class="p-4 md:p-5 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-width="2"
                                                          d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">{{ __('Are you sure you want to delete this Amenity?') }}</h3>
                                                <form id="delete-form-{{ $amenitie->id }}"
                                                      action="{{ route('admin.amenities.destroy', $amenitie->id) }}"
                                                      method="POST">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button type="submit"
                                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        {{ __('Yes, Confirm') }}
                                                    </button>
                                                    <button data-modal-hide="delete-modal-{{ $amenitie->id }}" type="button"
                                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{ __('No, cancel') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('No Amenity found') }}</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="my-4 px-4 sm:px-6">
                        {{ $amenities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

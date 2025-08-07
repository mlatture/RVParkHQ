@extends('backend.layouts.app')

@section('title')
    {{ __('Free Marketing System Log') }} | {{ config('app.name') }}
@endsection

@section('admin-content')

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: {{ __('Free Marketing System Log') }} }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Free Marketing System Log') }}
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
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Free Marketing System Log') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Park Request Table -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Free Marketing System Log') }}</h3>

                </div>
                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')
                    <table id="dataTable" class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Sl') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Ip Address') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Transaction Type') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Page') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Log Date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($free_marketing as $index => $free_marketin)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 sm:px-6">{{ $index + 1 }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ $free_marketin->ip_address }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ ucwords(str_replace('_', ' ', $free_marketin->transaction_type)) }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ ucwords(str_replace('_', ' ', $free_marketin->page)) }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ $free_marketin->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('No Free Marketing System Log Found') }}</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="my-4 px-4 sm:px-6">
                        {{ $free_marketing->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

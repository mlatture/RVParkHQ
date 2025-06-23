@extends('backend.layouts.app')

@section('title')
    {{ __('Parks') }} | {{ config('app.name') }}
@endsection

@section('admin-content')

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: {{ __('Parks') }} }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Parks') }}
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
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Parks') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- park Table -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Parks') }}</h3>

                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by name, email or status'),
                    ])

                    <div class="flex items-center gap-2">

                        @if (auth()->user()->can('user.create'))
                            <a href="{{ route('admin.parks.create') }}" class="btn-primary">
                                <i class="bi bi-plus-circle mr-2"></i>
                                {{ __('New Park') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')
                    <table id="dataTable" class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Sl') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Name') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Email') }}</th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Status') }}</th>
                            @if(auth()->user()->can('park.edit') || auth()->user()->can('park.delete'))
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Action') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $user = auth()->user();
                        @endphp
                        @forelse ($parks as $park)
                            <tr class="'border-b border-gray-100 dark:border-gray-800'">
                                <td class="px-5 py-4 sm:px-6">{{ $loop->index + 1 }}</td>
                                <td class="px-5 py-4 sm:px-6 flex items-center md:min-w-[200px]">
                                    {{ $park->name }}
                                </td>
                                <td class="px-5 py-4 sm:px-6">{{ $park->email }}</td>
                                <td class="px-5 py-4 sm:px-6 ">
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                                        {{ ucfirst($park->status) }}
                                    </span>
                                </td>
                                <td class="flex px-5 py-4 sm:px-6 text-center gap-1">
                                    @if($user->hasRole('Superadmin'))
                                        <a data-tooltip-target="tooltip-edit-park-{{ $park->id }}"
                                           class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">
                                            <i class="bi bi-pencil text-sm"></i>
                                        </a>

                                        <form action="{{ route('admin.parks.destroy', $park->id) }}" method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash text-sm"></i>
                                            </button>
                                        </form>
                                    @elseif($user->hasRole('Owner'))
                                        @php
                                            $editRequest = $park->editRequests()->where('owner_id', $user->id)->latest()->first();

                                            $userAppliedClaim = $park->claim_parks()
                                                ->where('user_id', $user->id)
                                                ->where('park_id', $park->id)
                                                ->first();

                                            $approvedClaim = $park->claim_parks()->where('status', 'approved')->first();
                                        @endphp

                                        {{-- CASE: If the park is claimed by another user --}}
                                        @if($approvedClaim && $approvedClaim->user_id !== auth()->id())
                                            <span class="text-danger fw-bold">This park is already claimed by its owner.</span>

                                            {{-- CASE: If the park is claimed by current user --}}
                                        @elseif($userAppliedClaim && $userAppliedClaim->status === 'approved')
                                            <a class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </a>

                                            {{-- CASE: If user has applied for claim but not approved yet --}}
                                        @elseif($userAppliedClaim)
                                            <span class="text-warning">Request Claim Park</span>

                                            {{-- CASE: No claim yet, allow user to apply --}}
                                        @else
                                            <a class="!p-3 btn btn-primary btn-sm" href="{{ route('admin.claim.park.apply', encrypt($park->id)) }}">
                                                <i class="bi bi-hand-index-thumb-fill"></i>
                                            </a>
                                        @endif


                                        @if($approvedClaim && $approvedClaim->user_id === auth()->id())

                                        @elseif($editRequest && $editRequest->status === 'pending')
                                            <span class="text-warning">Request Pending</span>

                                        @elseif($editRequest && $editRequest->status === 'approved')
                                            <a class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </a>

                                        @elseif(!$approvedClaim)
                                        <form action="{{ route('admin.park_edit_requests.suggest', $park->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-warning btn-sm" title="Suggest a change" type="submit">
                                                <i class="bi bi-capslock-fill text-sm"></i>
                                            </button>
                                        </form>
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">{{ __('No Park found') }}</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="my-4 px-4 sm:px-6">
                        {{ $parks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{--        <script>--}}
        {{--            function handleRoleFilter(value) {--}}
        {{--                let currentUrl = new URL(window.location.href);--}}
        {{--                currentUrl.searchParams.set('role', value);--}}
        {{--                window.location.href = currentUrl.toString();--}}
        {{--            }--}}
        {{--        </script>--}}
    @endpush
@endsection

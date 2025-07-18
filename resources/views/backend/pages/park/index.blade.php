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
                            @if(auth()->user()->hasRole('Owner'))
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">{{ __('Info') }}</th>
                            @endif
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
{{--                                <td class="flex px-5 py-4 sm:px-6 text-center gap-1">--}}
{{--                                    @if($user->hasRole('Superadmin'))--}}
{{--                                        --}}{{-- Superadmin: Full access --}}
{{--                                        <a data-tooltip-target="tooltip-edit-park-{{ $park->id }}"--}}
{{--                                           class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">--}}
{{--                                            <i class="bi bi-pencil text-sm"></i>--}}
{{--                                        </a>--}}

{{--                                        <form action="{{ route('admin.parks.destroy', $park->id) }}" method="POST" style="display:inline-block;">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">--}}
{{--                                                <i class="bi bi-trash text-sm"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}

{{--                                    @elseif($user->hasRole('Owner'))--}}
{{--                                        @php--}}
{{--                                            $userAppliedClaim = $park->claim_parks()--}}
{{--                                                ->where('user_id', $user->id)--}}
{{--                                                ->where('park_id', $park->id)--}}
{{--                                                ->first();--}}

{{--                                            $approvedClaim = $park->claim_parks()->where('status', 'approved')->first();--}}
{{--                                            $pendingClaim = $park->claim_parks()->where('status', 'pending')->first();--}}
{{--                                        @endphp--}}

{{--                                        --}}{{-- CASE: Claimed by someone else --}}
{{--                                        @if($approvedClaim && $approvedClaim->user_id !== auth()->id())--}}
{{--                                            <span class="text-danger fw-bold">This park is already claimed by its owner.</span>--}}

{{--                                            --}}{{-- CASE: Claimed by current user and approved --}}
{{--                                        @elseif($approvedClaim && $approvedClaim->user_id === auth()->id())--}}
{{--                                            <a class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">--}}
{{--                                                <i class="bi bi-pencil text-sm"></i>--}}
{{--                                            </a>--}}

{{--                                            --}}{{-- CASE: Claim requested by current user but not yet approved --}}
{{--                                        @elseif($userAppliedClaim && $userAppliedClaim->status === 'pending')--}}
{{--                                            <span class="text-warning">Claim Requested</span>--}}

{{--                                            --}}{{-- CASE: Another user has requested claim --}}
{{--                                        @elseif($pendingClaim && $pendingClaim->user_id !== auth()->id())--}}
{{--                                            <span class="text-warning">--}}
{{--                                                {{ $pendingClaim->user->name }} has submitted a claim request for this park.--}}
{{--                                            </span>--}}
{{--                                            <a class="!p-3 btn btn-primary btn-sm" href="{{ route('admin.claim.park.apply', encrypt($park->id)) }}">--}}
{{--                                                <i class="bi bi-hand-index-thumb-fill"></i>--}}
{{--                                            </a>--}}

{{--                                            --}}{{-- CASE: Not yet claimed --}}
{{--                                        @else--}}
{{--                                            <a class="!p-3 btn btn-primary btn-sm" href="{{ route('admin.claim.park.apply', encrypt($park->id)) }}">--}}
{{--                                                <i class="bi bi-hand-index-thumb-fill"></i>--}}
{{--                                            </a>--}}
{{--                                        @endif--}}
{{--                                    @endif--}}

{{--                                </td>--}}
                                {{-- Column for message --}}
                                <td class="px-5 py-4 sm:px-6 text-center">
                                    @if($user->hasRole('Owner'))
                                        @php
                                            $userAppliedClaim = $park->claim_parks()->where('user_id', $user->id)->first();
                                            $approvedClaim = $park->claim_parks()->where('status', 'approved')->first();
                                            $pendingClaim = $park->claim_parks()->where('status', 'pending')->first();
                                        @endphp

                                        @if($approvedClaim && $approvedClaim->user_id !== auth()->id())
                                            <span class="text-danger fw-bold">This park is already claimed by its owner.</span>
                                        @elseif($userAppliedClaim && $userAppliedClaim->status === 'pending')
                                            <span class="text-warning">Claim Requested</span>
                                        @elseif($pendingClaim && $pendingClaim->user_id !== auth()->id())
                                            <span class="text-warning">{{ $pendingClaim->user->name }} has submitted a claim request.</span>
                                        @endif
                                    @endif
                                </td>

                                {{-- Column for buttons --}}
                                <td class="flex px-5 py-4 sm:px-6 text-center gap-1">
                                    @if($user->hasRole('Owner'))
                                        {{-- Case: Current user is the approved owner --}}
                                        @if($approvedClaim && $approvedClaim->user_id === auth()->id())
                                            <a class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </a>

                                            {{-- Case: Claim not yet approved --}}
                                        @elseif(!$approvedClaim)
                                            {{-- Show button to all except the user who already submitted the claim --}}
                                            @if(!$userAppliedClaim && $park->request_park == 1)
                                                <a class="!p-3 btn btn-primary btn-sm" href="{{ route('admin.claim.park.apply', encrypt($park->id)) }}">
                                                    <i class="bi bi-hand-index-thumb-fill"></i>
                                                </a>
                                            @endif
                                        @endif

                                    @elseif($user->hasRole('Superadmin'))
                                        {{-- Superadmin full access --}}
                                        <a class="btn-default !p-3" href="{{ route('admin.parks.edit', $park->id) }}">
                                            <i class="bi bi-pencil text-sm"></i>
                                        </a>
                                        <form action="{{ route('admin.parks.destroy', $park->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash text-sm"></i>
                                            </button>
                                        </form>
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

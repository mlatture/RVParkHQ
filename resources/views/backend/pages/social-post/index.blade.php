@extends('backend.layouts.app')

@section('title')
    {{ __('Social Posts') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Social Posts') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Social Posts') }}
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
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Social Posts') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div
                class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        {{ __('Social Posts') }}
                    </h3>

                    {{-- search --}}
                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by tenant, domain, URL or status'),
                    ])

                    <div class="flex items-center gap-2">
                        @can('social-post.create')
                            <a href="{{ route('admin.social-posts.create') }}" class="btn-primary">
                                <i class="bi bi-plus-circle mr-2"></i>
                                {{ __('New Social Post') }}
                            </a>
                        @endcan
                    </div>
                </div>

                <div
                    class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')

                    <table id="dataTable" class="w-full dark:text-gray-400">
                        <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                {{ __('Sl') }}
                            </th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                {{ __('Tenant') }}
                            </th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                {{ __('Article URL') }}
                            </th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                {{ __('Status') }}
                            </th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                {{ __('Scheduled For') }}
                            </th>
                            <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                {{ __('Created At') }}
                            </th>
                            @if(auth()->user()->can('social-post.edit') || auth()->user()->can('social-post.delete'))
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Action') }}
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($posts as $post)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 sm:px-6">
                                    {{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}
                                </td>

                                <td class="px-5 py-4 sm:px-6 md:min-w-[200px]">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800 dark:text-white/90">
                                            {{ $post->tenant_name ?? '-' }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $post->tenant_domain ?? '' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 sm:px-6 md:min-w-[220px]">
                                    <a href="{{ $post->article_url }}" target="_blank"
                                       class="text-sm text-blue-600 dark:text-blue-400 underline break-all">
                                        {{ Str::limit($post->article_url, 60) }}
                                    </a>
                                </td>

                                <td class="px-5 py-4 sm:px-6">
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 sm:px-6">
                                    {{ $post->scheduled_for ? $post->scheduled_for->format('Y-m-d H:i') : '-' }}
                                </td>

                                <td class="px-5 py-4 sm:px-6">
                                    {{ $post->created_at ? $post->created_at->format('Y-m-d H:i') : '-' }}
                                </td>

                                @if(auth()->user()->can('social-post.edit') || auth()->user()->can('social-post.delete'))
                                    <td class="flex px-5 py-4 sm:px-6 text-center gap-1">
                                        @can('social-post.edit')
                                            <a class="btn-default !p-3"
                                               href="{{ route('admin.social-posts.edit', $post->id) }}">
                                                <i class="bi bi-pencil text-sm"></i>
                                            </a>
                                        @endcan

                                        @can('social-post.delete')
                                            <form action="{{ route('admin.social-posts.destroy', $post->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('{{ __('Are you sure?') }}')"
                                                  style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash text-sm"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-gray-500 dark:text-gray-400">
                                        {{ __('No Social Post found') }}
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="my-4 px-4 sm:px-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

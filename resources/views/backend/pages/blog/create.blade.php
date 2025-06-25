@extends('backend.layouts.app')

@section('title')
    {{ __('Create Blog Post') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Create Blog Post') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Create Blog Post') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.blogs.index') }}">
                                {{ __('Blog Posts') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">
                            {{ __('Create Blog Post') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Blog Post Information') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')
                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                                       class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Slug') }}</label>
                                <input type="text" name="slug" id="slug" readonly value="{{ old('slug') }}"
                                       class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-400 placeholder:text-gray-400 dark:border-gray-700 dark:text-gray-400 dark:placeholder:text-white/30">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Excerpt') }}</label>
                                <textarea name="excerpt" id="excerpt" rows="3"
                                          class="dark:bg-dark-900 shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">{{ old('excerpt') }}</textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Content') }}</label>
                                <textarea name="content" id="content" rows="6"
                                          class="dark:bg-dark-900 shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">{{ old('content') }}</textarea>
                            </div>

                            <div>
                                <label for="thumbnail" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Thumbnail') }}</label>
                                <input type="file" name="thumbnail" id="thumbnail"
                                       class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Status') }}</label>
                                <select name="status" id="status"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                                    <option value="draft">{{ __('Draft') }}</option>
                                    <option value="published">{{ __('Published') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Publish Date') }}</label>
                                <input type="date" name="published_at" id="published_at" value="{{ old('published_at') }}"
                                       class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('admin.blogs.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('title').addEventListener('input', function () {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        });

        flatpickr("#published_at", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    </script>
@endsection

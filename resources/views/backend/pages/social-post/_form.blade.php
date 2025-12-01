@php
    $statuses = ['pending', 'scheduled', 'published', 'failed'];
@endphp

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
        <label for="tenant_name"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Tenant Name') }}
        </label>
        <input type="text" name="tenant_name" id="tenant_name"
               value="{{ old('tenant_name', $post->tenant_name) }}"
               placeholder="{{ __('Enter Tenant Name') }}"
               class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
    </div>

    <div>
        <label for="tenant_domain"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Tenant Domain') }}
        </label>
        <input type="text" name="tenant_domain" id="tenant_domain"
               value="{{ old('tenant_domain', $post->tenant_domain) }}"
               placeholder="{{ __('e.g. example.com') }}"
               class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
    </div>

    <div>
        <label for="tenant_id"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Tenant ID') }}
        </label>
        <input type="number" name="tenant_id" id="tenant_id"
               value="{{ old('tenant_id', $post->tenant_id) }}"
               placeholder="{{ __('Optional Tenant ID') }}"
               class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
    </div>

    <div>
        <label for="idea_id"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Idea ID') }}
        </label>
        <input type="number" name="idea_id" id="idea_id"
               value="{{ old('idea_id', $post->idea_id) }}"
               placeholder="{{ __('Optional Idea ID') }}"
               class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
    </div>

    <div class="sm:col-span-2">
        <label for="article_url"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Article URL') }}
        </label>
        <input type="text" name="article_url" id="article_url" required
               value="{{ old('article_url', $post->article_url) }}"
               placeholder="{{ __('Enter article URL used to generate this post') }}"
               class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
    </div>

    <div class="sm:col-span-2">
        <label for="variants"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Variants (JSON or Text)') }}
        </label>
        <textarea name="variants" id="variants" rows="6" required
                  placeholder="{{ __('Paste generated variants here (JSON or plain text)') }}"
                  class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">{{ old('variants', $post->variants) }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label for="media"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Media (optional, JSON or Text)') }}
        </label>
        <textarea name="media" id="media" rows="4"
                  placeholder="{{ __('Store image URLs, IDs, metadata, etc.') }}"
                  class="dark:bg-dark-900 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">{{ old('media', $post->media) }}</textarea>
    </div>

    <div>
        <label for="status"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Status') }}
        </label>
        <select name="status" id="status" required
                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
            @foreach($statuses as $status)
                <option value="{{ $status }}"
                    {{ old('status', $post->status ?? 'pending') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="scheduled_for"
               class="block text-sm font-medium text-gray-700 dark:text-gray-400">
            {{ __('Scheduled For') }}
        </label>
        <input type="datetime-local" name="scheduled_for" id="scheduled_for"
               value="{{ old('scheduled_for', optional($post->scheduled_for)->format('Y-m-d\TH:i')) }}"
               class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            {{ __('Leave empty to keep as unscheduled / immediate.') }}
        </p>
    </div>
</div>

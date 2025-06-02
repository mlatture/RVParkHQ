@extends('backend.auth.layouts.app')

@section('title')
    {{ __('Register') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div>
        <div class="mb-5 sm:mb-8">
            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                {{ __('Register') }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Create your account to get started!') }}
            </p>
        </div>

        <form action="{{ route('admin.register.submit') }}" method="POST">
            @csrf
            <div class="space-y-5">
                @include('backend.layouts.partials.messages')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Select Type -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Select Type') }} <span class="text-error-500">*</span>
                        </label>
                        <select name="type"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <option value="">Select Type</option>
                            <option value="owner" {{ old('type') == 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="camper" selected {{ old('type') == 'camper' ? 'selected' : '' }}>Camper</option>
                        </select>
                        @error('type')
                        <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- User Name -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('User Name') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Your Name"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @error('username')
                        <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Full Name') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @error('name')
                        <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Email') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="info@gmail.com"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @error('email')
                        <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }" class="relative">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Password') }} <span class="text-error-500">*</span>
                        </label>
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Enter your password"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <div @click="show = !show"
                             class="absolute top-9 right-4 cursor-pointer text-gray-500 dark:text-gray-400">
                            <!-- Toggle icons -->
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.691-2.906m1.636-1.82A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.96 9.96 0 01-4.195 5.113M3 3l18 18"/>
                            </svg>
                        </div>
                        @error('password')
                        <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ __('Confirm Password') }} <span class="text-error-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" placeholder="Confirm password"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                            class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                        {{ __('Register') }}
                    </button>
                </div>

                <!-- Already have account -->
                <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('admin.login') }}" class="text-brand-500 hover:underline">
                        {{ __('Login here') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

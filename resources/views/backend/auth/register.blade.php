@extends('backend.auth.layouts.app')

@section('title')
    {{ __('Register') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('Create Account') }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Register to manage your parks and listings.') }}</p>
    </div>

    <form action="{{ route('admin.register.submit') }}" method="POST" class="space-y-6">
        @csrf
        @include('backend.layouts.partials.messages')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Name <span
                        class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="John Doe"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white"/>
                @error('name')
                <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Email <span
                        class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="you@example.com"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white"/>
                @error('email')
                <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div x-data="{ show: false }" class="relative">
            <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Password <span
                    class="text-red-500">*</span></label>
            <input :type="show ? 'text' : 'password'" name="password"
                   placeholder="Create password"
                   class="w-full px-4 py-2 pr-10 border border-gray-300 dark:border-gray-700 rounded-md text-sm focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white"/>
            <div @click="show = !show" class="absolute top-9 right-3 cursor-pointer text-gray-500 dark:text-gray-400">
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            @error('password')
            <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Confirm Password <span
                    class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" placeholder="Repeat password"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm focus:ring focus:ring-blue-200 dark:bg-gray-800 dark:text-white"/>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-md transition duration-200">
                {{ __('Register') }}
            </button>
        </div>

        <!-- Already have account -->
        <div class="text-center text-sm text-gray-600 dark:text-gray-400">
            {{ __('Already have an account?') }}
            <a href="{{ route('admin.login') }}" class="text-blue-500 hover:underline ml-1">
                {{ __('Login here') }}
            </a>
        </div>
    </form>
@endsection

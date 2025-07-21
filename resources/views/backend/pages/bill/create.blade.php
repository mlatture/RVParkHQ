@extends('backend.layouts.app')

@section('title')
    {{ __('Create Billing Form') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Create Billing Form') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Create Billing Form') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">
                            {{ __('Create Billing Form') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Form Information') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')
                    <form action="{{ route('admin.bills.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="send_from" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Send From') }}</label>
                                <select name="send_from" id="send_from" required
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                                    <option value="">{{ __('Select an option') }}</option>
                                    <option value="WebDaVinci">{{ __('WebDaVinci') }}</option>
                                    <option value="RVParkHQ">{{ __('RVParkHQ') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="sales_rep" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Sales Rep') }}</label>
                                <select name="sales_rep" id="sales_rep"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                                    <option value="">{{ __('Select a sales rep') }}</option>
{{--                                    @foreach($salesReps as $rep)--}}
{{--                                        <option value="{{ $rep->id }}">{{ $rep->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                            </div>
                            <div>
                                <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Customer') }}</label>
                                <select name="customer_id" id="customer_id"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                                    <option value="">{{ __('Select a Customer') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Subject') }}</label>
                                <input type="text" name="subject" id="subject" required value="{{ old('subject') }}"
                                       class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Description') }}</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="dark:bg-dark-900 shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="schedule" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Schedule') }}</label>
                                <select name="schedule" id="schedule" required
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                                    <option value="once">{{ __('Once') }}</option>
                                    <option value="monthly">{{ __('Monthly') }}</option>
                                    <option value="yearly">{{ __('Yearly') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Due Date') }}</label>
                                <input type="date" name="due_date" id="due_date" required value="{{ old('due_date') }}"
                                       class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90">
                            </div>

                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Amount') }}</label>
                                <input type="number" name="amount" id="amount" step="0.01" required value="{{ old('amount') }}"
                                       class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <button type="submit" name="save_and_send" value="1" class="btn-secondary">{{ __('Save and Send') }}</button>
                            <a href="{{ route('admin.bills.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        flatpickr("#due_date", {
            dateFormat: "Y-m-d",
            allowInput: true,
            minDate: "today"
        });
    </script>
@endsection
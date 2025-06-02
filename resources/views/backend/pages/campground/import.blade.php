@extends('backend.layouts.app')

@section('title')
    {{ __('Import Campgrounds') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div>
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('Import Campgrounds') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.campground.index') }}">
                                {{ __('Campgrounds') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">
                            {{ __('Import Campgrounds') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <form id="campgroundForm">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="state_name" class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                                    {{ __('State Name') }}
                                </label>
                                <input type="text" name="state_name" id="state_name"
                                       placeholder="{{ __('Enter State Name') }}"
                                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="submit" class="btn-primary">{{ __('Import') }}</button>
                            <a href="{{ route('admin.campground.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#campgroundForm').on('submit', function (e) {
                e.preventDefault();

                var stateName = $('#state_name').val().trim();

                if (stateName === '') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'State Name is required!',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    return;
                }

                $('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Importing...');
                $('#ajaxLoader').removeClass('hidden');
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("admin.campground.overpass") }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message || 'Data Successfully Fetched',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });

                            $('#campgroundForm')[0].reset();

                            setTimeout(function () {
                                window.location.href = '{{ route("admin.campground.index") }}';
                            }, 2000);
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'warning',
                                title: response.message || 'No data found.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        }
                    },
                    error: function (xhr) {
                        var errorMessage = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = '';
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errorMessage += value + '\n';
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: errorMessage,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('{{ __("Import") }}');
                        $('#ajaxLoader').addClass('hidden');
                    }
                });
            });
        });
    </script>
@endsection

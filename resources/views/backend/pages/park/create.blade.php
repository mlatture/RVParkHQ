@extends('backend.layouts.app')

@section('title')
    {{ __('Park Create') }} - {{ config('app.name') }}
@endsection

@section('admin-content')
    <style>
        /* Increase height of the main container */
        .select2-container .select2-selection--single {
            height: 44px !important; /* change to your desired height */
            display: flex;
            align-items: center;
            padding: 6px 12px;
            font-size: 16px; /* optional */
        }
        
        /* Adjust the rendered text inside the selection */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px !important; /* match the container height */
        }
        
        /* Optional: adjust the arrow icon */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
        }

    </style>

    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('New Park') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ __('New Park') }}</h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                               href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                               href="{{ route('admin.parks.index') }}">
                                {{ __('Parks') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('New Park') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Create New Park') }}</h3>
                </div>
                <div class="p-5 space-y-6 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.parks.store') }}" method="POST" enctype="multipart/form-data" id="park_form">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-400">
                                        {{ __('Park Name') }}
                                    </label>

                                    <div class="form-check form-switch flex items-center">
                                        <input class="form-check-input" type="checkbox" name="change_name" id="change_name">
                                        <label class="form-check-label ml-2" for="change_name" id="name_check_box_label">Manual</label>
                                    </div>
                                </div>

                                <div id="inputWrapper" class="flex mt-1 hidden">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                                </div>

                                <div id="selectWrapper" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                                    <select id="parkDropdown" name="name" class="w-full select2">
                                        <option value="">Select a park</option>
                                    </select>
                                </div>

                                <span id="error-name" class="text-sm text-red-600 mt-1 block"></span>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-4">
                                    {{ __('Slug') }}
                                </label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" readonly
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="description"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Description') }}
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">{{ old('description') }}</textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="short_description"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Short Description') }}
                                </label>
                                <textarea name="short_description" id="short_description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">{{ old('short_description') }}</textarea>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Address') }}
                                </label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('City') }}
                                </label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('State') }}
                                </label>
                                <input type="text" name="state" id="state" value="{{ old('state') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Country') }}
                                </label>
                                <input type="text" name="country" id="country" value="{{ old('country') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="postal_code"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Postal Code') }}
                                </label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="latitude"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Latitude') }}
                                </label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="longitude"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Longitude') }}
                                </label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Phone') }}
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Email') }}
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="website_url"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Website URL') }}
                                </label>
                                <input type="text" name="website_url" id="website_url" value="{{ old('website_url') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Status') }}
                                </label>
                                <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="is_featured"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Featured') }}
                                </label>
                                <select name="is_featured" id="is_featured"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white">
                                    <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="main_image_url"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    {{ __('Main Image') }}
                                </label>
                                <input type="file" name="main_image_url" id="main_image_url"
                                       class="focus:border-ring-brand-300 cursor-pointer focus:file:ring-brand-300 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:px-4 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 px-4">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-start gap-4">
                            <button type="button" class="btn-primary" id="generateAI" class="btn-secondary">{{ __('Search') }}</button>
                            <button type="submit" class="btn-primary">{{ __('Save') }}</button>
                            <a href="{{ route('admin.parks.index') }}" class="btn-default">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#name').on('input', function () {
                let slug = $(this).val()
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-');

                $('#slug').val(slug);
            });

            $('#latitude').on('input', function () {
                $(this).val($(this).val().replace(/[^0-9.-]/g, ''));
            });

            $('#longitude').on('input', function () {
                $(this).val($(this).val().replace(/[^0-9.-]/g, ''));
            });


            $('#generateAI').on('click', function () {
                let formData = {};
                $('#park_form').find('input, textarea, select').each(function() {
                    let name = $(this).attr('name');
                    let value = $(this).val();

                    if (name && name !== 'main_image_url') {
                        formData[name] = value;
                    }
                });

                $('#ajaxLoader').removeClass('hidden');
                $('#generateAI').attr('disabled', true).text('Processing...');

                $.ajax({
                    url: '{{ route("admin.parks.openAi") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        formData: formData
                    },
                    success: function (response) {
                        if (!response.data || Object.keys(response.data).length === 0) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'No matching data found. Try removing or updating some filter values to refine your search.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            return;
                        }
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Successfully Fetched',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        Object.keys(response.data).forEach(field => {
                            const el = document.querySelector(`[name="${field}"]`);
                            if (el) {
                                el.value = response.data[field];
                            }
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: xhr.responseText,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    },
                    complete: function () {
                        $('#ajaxLoader').addClass('hidden');
                        $('#generateAI').attr('disabled', false).text('Search');
                    }
                });
            });

            $('.select2').select2();

            $('#parkDropdown').select2({
                placeholder: 'Select or search a park',
                allowClear: true,
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route("admin.parks.searchPark") }}',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.over_pass.map(function(park) {
                                return {
                                    id: park.name,
                                    text: park.name,
                                    state: park.state,
                                    city: park.city,
                                    zip: park.zip,
                                    latitude: park.latitude,
                                    longitude: park.longitude
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#parkDropdown').on('select2:select', function (e) {
                var park = e.params.data;

                $('[name="name"]').val(park.text);
                $('[name="slug"]').val(slugify(park.text));

                $('[name="state"]').val(park.state || '');
                $('[name="city"]').val(park.city || '');
                $('[name="zip"]').val(park.zip || '');
                $('[name="latitude"]').val(park.latitude || '');
                $('[name="longitude"]').val(park.longitude || '');
                
                $('[name="email"]').val('');
                $('[name="address"]').val('');
                $('[name="website_url"]').val('');
                $('[name="country"]').val('');
                $('[name="description"]').val('');
                $('[name="short_description"]').val('');
                $('[name="phone"]').val('');
            });

            $('#parkDropdown').on('select2:clear', function () {
                $('[name="name"]').val('');
                $('[name="slug"]').val('');
                $('[name="state"]').val('');
                $('[name="city"]').val('');
                $('[name="zip"]').val('');
                $('[name="latitude"]').val('');
                $('[name="longitude"]').val('');
                
                $('[name="email"]').val('');
                $('[name="address"]').val('');
                $('[name="website_url"]').val('');
                $('[name="country"]').val('');
                $('[name="description"]').val('');
                $('[name="short_description"]').val('');
                $('[name="phone"]').val('');
            });

            function slugify(text) {
                return text
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-');
            }

            $('#change_name').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#inputWrapper').addClass('hidden').find('input').prop('disabled', true);
                    $('#selectWrapper').removeClass('hidden').find('select').prop('disabled', false);
                    $('#name_check_box_label').text('Manual');

                    $('[name="name"]').val('');
                    $('[name="slug"]').val('');
                    $('#parkDropdown').val(null).trigger('change');
                } else {
                    $('#inputWrapper').removeClass('hidden').find('input').prop('disabled', false);
                    $('#selectWrapper').addClass('hidden').find('select').prop('disabled', true);
                    $('#name_check_box_label').text('Search');

                    $('#parkDropdown').val(null).trigger('change');
                    $('[name="name"]').val('');
                    $('[name="slug"]').val('');
                }
            }).trigger('change');
        });
    </script>

@endsection

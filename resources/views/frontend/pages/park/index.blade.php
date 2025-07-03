@extends('frontend.pages.layouts.app')

<style>
        .park-card {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 6px 32px rgba(60, 72, 88, 0.09), 0 1.5px 6px rgba(80, 80, 100, 0.06);
            overflow: hidden;
            transition: box-shadow 0.25s cubic-bezier(.32,2,.55,.27), transform 0.25s, border-color 0.21s, background 0.19s;
            position: relative;
            margin-bottom: 1.5rem;
            border: 1.5px solid #f2f2f4;
        }
    
        .park-card:hover,
        .park-card:focus-within {
            box-shadow: 0 16px 40px rgba(60,64,67,0.14), 0 4px 16px rgba(80,80,120,0.11);
            transform: translateY(-4px) scale(1.025);
            border-color: #3c4043;
            background: #e0e0e0;
            z-index: 2;
        }
        
        .park-image-container {
            position: relative;
            background: linear-gradient(120deg, #f5fafb 80%, #e0e0e0 100%);
            overflow: hidden;
            min-height: 170px;
        }
        
        .park-image-container img.main {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
            transition: transform 0.22s cubic-bezier(.32,2,.55,.27), filter 0.2s;
            border-bottom: 1.5px solid #f2f2f4;
        }
        
        .park-card:hover img.main,
        .park-card:focus-within img.main {
            transform: scale(1.04) translateY(-2px);
            filter: brightness(0.97) saturate(1.02);
        }

        .park-overlay {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 20px;
            background: #3c4043;
            color: #fff;
            font-weight: 500;
            border-radius: 2rem;
            font-size: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.21s, background 0.19s;
            box-shadow: 0 2px 12px rgba(60,64,67,0.11);
        }
        
        .park-card:hover .park-overlay,
        .park-card:focus-within .park-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        
        .winner-badges {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 0.5rem;
            z-index: 2;
        }
    
        .winner-badges img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2.5px solid #fff;
            background: #fff;
            box-shadow: 0 2px 8px rgba(160,160,180,0.09);
            object-fit: cover;
            transition: transform 0.16s;
        }
        
        .winner-badges img:hover {
            transform: scale(1.11) rotate(-6deg);
        }
        
        .park-card h5 {
            font-weight: 700;
            font-size: 1.16rem;
            letter-spacing: .01em;
            line-height: 1.28; /* Slightly reduced */
            margin-bottom: 0.2em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }
        
        .park-card h5 a {
            color: #3c4043;
            transition: color 0.18s;
            text-shadow: 0 1px 4px rgba(255,255,255,0.13);
        }
        
        .park-card h5 a:hover,
        .park-card h5 a:focus {
            color: #1766ce;
            text-decoration: underline;
            outline: none;
        }

        
        .fixed-advanced-filter-btn:focus,
        .fixed-advanced-filter-btn:hover {
            color: #fff !important;
        }
        .fixed-advanced-filter-btn:focus i,
        .fixed-advanced-filter-btn:hover i {
            color: #fff !important;
        }
        
        .fixed-advanced-filter-btn {
            position: fixed;
            top: 44vh; /* vertical middle; adjust if needed */
            right: 0;
            z-index: 1003;
            background: #3c4043;
            color: #fff;
            border: none;
            border-radius: 30px 0 0 30px;
            box-shadow: 0 6px 32px rgba(24, 80, 200, 0.10);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.38em;
            padding: 0.74em 1.4em 0.74em 1.1em;
            font-size: 1.08em;
            letter-spacing: .01em;
            cursor: pointer;
            transition: background 0.16s, color 0.14s, box-shadow 0.19s;
            writing-mode: horizontal-tb;
        }
        
        .fixed-advanced-filter-btn:hover,
        .fixed-advanced-filter-btn:focus {
            background: #e0e0e0;
            color: #1e2022;
            box-shadow: 0 10px 36px rgba(24, 80, 200, 0.16);
            text-decoration: none;
            outline: 2px solid #b6b9bc;
            outline-offset: 2px;
        }
        
        .fixed-advanced-filter-btn i {
            font-size: 1.4em;
            color: inherit;
            margin-right: 0.55em;
        }
        
        @media (max-width: 768px) {
            .fixed-advanced-filter-btn {
                top: auto;
                bottom: 16vw;
                right: 0;
                font-size: 0.99em;
                padding: 0.58em 1.1em 0.58em 0.9em;
                border-radius: 20px 0 0 20px;
            }
        }
        
        .park-image-container {
            min-height: 260px;
        }
        
        .park-image-container img.main {
            height: 260px;
            object-fit: cover;
        }
        
        .p-4 {
            padding: 2rem !important;
        }

    </style>
    
@section('content')
    
    <section id="page-title" class="text-light"
             data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>Parks</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li>{{ request()->segment(1) }}</li>
                    <li>{{ request()->segment(2) }}</li>
                    @if(request()->segment(3))
                        <li><a href="{{ route('rv-park.park-country') }}">{{ request()->segment(3) }}</a></li>
                    @endif
                    @if(request()->segment(4))
                        <li class="active">{{ strtolower(request()->segment(4)) }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
    <section id="page-content">
        <div>
            
            <a href="#advancedFilterModal"
               data-lightbox="inline"
               class="fixed-advanced-filter-btn"
               aria-label="Advanced Filters">
                <!-- Inline Filter SVG Icon -->
                <svg width="22" height="22" viewBox="0 0 20 20" fill="none" aria-hidden="true" focusable="false" style="margin-right:0.55em;" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="5" width="16" height="2" rx="1" fill="currentColor"/>
                    <rect x="5" y="9" width="10" height="2" rx="1" fill="currentColor"/>
                    <rect x="8" y="13" width="4" height="2" rx="1" fill="currentColor"/>
                </svg>
                Advanced Filters
            </a>
            
            <div id="advancedFilterModal" class="modal no-padding" data-delay="3000" style="max-width: 780px;">
                <div class="row">
                    <div class="col-md-6 no-padding"></div>
                    <div class="col-md-12">
                        <div class="p-40 p-t-60 p-xs-20">
                            <h3><i class="bi bi-funnel"></i> Advanced Filters</h3>
                            <form id="advancedFilterForm" class="form-grey-fields" onsubmit="return false;">

                                @if ($parks['amenities'])
                                    <div class="mb-5">
                                        <h5 class="mb-3 text-muted">
                                            <i class="bi bi-tools me-2 text-primary fs-5"></i> Amenities
                                        </h5>

                                        @foreach($parks['amenities']->groupBy('category') as $category => $items)
                                            <div class="mb-4 p-4 rounded-3 border ">
                                                <div class="fw-semibold mb-3 text-uppercase text-dark">
                                                    <i class="bi bi-folder-fill text-secondary me-2"></i>{{ $category }}
                                                </div>

                                                <div class="row">
                                                    @foreach($items as $amenity)
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <div
                                                                class="form-check border rounded-3 shadow-sm bg-white px-3 py-2 d-flex align-items-center gap-2 hover-shadow transition">

                                                                {{-- Checkbox --}}
                                                                <input class="form-check-input custom-check mt-0"
                                                                       type="checkbox"
                                                                       id="amenity_{{ $amenity->id }}"
                                                                       name="amenities[]"
                                                                       value="{{ $amenity->id }}"
                                                                    {{ is_array(request('amenities')) && in_array($amenity->id, request('amenities')) ? 'checked' : '' }}>

                                                                {{-- Label --}}
                                                                <label
                                                                    class="form-check-label text-dark small mb-0 ms-2"
                                                                    for="amenity_{{ $amenity->id }}">
                                                                    {{ $amenity->amenity }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif


                                {{-- Site Availability --}}
                                <div class="mt-4">
                                    <h5 class="mb-3"><i class="bi bi-plug"></i> Filter by Site Availability</h5>

                                    <div class="row">
                                        @foreach ($parks['siteFields'] as $field => $label)
                                            <div class="col-md-6 mb-4">
                                                <label for="{{ $field }}" class="form-label text-muted fw-semibold">
                                                    {{ __($label) }}
                                                </label>
                                                <input
                                                    type="number"
                                                    min="0"
                                                    name="{{ $field }}"
                                                    id="{{ $field }}"
                                                    value="{{ request($field, '') }}"
                                                    class="form-control site-input only-positive"
                                                    placeholder="e.g. 5 or more"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Unique Apply Button --}}
                                <div class="form-group mt-4">
                                    <button
                                        class="btn btn-gradient-apply w-100 d-flex align-items-center justify-content-center gap-2"
                                        type="submit">
                                        <i class="bi bi-funnel-fill fs-5"></i>
                                        <span class="fw-semibold">Apply Filters</span>
                                    </button>
                                </div>
                            </form>

                            {{-- Clear Filters Link --}}
                            <p class="text-center mt-3">
                                <a href="#" onclick="resetParkFilters(); return false;" class="text-danger small">
                                    <i class="bi bi-x-circle-fill"></i> Clear All Filters
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="shop container">
                <div class="grid-layout grid-5-columns" data-item="grid-item">
                    @forelse($parks['parks'] as $park)
                        <div class="grid-item park-item"
                             data-name="{{ $park->name }}"
                             data-city="{{ $park->city }}"
                             data-state="{{ $park->state }}"
                             data-amenities="{{ $park->amenities->pluck('id')->implode(',') }}"
                             @foreach($parks['siteFields'] as $field => $label)
                             data-{{ $field }}="{{ $park->$field }}"
                            @endforeach
                        >
                            <div class="park-card">
                                <div class="park-image-container">
                                    {{-- State Badge --}}
                                    @if($park->state)
                                        <div class="state-badge">
                                            {{ strtoupper($park->state) }}
                                        </div>
                                    @endif

                                    {{-- Winner Badges --}}
                                    <div class="winner-badges">
                                        @foreach($park->winnerParks as $winner)
                                            <img src="{{ asset('assets/winner-park.png') }}"
                                                 alt="Winner - {{ \Carbon\Carbon::parse($winner->date)->year }}"
                                                 title="Winner - {{ \Carbon\Carbon::parse($winner->date)->year }}"/>
                                        @endforeach
                                    </div>
                                    
                                    @php
                                        $imagePath = $park->main_image_url;
                                        $imageUrl = !empty($imagePath) ?
                                            (preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath))
                                            : asset('images/placeholder.jpg');
                                    @endphp

                                    <a href="{{ route('rv-park.park-show', $park->slug_path) }}">
                                        <img class="main" src="{{ $imageUrl }}"
                                             onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}';"
                                             alt="Park Image">
                                        <div class="park-overlay">View Park</div>
                                    </a>
                                </div>

                                <div class="p-3 text-center">
                                    <h5 class="mb-0">
                                        <a href="{{ route('rv-park.park-show', $park->slug_path) }}"
                                           class="text-dark text-decoration-none">
                                            {{ ucfirst($park->name) }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="grid-item w-100 d-flex justify-content-center">
                            <div class="park-card text-center border border-warning rounded shadow-sm p-4"
                                 style="max-width: 400px;">
                                <h5 class="text-warning mb-2">
                                    <i class="bi bi-exclamation-circle"></i> No Parks Found
                                </h5>
                                <p class="text-muted mb-0">
                                    We couldn't find any parks matching your selection.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>


            @if($parks['parks']->total() > 0 || $parks['parks']->total() > 12)
                @include('frontend.pages.layouts.partials.pagination', ['paginator' => $parks['parks']])
            @endif
        </div>
    </section>
    <script>
        $(document).ready(function () {
            $('#state-form').on('submit', function (e) {
                e.preventDefault();
                const state = $('#state-select').val();
                const base = "{{ url('/en-us/parks/usa') }}";

                if (state) {
                    window.location.href = `${base}/${state}`;
                } else {
                    window.location.href = base;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('advancedFilterForm').addEventListener('submit', function (e) {
                e.preventDefault();

                var name = (document.getElementById('filterName') || {value: ''}).value.toLowerCase();
                var city = (document.getElementById('filterCity') || {value: ''}).value.toLowerCase();
                var state = (document.getElementById('filterState') || {value: ''}).value.toLowerCase();

                // Amenities
                var selectedAmenities = Array.from(document.querySelectorAll('input[name="amenities[]"]:checked')).map(cb => cb.value);

                // Site fields
                var siteFields = @json(array_keys($parks['siteFields']));
                var siteFieldValues = {};
                siteFields.forEach(function (field) {
                    var el = document.getElementById(field);
                    if (el && el.value) siteFieldValues[field] = parseInt(el.value);
                });

                var parks = document.querySelectorAll('.park-item');
                var anyVisible = false;
                parks.forEach(function (park) {
                    var parkName = (park.getAttribute('data-name') || '').toLowerCase();
                    var parkCity = (park.getAttribute('data-city') || '').toLowerCase();
                    var parkState = (park.getAttribute('data-state') || '').toLowerCase();
                    var parkAmenities = (park.getAttribute('data-amenities') || '').split(',');
                    var show = true;
                    if (name && !parkName.includes(name)) show = false;
                    if (city && !parkCity.includes(city)) show = false;
                    if (state && !parkState.includes(state)) show = false;
                    // Amenities filter (all selected must be present)
                    if (selectedAmenities.length > 0 && !selectedAmenities.every(aid => parkAmenities.includes(aid))) show = false;
                    // Site fields filter
                    for (var field in siteFieldValues) {
                        var parkVal = parseInt(park.getAttribute('data-' + field) || '0');
                        if (isNaN(parkVal) || parkVal < siteFieldValues[field]) show = false;
                    }
                    park.style.display = show ? '' : 'none';
                    if (show) anyVisible = true;
                });

                // No Parks Found message
                var noParksDivId = 'noParksFoundMsg';
                var existingMsg = document.getElementById(noParksDivId);
                if (!anyVisible) {
                    if (!existingMsg) {
                        var msg = document.createElement('div');
                        msg.id = noParksDivId;
                        msg.className = 'grid-item w-100 d-flex justify-content-center';
                        msg.innerHTML = `<div class="park-card text-center border border-warning rounded shadow-sm p-4" style="max-width: 400px;">
                            <h5 class="text-warning mb-2">
                                <i class="bi bi-exclamation-circle"></i> No Parks Found
                            </h5>
                            <p class="text-muted mb-0">
                                We couldn't find any parks matching your selection.
                            </p>
                        </div>`;
                        var grid = document.querySelector('.grid-layout.grid-5-columns');
                        if (grid) grid.appendChild(msg);
                    }
                } else {
                    if (existingMsg) existingMsg.remove();
                }
                // Modal band karne ke liye .mfp-close par click trigger karo
                var mfpClose = document.querySelector('.mfp-close');
                if (mfpClose) mfpClose.click();
            });
        });

        function resetParkFilters() {
            // Text fields
            var textFields = ['filterName', 'filterCity', 'filterState'];
            textFields.forEach(function (id) {
                var el = document.getElementById(id);
                if (el) el.value = '';
            });
            // Amenities checkboxes
            document.querySelectorAll('input[name="amenities[]"]').forEach(function (cb) {
                cb.checked = false;
            });
            // Site fields
            var siteFields = @json(array_keys($parks['siteFields']));
            siteFields.forEach(function (field) {
                var el = document.getElementById(field);
                if (el) el.value = '';
            });
            // Sab parks wapas show karo
            document.querySelectorAll('.park-item').forEach(function (park) {
                park.style.display = '';
            });
            // No Parks Found message ko remove karo
            var existingMsg = document.getElementById('noParksFoundMsg');
            if (existingMsg) existingMsg.remove();
            // Modal band karne ke liye .mfp-close par click trigger karo
            var mfpClose = document.querySelector('.mfp-close');
            if (mfpClose) mfpClose.click();
        }

        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('.only-positive');

            inputs.forEach(input => {
                // Prevent typing "-" or "e"
                input.addEventListener('keydown', function (e) {
                    if (e.key === '-' || e.key === 'e') {
                        e.preventDefault();
                    }
                });

                // Prevent pasting negative numbers
                input.addEventListener('paste', function (e) {
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    if (paste.includes('-') || paste.includes('e')) {
                        e.preventDefault();
                    }
                });

                // Reset negative values on input
                input.addEventListener('input', function () {
                    if (this.value < 0) this.value = 0;
                });
            });
        });
    </script>
@endsection

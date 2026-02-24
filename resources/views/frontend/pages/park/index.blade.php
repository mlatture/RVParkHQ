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
        
        .fixed-advanced-filter-btn:hover {
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
        
         .heart-icon {
            transition: fill 0.2s, stroke 0.2s, transform 0.15s;
        }
        
        .favorite-heart.active .heart-icon {
            transform: scale(1.15);
            transition: transform 0.15s;
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
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
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
                                {{-- State Filter --}}
                                <div class="mb-5">
                                    <h5 class="mb-3 text-muted">
                                        <i class="bi bi-geo-alt text-primary fs-5 me-2"></i> Filter by State
                                    </h5>
                                    @php $currentState = request()->segment(4) ? strtoupper(str_replace('-', ' ', request()->segment(4))) : ''; @endphp
                                    <select id="filterState" class="form-select shadow-sm">
                                        <option value="">All States</option>
                                        @foreach($allStates ?? [] as $st)
                                            <option value="{{ strtolower($st) }}" {{ $currentState === $st ? 'selected' : '' }}>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-5">
                                    <h5 class="mb-3 text-muted">
                                        <i class="bi bi-plug text-primary fs-5 me-2"></i> Filter by Site Availability
                                    </h5>
                                    <div class="row">
                                        @foreach ($parks['siteFields'] as $field => $label)
                                            @php
                                                // Automatically extract number from field name
                                                preg_match('/(\d+)/', $field, $matches);
                                                $numericValue = $matches[1] ?? 0;
                                            @endphp
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check border rounded-3 shadow-sm bg-white px-3 py-2">
                                                    <input class="form-check-input custom-check mt-0"
                                                           type="checkbox"
                                                           id="{{ $field }}"
                                                           name="site_availability[{{ $field }}]"
                                                           value="{{ $numericValue }}">
                                                    <label class="form-check-label text-dark small mb-0 ms-2" for="{{ $field }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- ✅ Amenities --}}
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
                                                            <div class="form-check border rounded-3 shadow-sm bg-white px-3 py-2 d-flex align-items-center gap-2 hover-shadow transition">
                                                                <input class="form-check-input custom-check mt-0"
                                                                       type="checkbox"
                                                                       id="amenity_{{ $amenity->id }}"
                                                                       name="amenities[]"
                                                                       value="{{ $amenity->id }}"
                                                                    {{ is_array(request('amenities')) && in_array($amenity->id, request('amenities')) ? 'checked' : '' }}>
                                                                <label class="form-check-label text-dark small mb-0 ms-2" for="amenity_{{ $amenity->id }}">
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
                                {{-- Submit Button --}}
                                <div class="form-group mt-4">
                                    <button class="btn btn-gradient-apply w-100 d-flex align-items-center justify-content-center gap-2" type="submit">
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
                        @php $user = Auth::user(); @endphp
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
                                <div class="park-image-container position-relative">
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
                                    
                                    {{-- Heart Icon for Favorites --}}
                                    @auth
                                        @php $isFavorited = $user->hasFavoritedPark($park->id); @endphp
                                        <span class="favorite-heart" data-park-id="{{ $park->id }}" style="position:absolute;top:14px;right:14px;z-index:10;cursor:pointer;">
                                            @if($isFavorited)
                                                <svg class="heart-icon" width="28" height="28" viewBox="0 0 24 24" fill="#e74c3c" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21C12 21 4 13.36 4 8.5C4 5.42 6.42 3 9.5 3C11.24 3 12.91 3.81 14 5.08C15.09 3.81 16.76 3 18.5 3C21.58 3 24 5.42 24 8.5C24 13.36 16 21 16 21H12Z"></path></svg>
                                            @else
                                                <svg class="heart-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21C12 21 4 13.36 4 8.5C4 5.42 6.42 3 9.5 3C11.24 3 12.91 3.81 14 5.08C15.09 3.81 16.76 3 18.5 3C21.58 3 24 5.42 24 8.5C24 13.36 16 21 16 21H12Z"></path></svg>
                                            @endif
                                        </span>
                                    @endauth
                                    
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
            $('#advancedFilterForm').on('submit', function (e) {
                e.preventDefault();

                let name = ($('#filterName').val() || '').toLowerCase();
                let city = ($('#filterCity').val() || '').toLowerCase();
                let state = ($('#filterState').val() || '').toLowerCase();

                // Get selected amenities
                let selectedAmenities = $('input[name="amenities[]"]:checked').map(function () {
                    return this.value;
                }).get();

                // Get selected site availability values as an object
                let selectedSiteFields = {};
                $('input[name^="site_availability["]:checked').each(function () {
                    let match = $(this).attr('name').match(/\[([^\]]+)\]/);
                    if (match) {
                        let field = match[1];
                        selectedSiteFields[field] = parseInt($(this).val()) || 0;
                    }
                });

                console.log("Selected Site Availability Fields:", selectedSiteFields);

                // Debug: Log park data for first few parks
                $('.park-item').each(function(index) {
                    if (index < 3) { // Only log first 3 parks to avoid spam
                        let park = $(this);
                        console.log(`Park ${index + 1}:`, {
                            name: park.data('name'),
                            sites_50amp_full: park.data('sites_50amp_full'),
                            sites_30amp_full: park.data('sites_30amp_full'),
                            sites_30amp_water_electric: park.data('sites_30amp_water_electric')
                        });
                    }
                });

                let anyVisible = false;

                $('.park-item').each(function () {
                    let park = $(this);
                    let parkName = (park.data('name') || '').toString().toLowerCase();
                    let parkCity = (park.data('city') || '').toString().toLowerCase();
                    let parkState = (park.data('state') || '').toString().toLowerCase();
                    let parkAmenities = (park.data('amenities') || '').toString().split(',');

                    let show = true;

                    // Text match filters
                    if (name && !parkName.includes(name)) show = false;
                    if (city && !parkCity.includes(city)) show = false;
                    if (state && parkState !== state) show = false;

                    // Amenity check (must include all selected)
                    if (selectedAmenities.length > 0) {
                        let hasAllAmenities = selectedAmenities.every(aid => parkAmenities.includes(aid));
                        if (!hasAllAmenities) show = false;
                    }


                $.each(selectedSiteFields, function (field, requiredVal) {
                    let parkVal = parseInt(park.data(field)) || 0;
                    console.log(`Checking ${field}: Park has ${parkVal}, Required: ${requiredVal}`);
                    if (parkVal < requiredVal) {
                        console.log(`Park ${park.data('name')} filtered out: ${field} insufficient`);
                        show = false;
                    }
                });

                    park.toggle(show);
                    if (show) anyVisible = true;
                })

                // No Parks Found Message
                const noParksMsgID = '#noParksFoundMsg';
                $(noParksMsgID).remove();

                if (!anyVisible) {
                    $('.grid-layout.grid-5-columns').css({
                      'margin': '',
                      'position': '',
                      'height': ''
                    });
                    $('.grid-layout.grid-5-columns').append(`
                <div id="noParksFoundMsg" class="grid-item w-100 d-flex justify-content-center">
                    <div class="park-card text-center border border-warning rounded shadow-sm p-4" style="max-width: 400px;">
                        <h5 class="text-warning mb-2">
                            <i class="bi bi-exclamation-circle"></i> No Parks Found
                        </h5>
                        <p class="text-muted mb-0">We couldn't find any parks matching your selection.</p>
                    </div>
                </div>`);
                }

                // Close modal
                $('.mfp-close').trigger('click');
            });

            // State dropdown: server-side filter (works across pages)
            $('#filterState').on('change', function() {
                var state = $(this).val();
                if (state) {
                    window.location.href = '{{ url("en-us/parks") }}/' + state;
                } else {
                    window.location.href = '{{ url("en-us/parks") }}';
                }
            });

            // Reset filters
            window.resetParkFilters = function () {
                $('#filterName, #filterCity, #filterState').val('');
                $('input[name="amenities[]"]').prop('checked', false);
                $('input[name^="site_availability["]').prop('checked', false);

                $('.grid-layout.grid-5-columns').css({
                  'margin': '0px -20px -20px 0px',
                  'position': 'relative',
                  'height': '1098.91px'
                });
                $('.park-item').show();
                $('#noParksFoundMsg').remove();
                $('.mfp-close').trigger('click');
            };
        });
    
        $(document).ready(function() {
            // Use event delegation for dynamically updated hearts
            $(document).on('click', '.favorite-heart', function(e) {
                e.preventDefault();
                var heart = $(this);
                var parkId = heart.data('park-id');
                var isFavorited = heart.find('svg[fill="#e74c3c"]').length > 0;
                var url = isFavorited ? '{{ route('rv-park.park.unfavorite') }}' : '{{ route('rv-park.park.favorite') }}';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        park_id: parkId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'favorited') {
                            heart.html('<svg class="heart-icon" width="28" height="28" viewBox="0 0 24 24" fill="#e74c3c" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21C12 21 4 13.36 4 8.5C4 5.42 6.42 3 9.5 3C11.24 3 12.91 3.81 14 5.08C15.09 3.81 16.76 3 18.5 3C21.58 3 24 5.42 24 8.5C24 13.36 16 21 16 21H12Z"></path></svg>');
                            heart.addClass('active');
                            setTimeout(function(){ heart.removeClass('active'); }, 150);
                        } else if (response.status === 'unfavorited') {
                            heart.html('<svg class="heart-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21C12 21 4 13.36 4 8.5C4 5.42 6.42 3 9.5 3C11.24 3 12.91 3.81 14 5.08C15.09 3.81 16.76 3 18.5 3C21.58 3 24 5.42 24 8.5C24 13.36 16 21 16 21H12Z"></path></svg>');
                            heart.addClass('active');
                            setTimeout(function(){ heart.removeClass('active'); }, 150);
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status === 401) {
                            alert('Please login to favorite parks.');
                        }
                    }
                });
            });
        });
    </script>
@endsection

@extends('frontend.pages.layouts.app')

@php
    $currentUrl = url('/campgrounds/' . $stateInfo['slug']);
    $pageTitle = "Campgrounds & RV Parks in {$stateName}";
    $metaTitle = "Campgrounds in {$stateName} | RVParkHQ";
    $metaDesc = "Explore {$totalParks} campgrounds and RV parks in {$stateName}. Filter by amenities, sort by rating or city.";
@endphp

@section('content')
    {{-- Hero --}}
    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>{{ $pageTitle }}</h1>
                <span>{{ number_format($totalParks) }} parks found in {{ $stateName }}</span>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/campgrounds') }}">Campgrounds</a></li>
                    <li class="active">{{ $stateName }}</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            {{-- Stats Bar --}}
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                        <span class="badge" style="background: #333; color: #fff; font-size: 0.9rem; padding: 8px 14px; border-radius: 20px;">
                            <i class="fas fa-campground"></i> {{ number_format($totalParks) }} Parks
                        </span>
                        <span class="badge" style="background: #555; color: #fff; font-size: 0.9rem; padding: 8px 14px; border-radius: 20px;">
                            <i class="fas fa-city"></i> {{ $topCities->count() }} Top Cities
                        </span>
                        @foreach($topAmenities->take(4) as $amenity)
                            <span class="badge" style="background: #f8f9fa; color: #333; font-size: 0.8rem; padding: 6px 12px; border-radius: 20px; border: 1px solid #ddd;">
                                {{ $amenity->amenity }}
                            </span>
                        @endforeach
                    </div>
                    <x-social-share :url="$currentUrl" :title="$metaTitle" :image="$ogImage ?? ''" />
                </div>
                <div class="col-md-4 text-md-end">
                    {{-- Toggle links --}}
                    <div class="mb-2" style="font-size: 0.85rem;">
                        @if(request('include_federal'))
                            <a href="{{ request()->fullUrlWithoutQuery('include_federal') }}" class="text-danger"><i class="fas fa-times"></i> Hide Federal Parks</a>
                        @else
                            <a href="{{ request()->fullUrlWithQuery(['include_federal' => 1]) }}"><i class="fas fa-tree"></i> Show Federal Parks</a>
                        @endif
                        &nbsp;|&nbsp;
                        @if(request('include_harvest_hosts'))
                            <a href="{{ request()->fullUrlWithoutQuery('include_harvest_hosts') }}" class="text-danger"><i class="fas fa-times"></i> Hide Harvest Hosts</a>
                        @else
                            <a href="{{ request()->fullUrlWithQuery(['include_harvest_hosts' => 1]) }}"><i class="fas fa-wine-bottle"></i> Show Harvest Hosts</a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="card mb-4 p-3" style="border-radius: 10px; border: 1px solid #eee;">
                <form method="GET" action="{{ url('/campgrounds/' . $stateInfo['slug']) }}" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Park name or city..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Sort By</label>
                        <select name="sort" class="form-control">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                            <option value="city" {{ request('sort') == 'city' ? 'selected' : '' }}>City</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Amenity</label>
                        <select name="amenity[]" class="form-control" multiple style="height: 38px;">
                            @foreach($amenities as $amenity)
                                <option value="{{ $amenity->id }}" {{ in_array($amenity->id, (array) request('amenity')) ? 'selected' : '' }}>
                                    {{ $amenity->amenity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        @if(request('include_federal'))
                            <input type="hidden" name="include_federal" value="1">
                        @endif
                        @if(request('include_harvest_hosts'))
                            <input type="hidden" name="include_harvest_hosts" value="1">
                        @endif
                        <button type="submit" class="btn btn-dark w-100"><i class="fas fa-search"></i> Filter</button>
                    </div>
                </form>
            </div>

            {{-- Park Grid --}}
            @if($parks->count())
                <div class="row">
                    @foreach($parks as $park)
                        @php
                            $imagePath = $park->main_image_url;
                            if (!empty($imagePath)) {
                                $imageUrl = preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath);
                            } else {
                                $imageUrl = asset('images/login.jpg');
                            }
                            $parkUrl = route('rv-park.park-show', ['slug_path' => $park->slug_path]);
                        @endphp
                        <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                            <div class="card h-100" style="border-radius: 12px; overflow: hidden; border: 1px solid #eee; transition: all 0.2s;">
                                <a href="{{ $parkUrl }}">
                                    <img src="{{ $imageUrl }}"
                                         onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';"
                                         alt="{{ $park->name }}"
                                         style="width: 100%; height: 180px; object-fit: cover;">
                                </a>
                                <div class="card-body p-3">
                                    @if($park->park_type)
                                        <span class="badge mb-1" style="background: #ffc107; color: #333; font-size: 0.7rem;">
                                            {{ $park->getTypeLabel() }}
                                        </span>
                                    @endif
                                    <h6 class="mb-1">
                                        <a href="{{ $parkUrl }}" style="color: #333; text-decoration: none;">{{ $park->name }}</a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> {{ $park->city }}, {{ $stateInfo['abbr'] }}
                                    </small>
                                    @if($park->google_rating)
                                        <div class="mt-1">
                                            <span style="color: #ffc107;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($park->google_rating))★@else☆@endif
                                                @endfor
                                            </span>
                                            <small class="text-muted">({{ $park->google_review_count ?? 0 }})</small>
                                        </div>
                                    @endif
                                    @if($park->amenities->count())
                                        <div class="mt-2">
                                            @foreach($park->amenities->take(3) as $amenity)
                                                @if($amenity->blackicon)
                                                    @php
                                                        $iconPath = $amenity->blackicon;
                                                        $iconUrl = preg_match('/^https?:\/\//', $iconPath) ? $iconPath : asset('storage/' . $iconPath);
                                                    @endphp
                                                    <img src="{{ $iconUrl }}" style="width: 20px; height: 20px; object-fit: contain;" alt="{{ $amenity->amenity }}" title="{{ $amenity->amenity }}">
                                                @endif
                                            @endforeach
                                            @if($park->amenities->count() > 3)
                                                <small class="text-muted">+{{ $park->amenities->count() - 3 }}</small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $parks->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-campground fa-3x text-muted mb-3"></i>
                    <h4>No parks found in {{ $stateName }}</h4>
                    <p class="text-muted">Try adjusting your filters or search terms.</p>
                    <a href="{{ route('rv-park.suggest.park') }}" class="btn btn-warning">
                        <i class="fas fa-plus"></i> Suggest a Campground
                    </a>
                </div>
            @endif

            {{-- Top Cities --}}
            @if($topCities->count())
                <div class="mt-5 mb-3">
                    <h4>Top Cities in {{ $stateName }}</h4>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($topCities as $city => $count)
                            <span class="badge" style="background: #f8f9fa; color: #333; padding: 6px 14px; border-radius: 20px; border: 1px solid #ddd; font-size: 0.85rem;">
                                {{ $city }} ({{ $count }})
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Schema.org ItemList --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "{{ $pageTitle }}",
        "url": "{{ $currentUrl }}",
        "numberOfItems": {{ $totalParks }},
        "itemListElement": [
            @foreach($parks as $i => $park)
            {
                "@type": "ListItem",
                "position": {{ $i + 1 }},
                "url": "{{ route('rv-park.park-show', ['slug_path' => $park->slug_path]) }}",
                "name": "{{ addslashes($park->name) }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    }
    </script>
@endsection

@section('meta')
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:type" content="website">
    @if(!empty($ogImage))
        @php $ogImgUrl = preg_match('/^https?:\/\//', $ogImage) ? $ogImage : asset('storage/' . $ogImage); @endphp
        <meta property="og:image" content="{{ $ogImgUrl }}">
        <meta name="twitter:image" content="{{ $ogImgUrl }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
@endsection

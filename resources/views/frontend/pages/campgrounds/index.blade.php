@extends('frontend.pages.layouts.app')

@section('content')
    {{-- Hero --}}
    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>Find Campgrounds &amp; RV Parks Across America</h1>
                <span>Browse {{ number_format($totalParks) }} campgrounds across all 50 states</span>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Campgrounds</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="text-center mb-5">
                <h2>Explore by Region</h2>
                <p class="text-muted">Select a state to discover campgrounds, RV parks, and outdoor stays.</p>
                <x-social-share :url="url('/campgrounds')" title="Find Campgrounds & RV Parks Across America | RVParkHQ" />
            </div>

            @foreach($regions as $regionName => $states)
                <div class="mb-5">
                    <h3 class="mb-3" style="border-left: 4px solid #ffc107; padding-left: 12px;">{{ $regionName }}</h3>
                    <div class="row">
                        @foreach($states as $state)
                            <div class="col-6 col-md-4 col-lg-3 mb-3">
                                <a href="{{ url('/campgrounds/' . $state['slug']) }}" class="text-decoration-none">
                                    <div class="card h-100 text-center p-3" style="border-radius: 10px; transition: all 0.2s; border: 1px solid #eee;">
                                        <div style="font-size: 2rem;">🏕️</div>
                                        <h5 class="mt-2 mb-1" style="color: #333;">{{ $state['name'] }}</h5>
                                        <span class="text-muted" style="font-size: 0.85rem;">
                                            {{ number_format($state['park_count']) }} {{ Str::plural('park', $state['park_count']) }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Schema.org --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Campgrounds & RV Parks Across America",
        "description": "Browse {{ number_format($totalParks) }} campgrounds and RV parks across all 50 US states.",
        "url": "{{ url('/campgrounds') }}"
    }
    </script>
@endsection

@section('meta')
    <title>Find Campgrounds & RV Parks Across America | RVParkHQ</title>
    <meta name="description" content="Browse {{ number_format($totalParks) }} campgrounds and RV parks across all 50 US states. Find the perfect outdoor stay.">
    <meta property="og:title" content="Find Campgrounds & RV Parks Across America | RVParkHQ">
    <meta property="og:description" content="Browse {{ number_format($totalParks) }} campgrounds and RV parks across all 50 US states.">
    <meta property="og:url" content="{{ url('/campgrounds') }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Find Campgrounds & RV Parks Across America | RVParkHQ">
@endsection

@extends('frontend.pages.layouts.app')

@section('content')
    @php
        use Illuminate\Support\Str;
        $location = request()->query('country') ?? request()->query('state') ?? request()->query('city');
    @endphp
    <style>
        .park-card {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .park-card:hover {
            transform: translateY(-4px);
        }

        .park-image-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .park-image-container img.main {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .winner-badges {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 6px;
            z-index: 2;
        }

        .winner-badges img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
        }

        .park-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.5);
            color: white;
            text-align: center;
            padding: 6px 0;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .park-image-container:hover .park-overlay {
            opacity: 1;
        }
    </style>
    <section id="page-title" class="text-light" data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>Parks</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li>{{ request()->segment(1) }}</li>
                    <li class="active">{{ ucfirst(request()->segment(2)) }}</li>
                    @if ($location)
                        <li class="active">{{ ucwords(str_replace('-', ' ', $location)) }}</li>
                    @endif

                </ul>
            </div>
        </div>
    </section>
    <section id="page-content">
        <div class="container-fluid">
            <div class="row m-b-20 justify-content-center">
                <div class="col-lg-6 p-t-10 m-b-20 text-center">
                    <strong>Discover a variety of parks perfect for your next getaway. Browse locations, explore amenities, and find the ideal spot to relax, camp, or adventure.</strong>
                </div>
            </div>
            <form method="GET" class="mb-4">
                <div class="row g-2 align-items-center justify-content-end">
                    <div class="col-md-6 col-lg-4">
                        <select class="form-select " name="states">
                            <option value="">Select State</option>
                            @foreach($parks['states'] as $park)
                                <option value="{{ $park['state'] }}" {{ request('states') == $park['state'] ? 'selected' : '' }}>
                                    {{ $park['state'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary shadow-sm px-4">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ url()->current() }}" class="btn btn-outline-danger shadow-sm px-4">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                </div>
            </form>

            <div class="shop">
                <div class="grid-layout grid-5-columns" data-item="grid-item">

                    @forelse($parks['parks'] as $park)
                        <div class="grid-item">
                            <div class="park-card">
                                <div class="park-image-container">
                                    {{-- Winner Badges --}}
                                    <div class="winner-badges">
                                        @foreach($park->winnerParks as $winner)
                                            <img src="{{ asset('assets/winner-park.png') }}"
                                                 alt="Winner - {{ \Carbon\Carbon::parse($winner->date)->year }}"
                                                 title="Winner - {{ \Carbon\Carbon::parse($winner->date)->year }}" />
                                        @endforeach
                                    </div>

                                    {{-- Main Park Image --}}
                                    @php
                                        $imagePath = $park->main_image_url;
                                        $imageUrl = !empty($imagePath) ?
                                            (preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath))
                                            : asset('images/placeholder.jpg');
                                    @endphp
                                    
                                    <a href="{{ route('rv-park.park-show', $park->slug_path) }}">
                                        <img class="main" src="{{ $imageUrl }}" onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}';" alt="Park Image">
                                        <div class="park-overlay">View Park</div>
                                    </a>
                                </div>

                                <div class="p-3 text-center">
                                    <h5 class="mb-0">
                                        <a href="{{ route('rv-park.park-show', $park->slug_path) }}" class="text-dark text-decoration-none">
                                            {{ ucfirst($park->name) }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No parks found.</p>
                    @endforelse
                </div>
            </div>

            @if($parks['parks']->total() > 0 || $parks['parks']->total() > 12)
                @include('frontend.pages.layouts.partials.pagination', ['paginator' => $parks['parks']])
            @endif
        </div>
    </section>
@endsection

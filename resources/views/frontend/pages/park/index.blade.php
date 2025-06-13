@extends('frontend.pages.layouts.app')

@section('content')
    @php
        use Illuminate\Support\Str;
        $location = request()->query('country') ?? request()->query('state') ?? request()->query('city');
    @endphp
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
                            <div class="product">
                                <div class="product-image">
                                    @php
                                        $imagePath = $park->main_image_url;
                                        if (!empty($imagePath)) {
                                            if (preg_match('/^https?:\/\//', $imagePath)) {
                                                $imageUrl = $imagePath;
                                            } else {
                                                $imageUrl = asset('storage/' . $imagePath);
                                            }
                                        } else {
                                            $imageUrl = asset('images/login.jpg');
                                        }
                                    @endphp

                                    <a href="{{ route('rv-park.park-show', [
                                        'country'    => Str::slug($park->country),
                                        'state'      => Str::slug($park->state),
                                        'city'       => Str::slug($park->city),
                                        'campground' => 'kayuta-lake-campground',
                                        'id'         => encrypt($park->id)
                                    ]) }}">
                                        <img src="{{ $imageUrl }}" onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';" alt="Park Image" />
                                    </a>
                                    <div class="product-overlay">
                                        <a href="{{ route('rv-park.park-show', [
                                            'country'    => Str::slug($park->country),
                                            'state'      => Str::slug($park->state),
                                            'city'       => Str::slug($park->city),
                                            'campground' => 'kayuta-lake-campground',
                                            'id'         => encrypt($park->id)
                                        ]) }}">
                                        View Park</a>
                                    </div>
                                </div>
                                <div class="text-sm mt-2">
                                    <h5>
                                        <a href="{{ route('rv-park.park-show', [
                                            'country'    => Str::slug($park->country),
                                            'state'      => Str::slug($park->state),
                                            'city'       => Str::slug($park->city),
                                            'campground' => 'kayuta-lake-campground',
                                            'id'         => encrypt($park->id)
                                        ]) }}">
                                            {{ $park->name }}</a>
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

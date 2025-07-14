@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="{{ asset('assets/images/parallax/5.jpg') }}">
        <div class="container">
            <div class="page-title text-white text-center">
                <h1 class="display-4 fw-bold">Favourite Parks</h1>
            </div>
            <div class="breadcrumb text-white-50 text-center mt-2">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('rv-park.home') }}" class="text-white">Home</a></li>
                    <li class="list-inline-item">Favourite Parks</li>
                </ul>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="d-inline-block px-4 py-2 bg-light shadow-sm border rounded-pill fw-semibold">
                <i class="fa fa-heart text-danger me-2"></i> My Favourites
            </h2>
        </div>


        @if($favourites->isEmpty())
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-4 px-3">
                        <div class="card-body">
                            <p class="text-muted mb-0">You have not marked any parks as favourite yet.</p>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="table-responsive rounded-4 shadow-sm border">
                <table class="table table-striped table-hover align-middle mb-0 small">
                    <thead class="table-dark text-center">
                    <tr>
                        <th scope="col" style="width: 90px;">Image</th>
                        <th scope="col">Park Name</th>
                        <th scope="col">Location</th>
                        <th scope="col" style="width: 120px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($favourites as $fav)
                        @php
                            $park = $fav->park;
                            $imagePath = $park->main_image_url;
                            $imageUrl = !empty($imagePath)
                                ? (preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath))
                                : asset('images/placeholder.jpg');
                        @endphp
                        <tr>
                            <td class="text-center">
                                <img src="{{ $imageUrl }}" alt="Park Image"
                                     class="img-thumbnail shadow-sm"
                                     style="height: 50px; width: 80px; object-fit: cover;"
                                     onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';">
                            </td>
                            <td>
                                <a href="{{ route('rv-park.park-show', $park->slug_path) }}"
                                   class="fw-semibold text-dark text-decoration-none">
                                    {{ ucfirst($park->name) }}
                                </a>
                            </td>
                            <td class="text-muted">{{ $park->city ?? '-' }}, {{ $park->state ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('rv-park.park-show', $park->slug_path) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('rv-park.profile.dashboard') }}" class="btn btn-secondary px-4 rounded-pill">
                ← Back to Dashboard
            </a>
        </div>
    </div>
@endsection
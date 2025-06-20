@extends('frontend.pages.layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        justify-content: flex-start;
        gap: 0.3rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 1.75rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }

    .review-helper-text {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 0.4rem;
    }

    .additional-info-table {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .additional-info-table td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    .additional-info-table tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .info-label {
        font-weight: 600;
        color: #333;
        width: 180px;
    }

    .info-value {
        color: #555;
    }

    .info-icon {
        width: 1.2rem;
        margin-right: 8px;
        color: #ffc107;
    }

    .reviews-wrapper {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .review-header {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 25px;
        color: #333;
    }

    .review-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #ffc107;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .review-card .avatar {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .review-meta {
        font-size: 0.875rem;
        color: #777;
    }

    .review-message {
        font-size: 1rem;
        color: #444;
    }

    .star-rating span {
        font-size: 1.2rem;
    }

    .amenity-icon-img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .amenity-icon-img:hover {
        transform: scale(1.05);
    }

</style>
@php
    use Illuminate\Support\Str;
@endphp
@section('content')
    <section id="page-title" class="text-light"
             data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>{{ ucfirst($parks->name) }}</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li>{{ request()->segment(1) }}</li>
                    <li>
                        <a href="{{ route('rv-park.park') }}">
                            {{ ucfirst(request()->segment(2)) }}
                        </a>
                    </li>
                    
                    @if(!empty($parks->country))
                    <li>
                        <a href="{{ route('rv-park.park', ['country' => $parks->country]) }}">
                            {{ Str::slug($parks->country) }}
                        </a>
                    </li>
                    @endif
                    
                    @if(!empty($parks->state))
                    <li>
                        <a href="{{ route('rv-park.park', ['state' => $parks->state]) }}">
                            {{ Str::slug($parks->state) }}
                        </a>
                    </li>
                    @endif
                    
                    @if(!empty($parks->city))
                    <li>
                        <a href="{{ route('rv-park.park', ['city' => $parks->city]) }}">
                            {{ Str::slug($parks->city) }}
                        </a>
                    </li>
                    @endif
                    
                    <li>{{  Str::slug($parks->name) }}</li>
                    
                </ul>
            </div>
        </div>
    </section>
    <section id="product-page" class="product-page p-b-0">
        <div class="container">
            <div class="product">
                <div class="row m-b-40">
                    <div class="col-lg-5">
                        <div class="product-image">
                            @php
                                $imagePath = $parks->main_image_url;
                                if (!empty($imagePath)) {
                                    $imageUrl = preg_match('/^https?:\/\//', $imagePath)
                                        ? $imagePath
                                        : asset('storage/' . $imagePath);
                                } else {
                                    $imageUrl = asset('images/login.jpg');
                                }
                            @endphp
                            <img src="{{ $imageUrl }}"
                                 onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';"
                                 alt="Park Image"/>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-title">
                            <h3>
                                {{ ucfirst($parks->name) }}
                                <small>({!! strip_tags($parks->short_description, '<b><i><u>') !!})</small>
                            </h3>
                        </div>
                        @if($parks->amenities->count() > 0)
                            @foreach($parks->amenities->pluck('blackicon')->toArray() as $blackIconPath)
                                @php
                                    $blackIconImage = preg_match('/^https?:\/\//', $blackIconPath)
                                        ? $blackIconPath
                                        : asset('storage/' . $blackIconPath);
                                @endphp
                                <img src="{{ $blackIconImage }}" class="mt-2 mb-2 ml-1 rounded-circle"
                                     style="width: 35px; height: 35px; object-fit: contain;"
                                     alt="Black Icon">
                            @endforeach
                        @endif
                        <hr>
                        <div class="product-description">
                            <p>{!! $parks->description !!}</p>
                        </div>
                        @if($parks->winnerParks->count() > 0)
                            <div class="mt-4">
                                <h3 class="text-center mb-3" style="font-weight: 600; color: #d4af37;">🏆 Park of the
                                    Year</h3>
                                <div class="d-flex flex-wrap justify-content-center gap-4">
                                    @foreach($parks->winnerParks as $winner)
                                        <div class="text-center position-relative winner-badge">
                                            <img src="{{ asset('assets/winner-park.png') }}"
                                                 alt="Winner {{ \Carbon\Carbon::parse($winner->date)->year }}"
                                                 title="Winner - {{ \Carbon\Carbon::parse($winner->date)->year }}"
                                                 class="rounded-circle shadow"
                                                 style="width: 120px; height: 120px; border: 4px solid #d4af37;"/>
                                            <div class="badge-year mt-2" style="font-weight: bold; color: #333;">
                                                {{ \Carbon\Carbon::parse($winner->date)->year }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Product additional tabs -->
            <div class="tabs tabs-folder">
                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="additional-tab" data-bs-toggle="tab" href="#additional"
                           role="tab"
                           aria-controls="additional" aria-selected="true">
                            <i class="fa fa-info"></i>Additional Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab"
                           aria-controls="reviews" aria-selected="false">
                            <i class="fa fa-star"></i>Reviews ({{ $reviews->count() }})
                        </a>
                    </li>

                    @if($parks->amenities->count() > 0)
                        <li class="nav-item">
                            <a class="nav-link" id="amenities-tab" data-bs-toggle="tab" href="#amenities" role="tab"
                               aria-controls="amenities" aria-selected="true">
                                Amenities
                            </a>
                        </li>
                    @endif

                    @if(!empty($parks->latitude) && !empty($parks->longitude))
                        <li class="nav-item">
                            <a class="nav-link" id="map-tab" data-bs-toggle="tab" href="#map-tab-pane" role="tab"
                               aria-controls="map-tab-pane" aria-selected="true">
                                Map
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent3">
                    <div class="tab-pane fade active show" id="additional" role="tabpanel"
                         aria-labelledby="additional-tab">
                        <div class="table-responsive">
                            <table class="table additional-info-table">
                                <tbody>
                                <tr>
                                    <td class="info-label"><i class="fas fa-flag info-icon"></i>Country</td>
                                    <td class="info-value">{{ $parks->country }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-city info-icon"></i>City</td>
                                    <td class="info-value">{{ $parks->city }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-map-marker-alt info-icon"></i>State</td>
                                    <td class="info-value">{{ $parks->state }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-map info-icon"></i>Address</td>
                                    <td class="info-value">{{ $parks->address }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-mail-bulk info-icon"></i>Postal Code</td>
                                    <td class="info-value">{{ $parks->postal_code }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-globe info-icon"></i>Latitude</td>
                                    <td class="info-value">{{ $parks->latitude }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-globe info-icon"></i>Longitude</td>
                                    <td class="info-value">{{ $parks->longitude }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-phone info-icon"></i>Phone</td>
                                    <td class="info-value">{{ $parks->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-envelope info-icon"></i>Email</td>
                                    <td class="info-value">{{ $parks->email }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="comments reviews-wrapper" id="comments">
                            <div class="review-header">
                                {{ $reviews->count() ? 'What Campers Are Saying' : 'No Reviews Yet' }}
                            </div>

                            @if ($reviews && $reviews->count())
                                <div class="comment-list">
                                    @foreach ($reviews as $review)
                                        <div class="review-card d-flex align-items-start">
                                            <div class="me-3">
                                                <img alt="Avatar"
                                                     src="{{ asset('assets/images/clients/' . rand(1, 10) . '.png') }}"
                                                     class="avatar">
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $review->name }}</h6>
                                                <div class="review-meta mb-1">Posted on {{ $review->created_at->format('F j, Y \\a\\t g:i A') }}</div>
                                                <div class="star-rating mb-2 d-inline-block" style="direction: ltr;">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <span style="color: #ffc107">&#9733;</span>
                                                        @else
                                                            <span style="color: #e0e0e0">&#9733;</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="review-message mb-0">{{ $review->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No reviews yet. Be the first to support this park with a review
                                    and help it shine in the RVParkHQ Excellence Awards!</p>
                            @endif
                        </div>

                    </div>
                    @if($parks->amenities->count() > 0)
                        <div class="tab-pane fade" id="amenities" role="tabpanel" aria-labelledby="amenities-tab">
                            @if ($parks->amenities)
                                @foreach($parks->amenities->groupBy('category') as $category => $items)
                                    <div class="mb-4 shadow p-3 rounded reviews-wrapper">
                                        <h4 class="h6 font-weight-bold text-dark mb-3">{{ $category }}</h4>

                                        <div class="row">
                                            @foreach($items as $amenity)
                                                <div class="col-12 col-md-12 mb-2 d-flex align-items-center">
                                                    @if ($amenity->blackicon)
                                                        @php
                                                            $blackIconPath = $amenity->blackicon;
                                                            $blackIconImage = preg_match('/^https?:\/\//', $blackIconPath)
                                                                ? $blackIconPath
                                                                : asset('storage/' . $blackIconPath);
                                                        @endphp
                                                        <img src="{{ $blackIconImage }}" class="ml-1 rounded-circle"
                                                             style="width: 20px; height: 20px; object-fit: contain;"
                                                             alt="Black Icon">
                                                    @endif

                                                    @if ($amenity->whiteicon)
                                                        @php
                                                            $whiteIconPath = $amenity->whiteicon;
                                                            $whiteIconImage = preg_match('/^https?:\/\//', $whiteIconPath)
                                                                ? $whiteIconPath
                                                                : asset('storage/' . $whiteIconPath);
                                                        @endphp
                                                        <img src="{{ $whiteIconImage }}" class="ml-1 rounded-circle"
                                                             style="width: 20px; height: 20px; object-fit: contain;"
                                                             alt="White Icon">
                                                    @endif

                                                    <label for="amenity_{{ $amenity->id }}"
                                                           class="ml-3 mb-0 small text-muted">
                                                        {{ $amenity->amenity }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                    <div class="tab-pane fade" id="map-tab-pane" role="tabpanel" aria-labelledby="map-tab">
                        <div id="map" style="height: 300px; width: 100%; border: 1px solid #ccc;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row card p-4 shadow-md rounded-lg border border-light">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3 class="text-uppercase">Support This Park with a Review</h3>
                        <p>Support your favorite parks with your review — and help them earn a place among the best in
                            the RVParkHQ community.</p>
                    </div>

                    <div class="m-t-30">
                        <form id="review-form" method="POST" action="{{ route('rv-park.pending-review') }}">
                            @csrf
                            <input type="hidden" name="park_id" value="{{ $parks->id }}">

                            <div class="form-group mt-4">
                                <label for="rating" class="form-label fw-bold">Rate This Park <span class="text-danger">*</span></label>
                                <div class="star-rating mb-2">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required/>
                                        <label for="star{{ $i }}"
                                               title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">&#9733;</label>
                                    @endfor
                                </div>
                                <div class="review-helper-text">
                                    🌟 Your review helps this park earn a spot in the annual <strong>RVParkHQ Excellence
                                        Awards</strong>.
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required class="form-control"
                                           placeholder="Enter your Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" required class="form-control"
                                           placeholder="Enter your Email">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="message">Describe Your Feedback <span class="text-danger">*</span></label>
                                <textarea name="message" rows="5" class="form-control" required
                                          placeholder="Enter your Message"></textarea>
                            </div>

                            <div class="form-group mt-3 text-start">
                                <small class="text-dark">
                                    By submitting your vote, you agree to receive occasional emails from RVParkHQ with
                                    camping tips, special offers, and nearby park promotions. Unsubscribe anytime.
                                </small>
                            </div>
                            <button class="btn btn-dark mt-1" type="submit" id="form-submit">
                                <i class="fa fa-paper-plane"></i>&nbsp;Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        $('#review-form').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let actionUrl = form.attr('action');
            let submitBtn = $('#form-submit');

            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    form[0].reset();
                    return Swal.fire({
                        title: '🎊 Hurrah!',
                        text: response.message,
                        icon: 'success',
                        position: 'top-end',
                        timerProgressBar: true,
                        timer: 4000,
                        showConfirmButton: false,
                        showClass: {
                            popup: 'animate__animated animate__bounceIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors) {
                        let errorList = Object.values(errors).flat().join("\n");
                        alert("Please fix the following errors:\n" + errorList);
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },
                complete: function () {
                    submitBtn.html('<i class="fa fa-paper-plane"></i> Submit').prop('disabled', false);
                }
            });
        });
    </script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let mapInstance;
            let mapInitialized = false;

            const lat = {{ $parks->latitude ?? 0 }};
            const lng = {{ $parks->longitude ?? 0 }};

            const mapTabEl = document.querySelector('#map-tab');
            mapTabEl.addEventListener('shown.bs.tab', function (event) {
                if (!mapInitialized) {
                    mapInstance = L.map('map').setView([lat, lng], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(mapInstance);

                    L.marker([lat, lng]).addTo(mapInstance);

                    mapInitialized = true;
                } else {
                    setTimeout(() => {
                        mapInstance.invalidateSize();
                    }, 300); // ensure resizing is triggered after tab animation
                }
            });
        });
    </script>
@endsection

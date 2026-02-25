@extends('frontend.pages.layouts.app')

@section('title', ucfirst($parks->name) . ' - RVParkHQ')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $imagePath = $parks->main_image_url;
    if (!empty($imagePath)) {
        $mainImageUrl = preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath);
    } else {
        $mainImageUrl = asset('images/login.jpg');
    }

    $ogDescription = !empty($parks->short_description)
        ? Str::limit(strip_tags($parks->short_description), 160)
        : Str::limit(strip_tags($parks->description), 160);

    $parkPhotos = $parks->park_photos ?? collect();
    $hasGallery = $parkPhotos->count() > 0;

    // Park type badge config
    $typeBadges = [
        'private'        => ['label' => 'Private Park', 'color' => '#28a745', 'icon' => ''],
        'federal_nps'    => ['label' => 'National Park Service', 'color' => '#6B4226', 'icon' => '🏛️'],
        'federal_forest' => ['label' => 'National Forest', 'color' => '#2d6a4f', 'icon' => '🌲'],
        'federal_blm'    => ['label' => 'BLM Land', 'color' => '#e67e22', 'icon' => ''],
        'federal_corps'  => ['label' => 'Army Corps', 'color' => '#2980b9', 'icon' => ''],
        'state_park'     => ['label' => 'State Park', 'color' => '#20c997', 'icon' => '🏕️'],
        'county'         => ['label' => 'County Park', 'color' => '#6c757d', 'icon' => ''],
        'harvest_host'   => ['label' => 'Harvest Host', 'color' => '#7b2d8e', 'icon' => '🍇'],
        'other'          => ['label' => 'Other', 'color' => '#adb5bd', 'icon' => ''],
    ];
    $badge = $typeBadges[$parks->park_type] ?? $typeBadges['other'];

    // Last verified logic
    $lastVerified = $parks->last_verified_at;
    if ($lastVerified) {
        $daysSince = $lastVerified->diffInDays(now());
        if ($daysSince <= 30) {
            $verifiedText = "Verified {$daysSince} days ago";
            $verifiedColor = '#28a745';
        } elseif ($daysSince <= 90) {
            $verifiedText = "Verified {$daysSince} days ago";
            $verifiedColor = '#e67e22';
        } else {
            $verifiedText = "Needs verification";
            $verifiedColor = '#dc3545';
        }
    } else {
        $verifiedText = "Not yet verified";
        $verifiedColor = '#dc3545';
    }

    // Data source label
    $dataSourceLabels = [
        'osm'    => 'Data from OpenStreetMap',
        'google' => 'Data from Google',
        'owner'  => 'Owner submitted',
        'manual' => 'Manually entered',
    ];
    $dataSourceText = $dataSourceLabels[$parks->data_source] ?? ($parks->data_source ? "Data from " . ucfirst($parks->data_source) : 'Unknown source');
@endphp

@section('meta')
    <meta property="og:title" content="{{ ucfirst($parks->name) }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $mainImageUrl }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="place">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ ucfirst($parks->name) }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $mainImageUrl }}">
@endsection

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

    .claim-section-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1d3557;
        border-left: 5px solid #28a745;
        padding-left: 15px;
        margin-bottom: 1.8rem;
    }

    .custom-card {
        background-color: #f9fdf9;
        border: 1px solid #d4edda;
        border-left: 6px solid #28a745;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .custom-card:hover {
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
        transform: scale(1.01);
    }

    .custom-card .card-body {
        padding: 1.4rem 1.2rem;
    }

    .custom-value {
        font-size: 1.3rem;
        font-weight: bold;
        color: #2d6a4f;
    }

    .text-muted {
        font-size: 0.92rem;
    }

    .yes-badge {
        background-color: #28a745;
        color: white;
        font-size: 0.85rem;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .no-badge {
        background-color: #dc3545;
        color: white;
        font-size: 0.85rem;
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Park type badge */
    .park-type-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        vertical-align: middle;
        margin-left: 8px;
    }

    .verified-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        background-color: #28a745;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        vertical-align: middle;
        margin-left: 6px;
    }

    /* Google rating */
    .google-rating-display {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        font-size: 0.95rem;
    }

    .google-rating-display .stars {
        color: #ffc107;
        font-size: 1.1rem;
    }

    .google-rating-display .rating-text {
        color: #555;
        font-size: 0.9rem;
    }

    /* Photo gallery slideshow */
    .park-gallery-wrapper {
        position: relative;
    }
    .park-gallery-main {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 8px;
        transition: opacity 0.4s ease;
    }
    .park-gallery-main.fade-out {
        opacity: 0;
    }
    .gallery-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: background 0.2s;
    }
    .gallery-nav:hover { background: rgba(0,0,0,0.75); }
    .gallery-nav.prev { left: 8px; }
    .gallery-nav.next { right: 8px; }
    .gallery-counter {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.8rem;
        z-index: 2;
    }
    .park-gallery-thumbs {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .park-gallery-thumbs img {
        width: 70px;
        height: 55px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        opacity: 0.7;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .park-gallery-thumbs img:hover,
    .park-gallery-thumbs img.active {
        border-color: #ffc107;
        opacity: 1;
    }

    /* For sale banner */
    .for-sale-banner {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 12px 16px;
        margin-top: 15px;
        font-size: 0.95rem;
    }

    .for-sale-banner a {
        color: #856404;
        font-weight: 600;
        text-decoration: underline;
    }

    /* Action buttons */
    .park-action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 12px;
        margin-bottom: 10px;
    }
</style>

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
                        {{request()->segment(2) }}
                    </li>
                    <li>{{ request()->segment(3) }}</li>
                    <li class="active">{{  Str::slug($parks->name) }}</li>
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
                            @if($hasGallery)
                                @php
                                    $firstPhoto = $parkPhotos->first();
                                    $firstUrl = preg_match('/^https?:\/\//', $firstPhoto->url) ? $firstPhoto->url : asset('storage/' . $firstPhoto->url);
                                    $photoCount = $parkPhotos->count();
                                @endphp
                                <div class="park-gallery-wrapper">
                                    @if($photoCount > 1)
                                        <button class="gallery-nav prev" onclick="galleryNav(-1)" aria-label="Previous">&#10094;</button>
                                        <button class="gallery-nav next" onclick="galleryNav(1)" aria-label="Next">&#10095;</button>
                                        <span class="gallery-counter"><span id="gallery-index">1</span> / {{ $photoCount }}</span>
                                    @endif
                                    <img id="gallery-main-img"
                                         src="{{ $firstUrl }}"
                                         onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';"
                                         alt="Park Image"
                                         class="park-gallery-main"/>
                                </div>
                                <div class="park-gallery-thumbs">
                                    @foreach($parkPhotos as $i => $photo)
                                        @php
                                            $photoUrl = preg_match('/^https?:\/\//', $photo->url) ? $photo->url : asset('storage/' . $photo->url);
                                        @endphp
                                        <img src="{{ $photoUrl }}"
                                             alt="Photo {{ $i + 1 }}"
                                             class="gallery-thumb {{ $i === 0 ? 'active' : '' }}"
                                             data-full="{{ $photoUrl }}"
                                             data-index="{{ $i }}"
                                             onerror="this.style.display='none';">
                                    @endforeach
                                </div>
                            @else
                                <img src="{{ $mainImageUrl }}"
                                     onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';"
                                     alt="Park Image"/>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-title">
                            <h3>
                                {{ ucfirst($parks->name) }}
                                <span class="park-type-badge" style="background-color: {{ $badge['color'] }};">
                                    @if($badge['icon']) {{ $badge['icon'] }} @endif {{ $badge['label'] }}
                                </span>
                                @if($parks->is_claimed)
                                    <span class="verified-badge">✓ Verified</span>
                                @endif
                                @if (!empty($parks->short_description))
                                    <br><small>({!! strip_tags($parks->short_description, '<b><i><u>') !!})</small>
                                @endif
                            </h3>
                        </div>

                        {{-- Google Rating --}}
                        @if(!empty($parks->google_rating))
                            <div class="google-rating-display mb-2">
                                <span class="stars" style="direction: ltr;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($parks->google_rating))
                                            <span>&#9733;</span>
                                        @else
                                            <span style="color: #e0e0e0;">&#9733;</span>
                                        @endif
                                    @endfor
                                </span>
                                <span class="rating-text">
                                    {{ number_format($parks->google_rating, 1) }}
                                    @if(!empty($parks->google_review_count))
                                        ({{ number_format($parks->google_review_count) }} reviews on Google)
                                    @endif
                                </span>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="park-action-buttons">
                            @if(!empty($parks->website_url))
                                <a href="{{ $parks->website_url }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                                    <i class="fas fa-external-link-alt"></i> Visit Website
                                </a>
                            @endif
                            @if(!empty($parks->phone))
                                <a href="tel:{{ $parks->phone }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-phone"></i> {{ $parks->phone }}
                                </a>
                            @endif
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

                        {{-- For Sale Cross-link --}}
                        @if(!empty($forSaleUrl))
                            <div class="for-sale-banner">
                                🏷️ This park may be for sale — <a href="{{ $forSaleUrl }}" target="_blank" rel="noopener">View on RVParkShop</a>
                            </div>
                        @endif

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

                    @if($parks->amenities->count() > 0 || !empty($approvedClaim))
                        <li class="nav-item">
                            <a class="nav-link" id="amenities-tab" data-bs-toggle="tab" href="#amenities" role="tab"
                               aria-controls="amenities" aria-selected="true">
                                Amenities
                            </a>
                        </li>
                    @endif

                    @if(!empty($parks->rates))
                        <li class="nav-item">
                            <a class="nav-link" id="rates-tab" data-bs-toggle="tab" href="#rates" role="tab"
                               aria-controls="rates" aria-selected="false">
                                <i class="fa fa-dollar-sign"></i>Rates
                            </a>
                        </li>
                    @endif

                    @if(!empty($parks->facilities))
                        <li class="nav-item">
                            <a class="nav-link" id="facilities-tab" data-bs-toggle="tab" href="#facilities" role="tab"
                               aria-controls="facilities" aria-selected="false">
                                <i class="fa fa-campground"></i>Facilities
                            </a>
                        </li>
                    @endif

                    @if(!empty($parks->policies))
                        <li class="nav-item">
                            <a class="nav-link" id="policies-tab" data-bs-toggle="tab" href="#policies" role="tab"
                               aria-controls="policies" aria-selected="false">
                                <i class="fa fa-clipboard-list"></i>Policies
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
                                    <td class="info-value">
                                        @if(!empty($parks->phone))
                                            <a href="tel:{{ $parks->phone }}">{{ $parks->phone }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($parks->email))
                                    <tr>
                                        <td class="info-label"><i class="fas fa-envelope info-icon"></i>Email</td>
                                        <td class="info-value">{{ $parks->email }}</td>
                                    </tr>
                                @endif
                                @if(!empty($parks->website_url))
                                    <tr>
                                        <td class="info-label"><i class="fas fa-globe info-icon"></i>Website</td>
                                        <td class="info-value"><a href="{{ $parks->website_url }}" target="_blank" rel="noopener">{{ $parks->website_url }}</a></td>
                                    </tr>
                                @endif
                                @if(!empty($parks->manager_name))
                                <tr>
                                    <td class="info-label"><i class="fas fa-user-tie info-icon"></i>Manager</td>
                                    <td class="info-value">{{ $parks->manager_name }}</td>
                                </tr>
                                @endif
                                @if(!empty($parks->total_sites))
                                <tr>
                                    <td class="info-label"><i class="fas fa-campground info-icon"></i>Total Sites</td>
                                    <td class="info-value">{{ $parks->total_sites }}</td>
                                </tr>
                                @endif
                                @if(!empty($parks->acreage))
                                <tr>
                                    <td class="info-label"><i class="fas fa-ruler-combined info-icon"></i>Acreage</td>
                                    <td class="info-value">{{ $parks->acreage }} acres</td>
                                </tr>
                                @endif
                                @if(!empty($parks->reservation_url))
                                <tr>
                                    <td class="info-label"><i class="fas fa-calendar-check info-icon"></i>Reservations</td>
                                    <td class="info-value"><a href="{{ $parks->reservation_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-success">Book Now</a></td>
                                </tr>
                                @endif
                                @if(!empty($parks->facebook_url))
                                <tr>
                                    <td class="info-label"><i class="fab fa-facebook info-icon"></i>Facebook</td>
                                    <td class="info-value"><a href="{{ $parks->facebook_url }}" target="_blank" rel="noopener">{{ $parks->facebook_url }}</a></td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="info-label"><i class="fas fa-clock info-icon"></i>Last Verified</td>
                                    <td class="info-value" style="color: {{ $verifiedColor }}; font-weight: 600;">
                                        {{ $verifiedText }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info-label"><i class="fas fa-database info-icon"></i>Data Source</td>
                                    <td class="info-value">{{ $dataSourceText }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        @if($parks->request_park == 1)
                            <div class="claim-park-cta card shadow-sm border-0 p-3 mb-2" style="background: #f9fafb; border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold mb-1" style="font-size: 1.1em;">Own this Park?</div>
                                        <div style="font-size: 0.98em; color: #555;">
                                            Claim your listing to add photos, update contact info, and showcase your park.
                                        </div>
                                        <a href="#modalClaimPark"
                                           data-lightbox="inline"
                                           class="btn btn-primary btn-sm mt-2"
                                           style="font-weight: 600; border-radius: 8px; box-shadow: 0 2px 6px rgba(60,132,206,0.08); transition: background 0.2s;"
                                           onmouseover="this.style.background='#2563eb';"
                                           onmouseout="this.style.background='';">
                                            <i class="fas fa-lock"></i> Claim This Park
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                                <div class="review-meta mb-1">Posted
                                                    on {{ $review->created_at->format('F j, Y \\a\\t g:i A') }}</div>
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

                    <div class="tab-pane fade" id="amenities" role="tabpanel" aria-labelledby="amenities-tab">
                        @if($parks->amenities->count() > 0)
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
                        @endif
                        @if(!empty($approvedClaim))


                                <div class="tab-pane fade show active" id="claim-park-info" role="tabpanel" aria-labelledby="claim-park-info-tab">

                                    {{-- RV & Tent Site Inventory --}}
                                    <h3 class="claim-section-title">RV & Tent Site Inventory</h3>
                                    <div class="row">
                                        @php
                                            $rvTentItems = [
                                                '50 Amp Full Hookup Sites' => $approvedClaim->sites_50amp_full ?? '-',
                                                '30 Amp Full Hookup Sites' => $approvedClaim->sites_30amp_full ?? '-',
                                                '30 Amp Water & Electric Sites' => $approvedClaim->sites_30amp_water_electric ?? '-',
                                                '50 Amp Water & Electric Sites' => $approvedClaim->sites_50amp_water_electric ?? '-',
                                                '30 Amp Electric Only Sites' => $approvedClaim->sites_30amp_electric ?? '-',
                                                '50 Amp Electric Only Sites' => $approvedClaim->sites_50amp_electric ?? '-',
                                                'No Hookup RV Sites (Dry Camping)' => $approvedClaim->sites_dry_camping ?? '-',
                                                'Tent Sites (with utilities)' => $approvedClaim->tent_sites_utilities ?? '-',
                                                'Tent Sites (primitive)' => $approvedClaim->tent_sites_primitive ?? '-',
                                                'Seasonal RV Sites' => $approvedClaim->seasonal_sites ?? '-',
                                                'Group Campsites' => $approvedClaim->group_campsites ?? '-',
                                            ];
                                        @endphp

                                        @foreach($rvTentItems as $label => $value)
                                            <div class="col-md-4 mb-4">
                                                <div class="card custom-card h-100">
                                                    <div class="card-body">
                                                        <h6 class="text-muted">{{ $label }}</h6>
                                                        <p class="custom-value mb-0">{{ $value }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Cabins & Rentals --}}
                                    <h3 class="claim-section-title mt-5">Cabins & Rentals</h3>
                                    <div class="row">
                                        @php
                                            $cabinItems = [
                                                'Deluxe Cabins (AC & Bath)' => $approvedClaim->deluxe_cabins ?? '-',
                                                'Primitive Cabins' => $approvedClaim->primitive_cabins ?? '-',
                                                'Yurts / Glamping Tents' => $approvedClaim->yurts_glamping ?? '-',
                                                'Other Rentals (describe)' => $approvedClaim->other_rentals ?? '-',
                                            ];
                                        @endphp

                                        @foreach($cabinItems as $label => $value)
                                            <div class="col-md-4 mb-4">
                                                <div class="card custom-card h-100">
                                                    <div class="card-body">
                                                        <h6 class="text-muted">{{ $label }}</h6>
                                                        <p class="custom-value mb-0">{{ $value }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Waterfront & Marina --}}
                                    <h3 class="claim-section-title mt-5">Waterfront & Marina</h3>
                                    <div class="row">
                                        @php
                                            $marinaItems = [
                                                'Boat Slips' => $approvedClaim->boat_slips ?? '-',
                                                'Canoes / Kayaks for Rent' => $approvedClaim->canoe_kayak_rental ? 'Yes' : 'No',
                                                'Paddle Boats' => $approvedClaim->paddle_boats ? 'Yes' : 'No',
                                                'Boat Ramp / Launch' => $approvedClaim->boat_ramp ? 'Yes' : 'No',
                                                'Fishing Available' => $approvedClaim->fishing_available ? 'Yes' : 'No',
                                            ];
                                        @endphp

                                        @foreach($marinaItems as $label => $value)
                                            <div class="col-md-4 mb-4">
                                                <div class="card custom-card h-100">
                                                    <div class="card-body">
                                                        <h6 class="text-muted">{{ $label }}</h6>
                                                        @if($value === 'Yes' || $value === 'No')
                                                            <span class="{{ $value == 'Yes' ? 'yes-badge' : 'no-badge' }}">{{ $value }}</span>
                                                        @else
                                                            <p class="custom-value mb-0">{{ $value }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @endif
                    </div>
                                        {{-- Rates Tab --}}
                    @if(!empty($parks->rates))
                    <div class="tab-pane fade" id="rates" role="tabpanel" aria-labelledby="rates-tab">
                        <div class="p-3">
                            @if(!empty($parks->rates['nightly']))
                            <h5 class="mb-3"><i class="fa fa-moon text-primary"></i> Nightly Rates</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-striped">
                                    <thead><tr><th>Site Type</th><th>Rate</th><th>Season</th></tr></thead>
                                    <tbody>
                                    @foreach((array) $parks->rates['nightly'] as $rate)
                                        <tr>
                                            <td>{{ $rate['type'] ?? 'Standard' }}</td>
                                            <td><strong>{{ $rate['price'] ?? 'Call' }}</strong></td>
                                            <td>{{ $rate['season'] ?? 'Year-round' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if(!empty($parks->rates['weekly']))
                            <h5 class="mb-3"><i class="fa fa-calendar-week text-primary"></i> Weekly Rates</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-striped">
                                    <thead><tr><th>Site Type</th><th>Rate</th><th>Notes</th></tr></thead>
                                    <tbody>
                                    @foreach((array) $parks->rates['weekly'] as $rate)
                                        <tr>
                                            <td>{{ $rate['type'] ?? 'Standard' }}</td>
                                            <td><strong>{{ $rate['price'] ?? 'Call' }}</strong></td>
                                            <td>{{ $rate['notes'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if(!empty($parks->rates['monthly']))
                            <h5 class="mb-3"><i class="fa fa-calendar text-primary"></i> Monthly Rates</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-striped">
                                    <thead><tr><th>Type</th><th>Rate</th><th>Notes</th></tr></thead>
                                    <tbody>
                                    @foreach((array) $parks->rates['monthly'] as $rate)
                                        <tr>
                                            <td>{{ $rate['type'] ?? 'Standard' }}</td>
                                            <td><strong>{{ $rate['price'] ?? 'Call' }}</strong></td>
                                            <td>{{ $rate['notes'] ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if(!empty($parks->rates['seasonal']))
                            <h5 class="mb-3"><i class="fa fa-sun text-warning"></i> Seasonal Rates</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-striped">
                                    <thead><tr><th>Season</th><th>Dates</th><th>Rate</th></tr></thead>
                                    <tbody>
                                    @foreach((array) $parks->rates['seasonal'] as $rate)
                                        <tr>
                                            <td>{{ $rate['name'] ?? '' }}</td>
                                            <td>{{ $rate['dates'] ?? '' }}</td>
                                            <td><strong>{{ $rate['price'] ?? 'Call' }}</strong></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if(!empty($parks->rates['additional']))
                            <h5 class="mb-3"><i class="fa fa-plus-circle text-info"></i> Additional Fees</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead><tr><th>Fee</th><th>Amount</th></tr></thead>
                                    <tbody>
                                    @foreach((array) $parks->rates['additional'] as $fee)
                                        <tr>
                                            <td>{{ $fee['name'] ?? '' }}</td>
                                            <td><strong>{{ $fee['price'] ?? '' }}</strong></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            @if(!empty($parks->rates['notes']))
                            <div class="alert alert-info mt-3">
                                <i class="fa fa-info-circle"></i> {{ $parks->rates['notes'] }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Facilities Tab --}}
                    @if(!empty($parks->facilities))
                    <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
                        <div class="p-3">
                            @php
                                $facilityCategories = [];
                                foreach ((array) $parks->facilities as $item) {
                                    $cat = $item['category'] ?? 'General';
                                    $facilityCategories[$cat][] = $item;
                                }
                            @endphp
                            <div class="row">
                                @foreach($facilityCategories as $category => $items)
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-primary mb-3">{{ $category }}</h5>
                                    <ul class="list-unstyled">
                                        @foreach($items as $item)
                                        <li class="mb-2">
                                            <i class="fa fa-check-circle text-success"></i>
                                            {{ $item['name'] ?? $item }}
                                            @if(!empty($item['details']))
                                                <small class="text-muted d-block ms-4">{{ $item['details'] }}</small>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                            </div>

                            @if(!empty($parks->total_sites) || !empty($parks->acreage))
                            <div class="row mt-3 border-top pt-3">
                                @if(!empty($parks->total_sites))
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h3 class="text-primary mb-0">{{ $parks->total_sites }}</h3>
                                        <small class="text-muted">Total Sites</small>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($parks->acreage))
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h3 class="text-primary mb-0">{{ $parks->acreage }}</h3>
                                        <small class="text-muted">Acres</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Policies Tab --}}
                    @if(!empty($parks->policies))
                    <div class="tab-pane fade" id="policies" role="tabpanel" aria-labelledby="policies-tab">
                        <div class="p-3">
                            <div class="row">
                                @if(!empty($parks->policies['pets']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-paw text-primary"></i> Pet Policy</h5>
                                    <p>{{ $parks->policies['pets'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['cancellation']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-ban text-danger"></i> Cancellation Policy</h5>
                                    <p>{{ $parks->policies['cancellation'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['check_in']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-clock text-info"></i> Check-In / Check-Out</h5>
                                    <p>{{ $parks->policies['check_in'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['quiet_hours']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-volume-mute text-secondary"></i> Quiet Hours</h5>
                                    <p>{{ $parks->policies['quiet_hours'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['max_guests']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-users text-primary"></i> Max Guests</h5>
                                    <p>{{ $parks->policies['max_guests'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['age_restrictions']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-id-card text-warning"></i> Age Restrictions</h5>
                                    <p>{{ $parks->policies['age_restrictions'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['fires']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-fire text-danger"></i> Fire Policy</h5>
                                    <p>{{ $parks->policies['fires'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['deposit']))
                                <div class="col-md-6 mb-4">
                                    <h5><i class="fa fa-credit-card text-success"></i> Deposit</h5>
                                    <p>{{ $parks->policies['deposit'] }}</p>
                                </div>
                                @endif

                                @if(!empty($parks->policies['other']))
                                <div class="col-12 mb-4">
                                    <h5><i class="fa fa-info-circle text-primary"></i> Other Policies</h5>
                                    @if(is_array($parks->policies['other']))
                                        <ul>
                                        @foreach($parks->policies['other'] as $policy)
                                            <li>{{ $policy }}</li>
                                        @endforeach
                                        </ul>
                                    @else
                                        <p>{{ $parks->policies['other'] }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="tab-pane fade" id="map-tab-pane" role="tabpanel" aria-labelledby="map-tab">
                        <div id="map" style="height: 300px; width: 100%; border: 1px solid #ccc;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="write-review">
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
    
    @include('frontend.pages.park.partials.claim-park-modal')
    
    <script>
        @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && $.magnificPopup) {
                $.magnificPopup.open({ items: { src: '#modalClaimPark' }, type: 'inline' });
            } else if (window.lightbox) {
                lightbox.open('#modalClaimPark');
            } else {
                document.getElementById('modalClaimPark').style.display = 'block';
            }
        });
        @endif
    </script>
    
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
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
                    }, 300);
                }
            });
        });
    </script>

    {{-- Photo Gallery Slideshow JS --}}
    @if($hasGallery)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var thumbs = document.querySelectorAll('.gallery-thumb');
            var mainImg = document.getElementById('gallery-main-img');
            var counterEl = document.getElementById('gallery-index');
            var currentIndex = 0;
            var totalPhotos = thumbs.length;
            var autoplayInterval = null;

            function showPhoto(index, animate) {
                if (totalPhotos === 0) return;
                currentIndex = ((index % totalPhotos) + totalPhotos) % totalPhotos;
                var thumb = thumbs[currentIndex];
                if (!thumb) return;

                if (animate) {
                    mainImg.classList.add('fade-out');
                    setTimeout(function() {
                        mainImg.src = thumb.dataset.full;
                        mainImg.classList.remove('fade-out');
                    }, 200);
                } else {
                    mainImg.src = thumb.dataset.full;
                }

                thumbs.forEach(function(t) { t.classList.remove('active'); });
                thumb.classList.add('active');
                if (counterEl) counterEl.textContent = currentIndex + 1;

                // Scroll thumb into view
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            // Click handlers for thumbs
            thumbs.forEach(function(thumb) {
                thumb.addEventListener('click', function() {
                    showPhoto(parseInt(this.dataset.index), true);
                    resetAutoplay();
                });
            });

            // Navigation function (called from buttons)
            window.galleryNav = function(dir) {
                showPhoto(currentIndex + dir, true);
                resetAutoplay();
            };

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') { window.galleryNav(-1); }
                else if (e.key === 'ArrowRight') { window.galleryNav(1); }
            });

            // Auto-advance every 5 seconds
            function startAutoplay() {
                if (totalPhotos <= 1) return;
                autoplayInterval = setInterval(function() {
                    showPhoto(currentIndex + 1, true);
                }, 5000);
            }

            function resetAutoplay() {
                clearInterval(autoplayInterval);
                startAutoplay();
            }

            // Pause on hover
            var wrapper = document.querySelector('.park-gallery-wrapper');
            if (wrapper) {
                wrapper.addEventListener('mouseenter', function() { clearInterval(autoplayInterval); });
                wrapper.addEventListener('mouseleave', function() { startAutoplay(); });
            }

            startAutoplay();
        });
    </script>
    @endif
@endsection

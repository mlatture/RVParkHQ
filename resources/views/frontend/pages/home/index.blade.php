@extends('frontend.pages.layouts.app')

@section('content')
    <div id="slider" class="inspiro-slider slider-fullscreen dots-creative" data-fade="true">
        
        <!-- SLIDE 1 -->
        <div class="slide kenburns" data-bg-video="assets/video/explore.mp4">
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="slide-captions text-center text-light">
                    <h2 data-caption-animate="zoom-out">Find the Perfect Campground for Your Next Adventure.</h2>
                    <p class="text-small">From rustic sites to resort-style RV parks -  we’ve got you covered.</p>
                    <div>
                        <a href="{{ route('rv-park.home') }}" class="btn btn-primary scroll-to">Start Your Search</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="slide" data-bg-video="assets/video/pexels-waves.mp4"></div>

        <!-- SLIDE 3 -->
        <div class="slide kenburns" data-bg-video="assets/video/explore.mp4">
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="slide-captions text-center text-light">
                    <h1>Explore 10+ Campgrounds Across the USA</h1>
                    <p class="text-small">Pet-friendly, big-rig ready, tent-only, and everything in between</p>
                    <div>
                        <a href="{{ route('rv-park.park-country') }}" class="btn btn-primary scroll-to">Browse by State</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SLIDE 4 -->
        <div class="slide kenburns" data-bg-video="assets/video/explore.mp4">
            <div class="bg-overlay"></div>
            <div class="container">
                <div class="slide-captions text-center text-light">
                    <h2 class="text-small">For Campground Owners</h2>
                    <p>Claim your listing, get more bookings, and grow with smart tools</p>
                    <div>
                        <a href="{{ route('rv-park.suggest.park') }}" class="btn btn-primary scroll-to">Suggest a Park</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Slide 2 -->
    </div>
    
    <section id="welcome" class="p-b-0">
        <div class="container">
            <div class="heading-text heading-section text-center m-b-40" data-animate="animate__fadeInUp">
                <h2>Discover Campgrounds, RV Parks, and Hidden Getaways Across the USA</h2>
                <span class="lead">Whether you're planning a weekend escape or a cross-country adventure, RVParkHQ helps you find the perfect spot - filtered by the features that matter to you: pet-friendly, hookups, big rig access, and more."</span>
            </div>
            <div class="row" data-animate="animate__fadeInUp">
                <div class="col-lg-12">
                    <img class="img-fluid" src="{{ asset('assets/images/selfipic.png') }}" alt="Welcome to RV Park">
                </div>
            </div>
        </div>
    </section>
    <section class="background-grey py-5">
        <div class="container">
            <div class="heading-text heading-section text-center mb-5">
                <h2 class="fw-bold">What We Do for Campers</h2>
                <p class="lead text-muted">
                    Discover amazing places to stay — with powerful tools to help you search, compare, and plan your
                    next adventure.
                </p>
            </div>
            <div class="row g-4">
                <!-- Feature Box Start -->
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="fs-2 mb-3"><i class="fas fa-search-location fa-2x text-primary"></i></div>
                        <h5 class="fw-semibold mb-2">Search Made Simple</h5>
                        <p class="text-muted">Filter parks by pet policy, hookups, amenities, RV size, or tent-only options.</p>
                    </div>
                </div>
                <!-- Feature Box -->
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="fs-2 mb-3"><i class="fas fa-map-marked-alt fa-2x text-success"></i></div>
                        <h5 class="fw-semibold mb-2">Browse by State or Region</h5>
                        <p class="text-muted">Explore parks from coast to coast — easily sorted by location.</p>
                    </div>
                </div>
                <!-- Feature Box -->
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="fs-2 mb-3"><i class="fas fa-star fa-2x text-warning"></i></div>
                        <h5 class="fw-semibold mb-2">Real Reviews & Ratings</h5>
                        <p class="text-muted">Read what other campers are saying before you book your next stay.</p>
                    </div>
                </div>
                <!-- Feature Box -->
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="fs-2 mb-3"><i class="fas fa-camera-retro fa-2x text-danger"></i></div>
                        <h5 class="fw-semibold mb-2">Photos You Can Trust</h5>
                        <p class="text-muted">Claimed listings include verified images so you know what to expect.</p>
                    </div>
                </div>
                <!-- Feature Box -->
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="fs-2 mb-3"><i class="fas fa-location-arrow fa-2x text-info"></i></div>
                        <h5 class="fw-semibold mb-2">One-Click Driving Directions</h5>
                        <p class="text-muted">Get directions instantly via Google Maps or Waze — no app login required.</p>
                    </div>
                </div>
                <!-- Feature Box -->
                <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                        <div class="fs-2 mb-3"><i class="fas fa-envelope-open-text fa-2x text-secondary"></i></div>
                        <h5 class="fw-semibold mb-2">Campground News & Deals</h5>
                        <p class="text-muted">Get updates, travel ideas, and last-minute offers delivered to your inbox.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Tools for Campground Owners</h2>
                <p class="lead text-muted">
                    Claim your listing, connect with campers, and grow your business — all with zero cost.
                </p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-primary text-white mb-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="fw-semibold">Smart Insights Weekly</h5>
                            <p class="text-muted">Get automatic traffic reports, booking data, and local event alerts
                                emailed every Monday.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-success text-white mb-3">
                                <i class="fas fa-link"></i>
                            </div>
                            <h5 class="fw-semibold">Boost Visibility with Backlinks</h5>
                            <p class="text-muted">Add a website link to your listing and get up to 5 photo slots to
                                drive traffic and SEO.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-warning text-white mb-3">
                                <i class="fas fa-images"></i>
                            </div>
                            <h5 class="fw-semibold">Showcase Your Park</h5>
                            <p class="text-muted">Claimed listings include up to 10 photos, event info, and a full park
                                description.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-danger text-white mb-3">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h5 class="fw-semibold">Highlighted on the Map</h5>
                            <p class="text-muted">Your park is pinned on the state map, shown above unclaimed parks.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-info text-white mb-3">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5 class="fw-semibold">Get Reviews, Build Trust</h5>
                            <p class="text-muted">Verified campers can leave reviews — you can respond and feature the
                                best ones.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-secondary text-white mb-3">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h5 class="fw-semibold">Highlight Deals</h5>
                            <p class="text-muted">Offer last-minute discounts — we promote them at the state level.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 7 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-dark text-white mb-3">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h5 class="fw-semibold">Upgrade Anytime</h5>
                            <p class="text-muted">Use WebDaVinci Flow for premium booking tools, rate optimization, and
                                AI-powered tips.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 8 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-primary text-white mb-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="fw-semibold">Secure Claim Process</h5>
                            <p class="text-muted">Claim your listing instantly if your email matches — or get verified
                                by an admin.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 9 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-success text-white mb-3">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <h5 class="fw-semibold">Guest Emails Feature You</h5>
                            <p class="text-muted">Be featured in Tuesday guest newsletters when you claim your listing.
                                Alert guests of deals.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Add this in your <head> if not already included -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <section class="text-light p-t-150 p-b-150" data-bg-parallax="images/parallax/12.jpg">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">

                <!-- Campgrounds Indexed -->
                <div class="col-lg-3">
                    <div class="text-center">
                        <div class="icon mb-2">
                            <i class="fas fa-map-marked-alt fa-3x"></i>
                        </div>
                        <div class="counter">
                            <span data-speed="2000" data-refresh-interval="50" data-to="2312" data-from="1000"
                                  data-seperator="true">2312</span>
                        </div>
                        <div class="seperator seperator-small"></div>
                        <p>Campgrounds Indexed</p>
                    </div>
                </div>

                <!-- Claimed Parks -->
                <div class="col-lg-3">
                    <div class="text-center">
                        <div class="icon mb-2">
                            <i class="fas fa-user-check fa-3x"></i>
                        </div>
                        <div class="counter">
                            <span data-speed="2200" data-refresh-interval="50" data-to="580" data-from="200"
                                  data-seperator="true">580</span>
                        </div>
                        <div class="seperator seperator-small"></div>
                        <p>Claimed Parks</p>
                    </div>
                </div>

                <!-- Verified Reviews -->
                <div class="col-lg-3">
                    <div class="text-center">
                        <div class="icon mb-2">
                            <i class="fas fa-star fa-3x"></i>
                        </div>
                        <div class="counter">
                            <span data-speed="2500" data-refresh-interval="40" data-to="1420" data-from="500"
                                  data-seperator="true">1420</span>
                        </div>
                        <div class="seperator seperator-small"></div>
                        <p>Verified Reviews Collected</p>
                    </div>
                </div>

                <!-- Guest Emails Delivered -->
                <div class="col-lg-3">
                    <div class="text-center">
                        <div class="icon mb-2">
                            <i class="fas fa-envelope-open-text fa-3x"></i>
                        </div>
                        <div class="counter">
                            <span data-speed="2700" data-refresh-interval="50" data-to="6005" data-from="1000"
                                  data-seperator="true">6005</span>
                        </div>
                        <div class="seperator seperator-small"></div>
                        <p>Guest Emails Delivered</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @if($blogs->count() > 0)
        <section class="content background-grey">
            <div class="container">
                <div class="heading-text heading-section">
                    <h2>From the Campfire to the Control Room</h2>
                    <span class="lead">
                Travel stories, campground reviews, and marketing tips for owners — updated weekly.
            </span>
                </div>

                <div id="blog" class="grid-layout post-3-columns m-b-30" data-item="post-item">
                    @foreach($blogs as $blog)
                        <div class="post-item border">
                            <div class="post-item-wrap">
                                <div class="post-image">
                                    <a href="{{ route('rv-park.blogs.show', $blog->slug) }}">
                                        <img alt="{{ $blog->title }}" src="{{ asset('storage/' . $blog->thumbnail) }}">
                                    </a>
                                    <span class="post-meta-category">
                                <a href="#">{{ ucfirst($blog->status) }}</a>
                            </span>
                                </div>
                                <div class="post-item-description">
                            <span class="post-meta-date">
                                <i class="fa fa-calendar-o"></i>
                                {{ \Carbon\Carbon::parse($blog->published_at)->format('M d, Y') }}
                            </span>
                                    <span class="post-meta-comments">
                                <i class="fa fa-user"></i>
                                {{ $blog->user->name ?? 'Admin' }}
                            </span>
                                    <h2>
                                        <a href="{{ route('rv-park.blogs.show', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    <p>{{ Str::limit($blog->excerpt, 150) }}</p>
                                    <a href="{{ route('rv-park.blogs.show', $blog->slug) }}" class="item-link">
                                        Read More <i class="icon-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section class="p-t-60 p-b-60" style="background: linear-gradient(135deg, #f4f7fa, #ffffff);">
        <div class="container">
            <div class="heading-text heading-section text-center">
                <h4 class="text-dark mb-2">Trusted by Companies and Parks That Care About Growth</h4>
            </div>
            <div class="heading-text heading-section text-center">
                <p class="lead text-muted">Trusted by Companies and Parks That Care About Growth</p>
            </div>

            <div class="row mt-5 justify-content-center">
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white rounded-4 transition-3d-hover">
                        <div class="icon mb-3 display-4">🏕️</div>
                        <h5 class="fw-bold text-dark">Kayuta Lake Campground</h5>
                        <p class="text-muted small mb-0">Our first full-service client</p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white rounded-4 transition-3d-hover">
                        <div class="icon mb-3 display-4">🛠️</div>
                        <h5 class="fw-bold text-dark">WebDaVinci</h5>
                        <p class="text-muted small mb-0">Platform & Software Development</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white rounded-4 transition-3d-hover">
                        <div class="icon mb-3 display-4">🌐</div>
                        <h5 class="fw-bold text-dark">Sola Digital</h5>
                        <p class="text-muted small mb-0">Technology Integration Partner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

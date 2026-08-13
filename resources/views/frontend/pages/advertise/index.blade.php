@extends('frontend.pages.layouts.app')

@section('content')

    <section id="page-title" class="text-light"
             data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title text-center py-5 my-5 animate__animated animate__fadeInUp">
                <h1 class="display-3 fw-bold mb-3 text-gradient">Amplify Your Reach</h1>
                <p class="lead mt-3 mx-auto" style="max-width: 700px;">Connect with thousands of passionate outdoor
                    enthusiasts actively searching for campgrounds and RV experiences.</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="#ad-solutions" class="btn btn-primary btn-lg px-4 py-3 btn-glow">Explore Options</a>
                    <a href="#contact-form" class="btn btn-outline-light btn-lg px-4 py-3">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Proposition Cards -->
    <section class="py-5 bg-white position-relative z-index-1">
        <div class="container">
            <div class="text-center mb-5">
                <div class="d-flex justify-content-center bg-light py-4">
                    <div id="adImageBox" class="position-relative text-center border rounded shadow-sm bg-white"
                         style="max-width: 750px; width: 100%;">

                        <button
                            class="position-absolute top-0 end-0 btn btn-sm bg-white text-dark border rounded-circle m-2 shadow-sm"
                            style="width: 30px; height: 30px; font-weight: bold; z-index: 1055;"
                            onclick="hideImageAd()">×
                        </button>

                        <div class="text-start small text-muted px-3 pt-4">
                            <i class="fa fa-info-circle me-1"></i> Sponsored Ad
                        </div>

                        <a href="https://www.webdavinci.com/" target="_blank">
                            <img src="{{ asset('assets/images/ads/729x91.png') }}"
                                 alt="Advertisement"
                                 class="img-fluid rounded shadow-sm border border-secondary m-3">
                        </a>
                    </div>
                </div>

                <span class="badge bg-primary-soft text-primary m-3">WHY ADVERTISE WITH US</span>
                <h2 class="mb-3 display-5 fw-bold">Targeted Exposure That Converts</h2>
                <p class="text-muted mx-auto" style="max-width: 700px;">Our platform delivers your message directly to
                    engaged campers and park owners actively making decisions.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="value-card card border-0 rounded-4 overflow-hidden h-100">
                        <div class="card-body p-4 p-xl-5 position-relative">
                            <div class="value-icon bg-primary-soft text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3 class="h4 fw-bold mt-4">Premium Audience</h3>
                            <p class="text-muted">Access thousands of high-intent campers planning their next
                                adventure.</p>
                            <ul class="value-list">
                                <li>RV owners</li>
                                <li>Family campers</li>
                                <li>Outdoor enthusiasts</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="value-card card border-0 rounded-4 overflow-hidden h-100">
                        <div class="card-body p-4 p-xl-5 position-relative">
                            <div class="value-icon bg-success-soft text-success">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <h3 class="h4 fw-bold mt-4">Measurable Impact</h3>
                            <p class="text-muted">Track performance with detailed analytics and conversion metrics.</p>
                            <ul class="value-list">
                                <li>Click-through rates</li>
                                <li>Impression data</li>
                                <li>Engagement metrics</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="value-card card border-0 rounded-4 overflow-hidden h-100">
                        <div class="card-body p-4 p-xl-5 position-relative">
                            <div class="value-icon bg-warning-soft text-warning">
                                <i class="bi bi-lightning"></i>
                            </div>
                            <h3 class="h4 fw-bold mt-4">Flexible Solutions</h3>
                            <p class="text-muted">Choose from multiple formats to match your goals and budget.</p>
                            <ul class="value-list">
                                <li>Display ads</li>
                                <li>Sponsored content</li>
                                <li>Newsletter features</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advertising Solutions -->
    <section id="ad-solutions" class="py-5 bg-light position-relative">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary-soft text-primary mb-3">ADVERTISING SOLUTIONS</span>
                <h2 class="mb-3 display-5 fw-bold">Custom Campaigns for Your Goals</h2>
                <p class="text-muted mx-auto" style="max-width: 700px;">Select the advertising format that aligns with
                    your marketing objectives.</p>
            </div>

            <!-- Featured Listings -->
            <div class="ad-solution-card card border-0 rounded-4 overflow-hidden mb-5 shadow-sm">
                <div class="row g-0">
                    <div class="col-lg-6 d-flex align-items-center bg-primary-soft">
                        <div class="p-4 p-xl-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="solution-icon bg-primary text-white">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <h3 class="mb-0 fw-bold ms-3">Featured Listings</h3>
                            </div>
                            <p class="lead mb-4">Elevate your campground above competitors with premium placement.</p>
                            <ul class="solution-features">
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Priority in search results</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Featured badge for credibility
                                </li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Double the photo capacity</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Regional spotlight options</li>
                            </ul>
                            <div class="solution-pricing mt-4">
                                <div class="d-flex align-items-center">
                                    <span class="price fw-bold">$10</span>
                                    <span class="period ms-2">/month</span>
                                    <span class="badge bg-white text-primary ms-3">or $100/year (save 17%)</span>
                                </div>
                            </div>
                            <a href="#contact-form" class="btn btn-primary mt-4">Get Featured</a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-white">
                        <img src="{{ asset('assets/images/ads/301x251.png') }}" class="img-fluid p-4"
                             alt="Featured Listing Preview">
                    </div>
                </div>
            </div>

            <!-- Banner Ads -->
            <div class="ad-solution-card card border-0 rounded-4 overflow-hidden mb-5 shadow-sm">
                <div class="row g-0 flex-row-reverse">
                    <div class="col-lg-6 d-flex align-items-center bg-info-soft">
                        <div class="p-4 p-xl-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="solution-icon bg-info text-white">
                                    <i class="bi bi-image"></i>
                                </div>
                                <h3 class="mb-0 fw-bold ms-3">Display Advertising</h3>
                            </div>
                            <p class="lead mb-4">High-visibility banners across our high-traffic pages.</p>

                            <div class="ad-format-tabs mb-4">
                                <ul class="nav nav-tabs" id="bannerAdTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="homepage-tab" data-bs-toggle="tab"
                                                data-bs-target="#homepage" type="button">Homepage
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="search-tab" data-bs-toggle="tab"
                                                data-bs-target="#search" type="button">Search Results
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="blog-tab" data-bs-toggle="tab"
                                                data-bs-target="#blog" type="button">Blog
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content p-3 border border-top-0 rounded-bottom bg-white"
                                     id="bannerAdTabsContent">
                                    <div class="tab-pane fade show active" id="homepage" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>728×90 Leaderboard</span>
                                            <strong>$75/month</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>970×250 Billboard</span>
                                            <strong>$200/3 months</strong>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="search" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>300×250 Medium Rectangle</span>
                                            <strong>$50/month</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>300×600 Half Page</span>
                                            <strong>$135/3 months</strong>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="blog" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>300×250 Sidebar</span>
                                            <strong>$25/month</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>320×100 Mobile</span>
                                            <strong>$65/3 months</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="#contact-form" class="btn btn-info">Reserve Ad Space</a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-white">
                        <div class="p-4 text-center">
                            <div class="banner-ad-preview mb-4">
                                <img src="{{ asset('assets/images/ads/729x91.png') }}"
                                     class="img-fluid rounded-3 shadow-sm mb-2" style="max-width: 250px;"
                                     alt="728x90 Banner">
                                <img src="{{ asset('assets/images/ads/970x250.png') }}"
                                     class="img-fluid rounded-3 shadow-sm" style="max-width: 250px;"
                                     alt="970x250 Banner">
                            </div>
                            <p class="small text-muted">All standard IAB sizes supported</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsored Content & Newsletter -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="ad-solution-card card border-0 rounded-4 overflow-hidden h-100 shadow-sm">
                        <div class="card-body p-4 p-xl-5 bg-purple-soft">
                            <div class="d-flex align-items-center mb-4">
                                <div class="solution-icon bg-purple text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <h3 class="mb-0 fw-bold ms-3">Sponsored Content</h3>
                            </div>
                            <p class="lead mb-4">Share your expertise through native content that engages our
                                audience.</p>
                            <ul class="solution-features">
                                <li><i class="bi bi-check-circle-fill text-purple"></i> Blog articles ($100-$200)</li>
                                <li><i class="bi bi-check-circle-fill text-purple"></i> Product reviews ($150-$300)</li>
                                <li><i class="bi bi-check-circle-fill text-purple"></i> Guest posts ($75-$150)</li>
                            </ul>
                            <div class="mt-4">
                                <img src="{{ asset('assets/images/ads/600x200.png') }}"
                                     class="img-fluid rounded-3 border border-white border-3 shadow-sm"
                                     alt="Sponsored Content Example">
                            </div>
                            <a href="#contact-form" class="btn btn-purple mt-4">Create Content</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ad-solution-card card border-0 rounded-4 overflow-hidden h-100 shadow-sm">
                        <div class="card-body p-4 p-xl-5 bg-danger-soft">
                            <div class="d-flex align-items-center mb-4">
                                <div class="solution-icon bg-danger text-white">
                                    <i class="bi bi-envelope-open"></i>
                                </div>
                                <h3 class="mb-0 fw-bold ms-3">Email Newsletter</h3>
                            </div>
                            <p class="lead mb-4">Direct access to thousands of subscribers' inboxes.</p>
                            <ul class="solution-features">
                                <li><i class="bi bi-check-circle-fill text-danger"></i> Header banner ($50/send)</li>
                                <li><i class="bi bi-check-circle-fill text-danger"></i> Featured section ($35/send)</li>
                                <li><i class="bi bi-check-circle-fill text-danger"></i> Inline mention ($25/send)</li>
                            </ul>
                            <div class="mt-4">
                                <img src="{{ asset('assets/images/ads/600x200.png') }}"
                                     class="img-fluid rounded-3 border border-white border-3 shadow-sm"
                                     alt="Newsletter Example">
                            </div>
                            <a href="#contact-form" class="btn btn-danger mt-4">Book Newsletter Spot</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Sponsorship -->
            <div class="ad-solution-card card border-0 rounded-4 overflow-hidden mb-5 shadow-sm">
                <div class="row g-0">
                    <div class="col-lg-6 d-flex align-items-center bg-success-soft">
                        <div class="p-4 p-xl-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="solution-icon bg-success text-white">
                                    <i class="bi bi-award"></i>
                                </div>
                                <h3 class="mb-0 fw-bold ms-3">Category Sponsorship</h3>
                            </div>
                            <p class="lead mb-4">Become the exclusive brand associated with specific categories.</p>
                            <ul class="solution-features">
                                <li><i class="bi bi-check-circle-fill text-success"></i> State/Regional: $200/year</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> National: $500/year</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Category Exclusive: +50%</li>
                            </ul>
                            <div class="solution-pricing mt-4">
                                <div class="d-flex align-items-center">
                                    <span class="text-muted">Perfect for:</span>
                                    <span class="badge bg-white text-success ms-2">RV Services</span>
                                    <span class="badge bg-white text-success ms-2">Insurance</span>
                                    <span class="badge bg-white text-success ms-2">Solar</span>
                                </div>
                            </div>
                            <a href="#contact-form" class="btn btn-success mt-4">Become a Sponsor</a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-white">
                        <img src="{{ asset('assets/images/ads/600x100.png') }}" class="img-fluid p-4"
                             alt="Category Sponsorship Preview">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-dark text-white position-relative overflow-hidden">
        <div class="cta-pattern"></div>
        <div class="container position-relative z-index-1">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-3">Ready to Grow Your Business?</h2>
                    <p class="lead mb-4">Join dozens of successful brands reaching thousands of outdoor enthusiasts
                        every day.</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-3 fs-4"></i>
                        <span>No long-term contracts</span>
                        <i class="bi bi-check-circle-fill text-success mx-3 fs-4"></i>
                        <span>Cancel anytime</span>
                        <i class="bi bi-check-circle-fill text-success mx-3 fs-4"></i>
                        <span>Performance tracking</span>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="#contact-form" class="btn btn-light btn-lg px-4 py-3 fw-bold">Start Advertising Now</a>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-4">
        <div id="adImageBox2"
             class="card border-0 shadow-sm rounded-4 position-relative text-center px-4 py-5 bg-white"
             style="max-width: 700px; margin: auto;">

            <button class="position-absolute top-0 end-0 btn btn-sm bg-white text-dark border rounded-circle m-2 shadow-sm"
                    style="width: 30px; height: 30px; font-weight: bold; z-index: 1055;"
                    onclick="hideImage()">×
            </button>

            <div class="text-start small text-muted mb-4">
                <i class="fa fa-info-circle me-1"></i> Sponsored Ad
            </div>

            <div class="mb-4">
                <a href="https://book.kayuta.com/" target="_blank" class="d-block ad-hover">
                    <img src="{{ asset('assets/images/ads/301x251.png') }}"
                         class="img-fluid rounded border shadow-sm"
                         style="max-width: 100%; height: auto;" alt="Top Ad">
                </a>
            </div>

            <div>
                <a href="https://book.kayuta.com/" target="_blank" class="d-block ad-hover">
                    <img src="{{ asset('assets/images/ads/600x100.png') }}"
                         class="img-fluid rounded border shadow-sm"
                         style="max-width: 100%; width: 300px; height: auto; object-fit: cover;" alt="Bottom Ad">
                </a>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <section id="contact-form" class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-lg">
                        <div class="row g-0">
                            <div class="col-lg-5 d-none d-lg-flex bg-primary text-white">
                                <div class="p-4 p-xl-5 d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <h3 class="fw-bold mb-4">Let's Create Your Campaign</h3>
                                        <p class="mb-4">Fill out this form and our advertising team will contact you
                                            within 24 hours to discuss the best options for your business.</p>

                                        <div class="contact-info-item mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="contact-icon bg-white text-primary rounded-circle me-3">
                                                    <i class="bi bi-envelope"></i>
                                                </div>
                                                <span>advertising@campgroundreviews.com</span>
                                            </div>
                                        </div>

                                        <div class="contact-info-item mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="contact-icon bg-white text-primary rounded-circle me-3">
                                                    <i class="bi bi-telephone"></i>
                                                </div>
                                                <span>(800) 555-1234</span>
                                            </div>
                                        </div>

                                        <div class="contact-info-item">
                                            <div class="d-flex align-items-center">
                                                <div class="contact-icon bg-white text-primary rounded-circle me-3">
                                                    <i class="bi bi-clock"></i>
                                                </div>
                                                <span>Mon-Fri: 9am-5pm EST</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-shield-check fs-4 me-3"></i>
                                            <span>We never share your information with third parties</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 bg-white">
                                <div class="p-4 p-xl-5">
                                    <h3 class="fw-bold mb-4">Get Started Today</h3>
                                    <form action="{{ route('rv-park.advertise.store') }}" method="post"
                                          class="needs-validation" novalidate>
                                        @csrf

                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Full Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Your name" required>
                                                <div class="invalid-feedback">Please enter your name.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="company" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" id="company" name="company"
                                                       placeholder="Your business">
                                            </div>
                                        </div>

                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       placeholder="you@example.com" required>
                                                <div class="invalid-feedback">Please enter a valid email.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">Phone <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" id="phone" name="phone"
                                                       placeholder="(123) 456-7890" required>
                                                <div class="invalid-feedback">Please enter your phone number.</div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="interest" class="form-label">Advertising Interest <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="interest" name="interest" required>
                                                <option value="" selected disabled>Select an option</option>
                                                <option value="featured">Featured Listings</option>
                                                <option value="banner">Display/Banner Ads</option>
                                                <option value="sponsored">Sponsored Content</option>
                                                <option value="newsletter">Newsletter Ads</option>
                                                <option value="sponsorship">Category Sponsorship</option>
                                                <option value="other">Other/Custom</option>
                                            </select>
                                            <div class="invalid-feedback">Please select an option.</div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="message" class="form-label">Tell Us About Your Goals</label>
                                            <textarea class="form-control" id="message" name="message" rows="4"
                                                      placeholder="What would you like to achieve with your advertising campaign?"></textarea>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3">Submit
                                                Inquiry
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ad Preview Modal -->
    <div class="modal fade" id="adPreviewModal" tabindex="-1" aria-labelledby="adPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adPreviewModalLabel">Ad Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalAdImage" src="" class="img-fluid" alt="Ad Preview">
                    <h4 id="modalAdTitle" class="mt-3"></h4>
                    <p id="modalAdSize" class="text-muted"></p>
                    <p id="modalAdPrice" class="fw-bold"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#contact-form" class="btn btn-primary" data-bs-dismiss="modal">Get This Ad</a>
                </div>
            </div>
        </div>
    </div>

    <div id="adNotify" class="modal-strip cookie-notify background-dark" style="display: block;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center mb-3 mb-lg-0">
                    <img src="{{ asset('assets/images/ads/600x200.png') }}"
                         class="img-fluid rounded-3 border border-white border-3 shadow-sm"
                         style="width: 200px; height: auto;">
                </div>
                <div class="col-lg-5 text-sm-center sm-center sm-m-b-10 m-t-5 text-light">
                    This advertisement is brought to you by our sponsors to keep the site free.
                    <a href="https://book.kayuta.com/" target="_blank" class="text-light">
                        <span>Learn more <i class="fa fa-info-circle"></i></span>
                    </a>
                </div>
                <div class="col-lg-3 text-end sm-text-center sm-center">
                    <button type="button" class="btn btn-rounded btn-light btn-outline btn-sm m-r-10 modal-close">
                        Decline
                    </button>
                    <button type="button" class="btn btn-rounded btn-light btn-sm modal-confirm">Got it!</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function hideImageAd() {
            const ad = document.getElementById('adImageBox');
            ad.style.display = 'none';

            setTimeout(() => {
                ad.style.display = 'block';
            }, 10000);
        }
        function hideImage() {
            const ad = document.getElementById('adImageBox2');
            ad.style.display = 'none';

            setTimeout(() => {
                ad.style.display = 'block';
            }, 10000);
        }
    </script>
@endsection

@push('styles')
    <style>
        /* Custom Color System */
        :root {
            --primary: #4361ee;
            --primary-soft: #e6e9ff;
            --secondary: #6c757d;
            --success: #2ecc71;
            --success-soft: #e8f8f0;
            --info: #17a2b8;
            --info-soft: #e3f6fa;
            --warning: #f39c12;
            --warning-soft: #fef5e6;
            --danger: #e74c3c;
            --danger-soft: #fdedea;
            --purple: #9c27b0;
            --purple-soft: #f5e6fa;
            --dark: #212529;
            --light: #f8f9fa;
        }

        .bg-primary-soft {
            background-color: var(--primary-soft);
        }

        .bg-success-soft {
            background-color: var(--success-soft);
        }

        .bg-info-soft {
            background-color: var(--info-soft);
        }

        .bg-warning-soft {
            background-color: var(--warning-soft);
        }

        .bg-danger-soft {
            background-color: var(--danger-soft);
        }

        .bg-purple-soft {
            background-color: var(--purple-soft);
        }

        .text-gradient {
            background: linear-gradient(90deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        /* Hero Section */
        #page-title {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        #page-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4));
            z-index: 0;
        }

        #page-title .container {
            position: relative;
            z-index: 1;
        }

        /* Value Cards */
        .value-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .value-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        .value-list {
            list-style: none;
            padding-left: 0;
            margin-top: 1.5rem;
        }

        .value-list li {
            position: relative;
            padding-left: 1.75rem;
            margin-bottom: 0.75rem;
        }

        .value-list li:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0.6em;
            width: 1rem;
            height: 2px;
            background-color: var(--primary);
        }

        /* Solution Cards */
        .ad-solution-card {
            transition: transform 0.3s ease;
        }

        .ad-solution-card:hover {
            transform: translateY(-5px);
        }

        .solution-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .solution-features {
            list-style: none;
            padding-left: 0;
        }

        .solution-features li {
            margin-bottom: 0.75rem;
            padding-left: 1.75rem;
            position: relative;
        }

        .solution-features li i {
            position: absolute;
            left: 0;
            top: 0.15em;
        }

        .solution-pricing .price {
            font-size: 2.5rem;
            line-height: 1;
        }

        .solution-pricing .period {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* Ad Format Tabs */
        .ad-format-tabs .nav-tabs {
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .ad-format-tabs .nav-tabs .nav-link {
            border: none;
            color: var(--secondary);
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
        }

        .ad-format-tabs .nav-tabs .nav-link.active {
            color: var(--primary);
            background: transparent;
            border-bottom: 3px solid var(--primary);
        }

        /* Testimonials */
        .testimonial-card {
            transition: transform 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
        }

        .quote-icon {
            position: absolute;
            right: 2rem;
            top: 2rem;
            font-size: 5rem;
            line-height: 1;
        }

        /* CTA Section */
        .cta-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset("assets/images/patterns/pattern-dots-white.png") }}');
            opacity: 0.05;
        }

        /* Contact Form */
        .contact-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Buttons */
        .btn-glow {
            box-shadow: 0 0 15px rgba(67, 97, 238, 0.5);
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 15px rgba(67, 97, 238, 0.5);
            }
            50% {
                box-shadow: 0 0 25px rgba(67, 97, 238, 0.8);
            }
            100% {
                box-shadow: 0 0 15px rgba(67, 97, 238, 0.5);
            }
        }

        .btn-purple {
            background-color: var(--purple);
            color: white;
        }

        .btn-purple:hover {
            background-color: #7b1fa2;
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 991.98px) {
            #page-title {
                min-height: auto;
                padding-top: 7rem;
                padding-bottom: 7rem;
            }

            .solution-pricing .price {
                font-size: 2rem;
            }
        }

        @media (max-width: 767.98px) {
            .value-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .solution-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .solution-pricing .price {
                font-size: 1.75rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Form Validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Initialize tab functionality
        var bannerAdTabs = document.getElementById('bannerAdTabs');
        if (bannerAdTabs) {
            var tab = new bootstrap.Tab(bannerAdTabs.querySelector('.nav-link'));
            tab.show();
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Animate elements when they come into view
        document.addEventListener('DOMContentLoaded', function () {
            const animatedElements = document.querySelectorAll('.value-card, .ad-solution-card, .testimonial-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            animatedElements.forEach(element => {
                observer.observe(element);
            });
        });

        // Ad Preview Modal Functionality
        function showAdPreview(title, size, price, imageUrl) {
            document.getElementById('modalAdTitle').textContent = title;
            document.getElementById('modalAdSize').textContent = size;
            document.getElementById('modalAdPrice').textContent = price;
            document.getElementById('modalAdImage').src = imageUrl;

            var modal = new bootstrap.Modal(document.getElementById('adPreviewModal'));
            modal.show();
        }

        // Add click handlers to ad preview images
        document.addEventListener('DOMContentLoaded', function () {
            // For featured listing
            const featuredImg = document.querySelector('.featured-listing-mockup img');
            if (featuredImg) {
                featuredImg.addEventListener('click', function () {
                    showAdPreview(
                        'Featured Listing Example',
                        '300×250 Medium Rectangle',
                        '$10/month or $100/year',
                        this.src
                    );
                });
            }

            // For banner ads
            const bannerAds = document.querySelectorAll('.banner-ad-preview img');
            bannerAds.forEach(ad => {
                ad.addEventListener('click', function () {
                    const size = this.alt.includes('728x90') ? '728×90 Leaderboard' :
                        this.alt.includes('970x250') ? '970×250 Billboard' :
                            this.alt.includes('300x250') ? '300×250 Medium Rectangle' :
                                this.alt.includes('300x600') ? '300×600 Half Page' :
                                    this.alt.includes('320x100') ? '320×100 Mobile' : 'Standard Ad';
                    const price = size === '728×90 Leaderboard' ? '$75/month' :
                        size === '970×250 Billboard' ? '$200/3 months' :
                            size === '300×250 Medium Rectangle' ? '$50/month' :
                                size === '300×600 Half Page' ? '$135/3 months' :
                                    size === '320×100 Mobile' ? '$65/3 months' : 'Contact for pricing';

                    showAdPreview(
                        'Banner Ad Example',
                        size,
                        price,
                        this.src
                    );
                });
            });

            // For other ad types
            const otherAds = document.querySelectorAll('.ad-solution-card img:not(.banner-ad-preview img)');
            otherAds.forEach(ad => {
                ad.addEventListener('click', function () {
                    let title = 'Ad Example';
                    let size = 'Standard Size';
                    let price = 'Contact for pricing';

                    if (this.closest('.bg-purple-soft')) {
                        title = 'Sponsored Content Example';
                        price = '$100-$300';
                    } else if (this.closest('.bg-danger-soft')) {
                        title = 'Newsletter Ad Example';
                        price = '$25-$50 per send';
                    } else if (this.closest('.bg-success-soft')) {
                        title = 'Category Sponsorship Example';
                        price = '$200-$500/year';
                    }

                    showAdPreview(
                        title,
                        size,
                        price,
                        this.src
                    );
                });
            });
        });
    </script>
@endpush

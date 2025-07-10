@extends('frontend.pages.layouts.app')

@section('content')

    <!-- Hero Section -->
    <section id="page-title" class="text-light position-relative" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container position-relative">
            <div class="page-title text-center">
                <h1 class="display-4 fw-bold">Advertise With Us</h1>
                <p class="lead mt-3">Promote your brand to campers, park owners, and outdoor lovers through powerful ad placements.</p>
                <a href="#contact-form" class="btn btn-primary btn-lg mt-3 animated-button">Get Started</a>
            </div>
        </div>
        <div class="gradient-overlay"></div>
    </section>

    <!-- Page Content -->
    <section id="page-content" class="bg-light py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8 col-md-12">

                    <!-- Featured Listings -->
                    <div class="card shadow-sm border-0 mb-5 rounded-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-star-fill text-warning fs-1 me-3 icon-hover"></i>
                                <h3 class="mb-0">Featured Listings (Per Park)</h3>
                            </div>
                            <ul class="mb-3">
                                <li><strong>$10/month</strong> or <strong>$100/year</strong> (save 17%)</li>
                                <li>Premium placement in search results</li>
                                <li>Includes up to 12 photos (vs. 6 for standard listings)</li>
                                <li>Featured badge and priority sorting</li>
                                <li>State-level featured placement</li>
                            </ul>
                            <div class="text-center mt-4">
                                <img src="{{ asset('assets/images/ads/301x251.png') }}" class="img-fluid rounded shadow-sm" style="max-width: 300px;" alt="Featured Listing Example">
                            </div>
                        </div>
                    </div>

                    <!-- Banner Ads -->
                    <div class="card shadow-sm border-0 mb-5 rounded-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-image-fill text-primary fs-1 me-3 icon-hover"></i>
                                <h3 class="mb-0">Banner Ads (Static or Rotating)</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-striped">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Placement</th>
                                        <th>Size</th>
                                        <th>Rate</th>
                                        <th>Preview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="discount-row">
                                        <td>Homepage Top (Premium)</td>
                                        <td>728×90 or 970×250</td>
                                        <td><strong>$75/month</strong><br><small>($200 for 3 months)</small></td>
                                        <td>
                                            <img src="{{ asset('assets/images/ads/729x91.png') }}" class="img-fluid rounded shadow-sm mb-2" style="max-width: 200px;" alt="">
                                            <img src="{{ asset('assets/images/ads/970x250.png') }}" class="img-fluid rounded shadow-sm" style="max-width: 200px;" alt="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Search Results Sidebar</td>
                                        <td>300×250 or 300×600</td>
                                        <td>$50/month<br><small>($135 for 3 months)</small></td>
                                        <td>
                                            <img src="{{ asset('assets/images/ads/302x252.png') }}" class="img-fluid rounded shadow-sm mb-2" style="max-width: 150px;" alt="">
                                            <img src="{{ asset('assets/images/ads/300x600.png') }}" class="img-fluid rounded shadow-sm" style="max-width: 150px;" alt="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Blog Sidebar / Footer</td>
                                        <td>300×250 or 320×100</td>
                                        <td>$25/month<br><small>($65 for 3 months)</small></td>
                                        <td>
                                            <img src="{{ asset('assets/images/ads/303x253.png') }}" class="img-fluid rounded shadow-sm mb-2" style="max-width: 150px;" alt="">
                                            <img src="{{ asset('assets/images/ads/320x100.png') }}" class="img-fluid rounded shadow-sm" style="max-width: 180px;" alt="">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-info mt-4">
                                <i class="bi bi-lightbulb-fill me-2"></i> <strong>Pro Tip:</strong> Our 3-month introductory bundles offer discounts of 10-15% and help maximize your visibility.
                            </div>
                        </div>
                    </div>

                    <!-- Sponsored Content -->
                    <div class="row">
                        <!-- Sponsored Articles -->
                        <div class="col-md-6 col-12 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-hover">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-newspaper text-secondary fs-1 me-3 icon-hover"></i>
                                        <h3 class="mb-0">Sponsored Content</h3>
                                    </div>
                                    <ul>
                                        <li><strong>Blog Articles:</strong> $100–$200</li>
                                        <li><strong>Product Reviews:</strong> $150–$300</li>
                                        <li><strong>Guest Posts:</strong> $75–$150</li>
                                    </ul>
                                    <p class="mt-3">Perfect for RV gear brands, reservation systems, and campground services.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Newsletter Ads -->
                        <div class="col-md-6 col-12 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-hover">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-envelope-open-fill text-danger fs-1 me-3 icon-hover"></i>
                                        <h3 class="mb-0">Newsletter Ads</h3>
                                    </div>
                                    <ul>
                                        <li><strong>Header Banner:</strong> $50 per send</li>
                                        <li><strong>Featured Section:</strong> $35 per send</li>
                                        <li><strong>Inline Mention:</strong> $25 per send</li>
                                    </ul>
                                    <p class="mt-3">Reach thousands of engaged park owners and campers monthly.</p>
                                    <img src="{{ asset('assets/images/ads/600x200.png') }}" class="img-fluid rounded shadow-sm mt-2" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Sponsorship -->
                    <div class="card shadow-sm border-0 mb-5 rounded-hover">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-globe text-success fs-1 me-3 icon-hover"></i>
                                <h3 class="mb-0">Directory Category Sponsorship</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <ul>
                                        <li><strong>State/Regional:</strong> $200/year</li>
                                        <li><strong>National:</strong> $500/year</li>
                                        <li><strong>Category Exclusive:</strong> +50%</li>
                                    </ul>
                                    <p>Ideal for insurance providers, solar companies, and campground services.</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <img src="{{ asset('assets/images/ads/600x100.png') }}" class="img-fluid rounded shadow-sm" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="card shadow-sm border-0" id="contact-form">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Ready to Advertise?</h3>
                            <form action="{{ route('rv-park.advertise.store') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="name" class="form-label">Name *</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="company" class="form-label">Company</label>
                                        <input type="text" name="company" class="form-control" id="company" placeholder="Enter your company name">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Your email address" required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="phone" class="form-label">Phone *</label>
                                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Your phone number" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="interest" class="form-label">Advertising Interest *</label>
                                    <select class="form-select" name="interest" id="interest" required>
                                        <option value="">Select an option</option>
                                        <option value="featured">Featured Listing</option>
                                        <option value="banner">Banner Ads</option>
                                        <option value="sponsored">Sponsored Content</option>
                                        <option value="newsletter">Newsletter Ads</option>
                                        <option value="sponsorship">Category Sponsorship</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" name="message" id="message" rows="4" placeholder="Tell us about your advertising needs"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg mt-3">Submit Inquiry</button>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-12">
                    <div class="sticky-top" style="top: 20px;">
                        <!-- Ad Sizes Table -->
                        <div class="card shadow-sm border-0 mb-4 rounded-hover">
                            <div class="card-body p-4">
                                <h3 class="mb-3"><i class="bi bi-grid-1x2-fill me-2"></i>Standard Ad Sizes</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Size (px)</th>
                                            <th>Device</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr><td>Leaderboard</td><td>728×90</td><td>Desktop</td></tr>
                                        <tr><td>Large Rectangle</td><td>336×280</td><td>Desktop</td></tr>
                                        <tr><td>Medium Rectangle</td><td>300×250</td><td>All</td></tr>
                                        <tr><td>Half Page</td><td>300×600</td><td>Desktop</td></tr>
                                        <tr><td>Skyscraper</td><td>160×600</td><td>Desktop</td></tr>
                                        <tr><td>Billboard</td><td>970×250</td><td>Desktop</td></tr>
                                        <tr><td>Mobile Leaderboard</td><td>320×50</td><td>Mobile</td></tr>
                                        <tr><td>Mobile Banner</td><td>320×100</td><td>Mobile</td></tr>
                                        <tr><td>Square</td><td>250×250</td><td>All</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial -->
                        <div class="card shadow-sm border-0 mb-4 rounded-hover">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <i class="bi bi-chat-square-quote fs-1 text-muted"></i>
                                </div>
                                <blockquote class="blockquote">
                                    <p>"Advertising with Campground Reviews increased our bookings by 30% in just three months. The targeted audience is exactly who we want to reach."</p>
                                    <footer class="blockquote-footer mt-2">Sarah Johnson, <cite>Mountain View Campground</cite></footer>
                                </blockquote>
                            </div>
                        </div>

                        <!-- Placeholder Ad -->
                        <div class="card shadow-sm border-0 bg-primary text-white text-center">
                            <div class="card-body p-4">
                                <h4>Your Ad Could Be Here</h4>
                                <img src="{{ asset('assets/images/ads/304x254.png') }}" class="img-fluid rounded mt-3" alt="">
                                <p class="mt-3 mb-0">Reach thousands of campers every day</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
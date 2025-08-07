@extends('frontend.pages.layouts.app')

@section('content')
    <!-- Page Title -->
    <section id="page-title" data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title text-center">
                <h1 class="text-white">Free Marketing Help</h1>
                <p class="text-white-50">Boost your campground’s Facebook marketing with professional tools—free.</p>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li><a href="{{ route('rv-park.home') }}">Park Owners</a></li>
                    <li class="active"><a href="#">Free Marketing Help</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Main Section -->
    <section class="pt-5 pb-5 bg-light">
        <div class="container">
            <!-- Intro -->
            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <h2>Free Facebook Marketing Setup for Your Campground</h2>
                    <p class="lead">Professional Marketing Technology — Setup Assistance Included</p>
                    <p>Boost Your Campground's Online Marketing Results</p>
                    <p>Most campgrounds struggle with Facebook marketing because they can't tell which posts or ads actually bring in bookings. We’ll help you set up professional tracking technology (normally available only to large chains) completely free.</p>
                </div>
            </div>

            <!-- Why It Matters + Setup -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-exclamation-circle text-danger me-2"></i> Why This Matters Now</h4>
                            <p>Recent changes to Apple's privacy settings have broken most campground websites' ability to track visitors from Facebook. Without proper setup, you're marketing blind — spending money without knowing what works.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-tools text-success me-2"></i> What We'll Set Up For You (30–45 Minute Zoom Call)</h4>
                            <ul class="list-unstyled">
                                <li><strong>📍 Facebook Pixel & Advanced Tracking:</strong></li>
                                <ul>
                                    <li>See exactly which Facebook posts drive people to your website</li>
                                    <li>Track visitor behavior: which pages they view, how long they stay</li>
                                    <li>Create audiences of people who visited but didn't book yet</li>
                                    <li>Measure mobile vs desktop performance</li>
                                </ul>
                                <li class="mt-3"><strong>🛡️ iOS-Proof Tracking (CAPI):</strong></li>
                                <ul>
                                    <li>Works even when visitors have privacy settings enabled</li>
                                    <li>Ensures accurate data despite Apple's tracking restrictions</li>
                                    <li>Future-proofs your marketing measurement</li>
                                </ul>
                                <li class="mt-3"><strong>🌟 RVParkHQ Integration Badge:</strong></li>
                                <ul>
                                    <li>Professional "Review Us" button for your website</li>
                                    <li>Builds credibility and drives reviews</li>
                                    <li>Improves your search rankings</li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How it Works + Requirements -->
            <div class="row mt-5 g-4">
                <div class="col-md-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-laptop text-info me-2"></i> How It Works</h4>
                            <ol class="ps-3">
                                <li>Schedule Your Free Call – Choose a time that works for you</li>
                                <li>Screen Share Session – We guide you through each step</li>
                                <li>Complete Setup – Everything working before we hang up</li>
                                <li>Start Getting Better Results – Track what marketing actually works</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow border-0 h-100">
                        <div class="card-body">
                            <h4><i class="fas fa-check-circle text-warning me-2"></i> What You Need</h4>
                            <ul class="ps-3">
                                <li>💻 Computer with Zoom capability</li>
                                <li>🔐 Access to your website login</li>
                                <li>📘 Facebook account (we'll set up the business parts)</li>
                                <li>🕒 45 minutes of time</li>
                            </ul>
                            <p class="mt-2">No technical experience required — we guide you through everything step by step.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Free & CTA -->
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <h3 class="mb-3">Why We Offer This Free</h3>
                    <p class="mb-4">
                        We believe independent campgrounds deserve the same marketing advantages as big chains.
                        This setup normally costs $500–$1,500 through marketing agencies.
                        We provide it free to strengthen the independent campground community.
                    </p>

                    <a href="https://api.leadconnectorhq.com/widget/booking/LWU63jYbRpDzZTR4SjDA" target="_blank" class="btn btn-primary btn-lg px-4"
                       onclick="logMarketingScheduleClick()">Schedule Your Free Setup Call Now</a>
                    <p class="mt-2 small text-muted">* Available to all campgrounds listed in RVParkHQ directory. No purchase required.</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        function logMarketingScheduleClick() {
            fetch("{{ route('rv-park.log.marketing.schedule') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ page: 'free_marketing_help' })
            });
        }
    </script>

@endsection

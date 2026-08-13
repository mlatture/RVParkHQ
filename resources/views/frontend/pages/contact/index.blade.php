@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>Contact RVParkHQ</h1>
                <span>Questions, listing corrections, campground suggestions, and partnership inquiries.</span>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Contact</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <h2>How can we help?</h2>
                    <p>RVParkHQ is built to help campers discover great places to stay and help campground owners keep their public listing information accurate. Send us the clearest details you can, and we will route the request to the right person.</p>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 p-4" style="border-radius: 12px; border: 1px solid #e5e7eb;">
                                <h4>General Questions</h4>
                                <p>For directory questions, website issues, account questions, or feedback about RVParkHQ.</p>
                                <p class="mb-0"><a href="mailto:info@rvparkhq.com">info@rvparkhq.com</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 p-4" style="border-radius: 12px; border: 1px solid #e5e7eb;">
                                <h4>Listing Corrections</h4>
                                <p>Include the campground name, page URL, what needs to change, and a reliable source or owner contact if available.</p>
                                <p class="mb-0"><a href="mailto:info@rvparkhq.com?subject=RVParkHQ%20Listing%20Correction">Request a correction</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 p-4" style="border-radius: 12px; border: 1px solid #e5e7eb;">
                                <h4>Suggest a Campground</h4>
                                <p>Know a campground that should be listed? Use the suggestion page so we can capture the right details.</p>
                                <p class="mb-0"><a href="{{ route('rv-park.suggest.park') }}">Suggest a campground</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 p-4" style="border-radius: 12px; border: 1px solid #e5e7eb;">
                                <h4>Park Owners</h4>
                                <p>If you own or manage a campground, contact us about claiming or updating your listing.</p>
                                <p class="mb-0"><a href="mailto:info@rvparkhq.com?subject=RVParkHQ%20Owner%20Listing%20Claim">Ask about claiming a listing</a></p>
                            </div>
                        </div>
                    </div>

                    <h3>Before contacting a campground</h3>
                    <p>RVParkHQ is a directory. For reservations, rates, availability, cancellation policies, pet rules, road conditions, and day-of-arrival questions, contact the campground directly using the phone, website, or booking link shown on its listing when available.</p>

                    <h3>Review questions</h3>
                    <p>For review removals, disputes, or moderation questions, please read our <a href="{{ route('rv-park.review-guidelines') }}">Review Guidelines</a> first and include the review URL plus a clear explanation of the issue.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

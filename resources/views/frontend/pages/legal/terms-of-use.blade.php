@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>Terms of Use</h1>
                <span>The rules for using RVParkHQ.</span>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Terms of Use</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <p class="text-muted">Last updated: August 13, 2026</p>
                    <p>These Terms of Use govern your access to and use of RVParkHQ, including the campground directory, reviews, listing suggestions, owner claim tools, and related content. By using the site, you agree to these terms.</p>

                    <h3>Directory Information</h3>
                    <p>RVParkHQ provides campground and RV park information for discovery and planning. Listings may include data from park owners, users, public sources, or third-party providers. We work to keep information useful, but we do not guarantee that every listing, amenity, rate, phone number, availability detail, policy, photo, or location is complete, current, or error-free.</p>

                    <h3>No Booking, Travel, Legal, or Financial Advice</h3>
                    <p>Unless clearly stated otherwise, RVParkHQ is an information directory and community resource. We are not a campground operator, travel agent, broker, attorney, insurer, lender, or financial advisor. Always confirm prices, availability, restrictions, accessibility, pet rules, cancellation policies, and safety details directly with the campground before traveling or booking.</p>

                    <h3>User Accounts and Submissions</h3>
                    <p>You are responsible for the accuracy and legality of information you submit, including reviews, photos, listing suggestions, corrections, and owner claim details. You may not submit content that is false, misleading, defamatory, infringing, unlawful, spam, abusive, or harmful.</p>

                    <h3>Reviews and Community Content</h3>
                    <p>Reviews and ratings must follow our <a href="{{ route('rv-park.review-guidelines') }}">Review Guidelines</a>. We may moderate, edit for formatting, reject, or remove content that violates our rules or creates legal, safety, spam, or quality concerns.</p>

                    <h3>Park Owner Claims</h3>
                    <p>Park owners or authorized representatives may request to claim or update a listing. By submitting a claim, you represent that you are authorized to act for that campground or business. We may request verification and may approve, reject, suspend, or revoke claims at our discretion.</p>

                    <h3>Acceptable Use</h3>
                    <ul>
                        <li>Do not scrape, copy, resell, or bulk-export site data without written permission.</li>
                        <li>Do not interfere with site security, availability, forms, email systems, or account features.</li>
                        <li>Do not impersonate another person, park, business, or RVParkHQ representative.</li>
                        <li>Do not upload malware, spam, fake reviews, or content that violates another party's rights.</li>
                    </ul>

                    <h3>Third-Party Links</h3>
                    <p>RVParkHQ may link to campground websites, booking pages, maps, social pages, advertisers, or other third-party sites. We are not responsible for third-party content, policies, prices, bookings, transactions, or services.</p>

                    <h3>Intellectual Property</h3>
                    <p>The RVParkHQ site design, text, graphics, logos, software, and compiled directory are protected by applicable intellectual property laws. You retain ownership of content you submit, but you grant RVParkHQ a non-exclusive right to host, display, adapt, and use that content to operate and promote the directory.</p>

                    <h3>Disclaimers and Limitation of Liability</h3>
                    <p>The site is provided “as is” and “as available.” To the fullest extent permitted by law, RVParkHQ disclaims warranties and is not liable for indirect, incidental, special, consequential, or punitive damages arising from your use of the site or reliance on listing information.</p>

                    <h3>Changes to These Terms</h3>
                    <p>We may update these Terms of Use from time to time. Continued use of the site after changes are posted means you accept the updated terms.</p>

                    <h3>Contact</h3>
                    <p>Questions about these terms can be sent to <a href="mailto:info@rvparkhq.com">info@rvparkhq.com</a>.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

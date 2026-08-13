@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>Privacy Policy</h1>
                <span>How RVParkHQ collects, uses, and protects visitor information.</span>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Privacy Policy</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <p class="text-muted">Last updated: August 13, 2026</p>
                    <p>RVParkHQ helps campers discover campgrounds and RV parks and helps park owners keep their listing information accurate. This Privacy Policy explains what information we collect, how we use it, and the choices available to you.</p>

                    <h3>Information We Collect</h3>
                    <ul>
                        <li><strong>Information you provide:</strong> name, email address, account details, review submissions, suggested park information, listing claims, contact messages, and subscription preferences.</li>
                        <li><strong>Listing and review content:</strong> campground details, photos, amenities, ratings, comments, and correction requests submitted by users or park owners.</li>
                        <li><strong>Usage information:</strong> pages viewed, searches, referral URLs, browser/device details, IP address, approximate location, and basic analytics data.</li>
                        <li><strong>Cookies and similar technologies:</strong> session cookies, login preferences, security tokens, and analytics identifiers used to operate and improve the site.</li>
                    </ul>

                    <h3>How We Use Information</h3>
                    <ul>
                        <li>Operate the campground directory, account features, review tools, listing claim workflow, and email subscriptions.</li>
                        <li>Respond to contact requests, park suggestions, listing corrections, and support needs.</li>
                        <li>Improve search, navigation, listing quality, fraud prevention, security, and site performance.</li>
                        <li>Send transactional messages, review confirmations, subscription emails, or updates you requested.</li>
                        <li>Comply with legal obligations and enforce our Terms of Use and Review Guidelines.</li>
                    </ul>

                    <h3>How We Share Information</h3>
                    <p>We do not sell personal information. We may share information with service providers that help us host the website, send email, analyze traffic, protect the site, or process user requests. We may also disclose information when required by law, to protect rights and safety, or during a business transfer.</p>

                    <h3>Public Content</h3>
                    <p>Reviews, ratings, campground suggestions, and listing information submitted for publication may be displayed publicly. Do not include private personal information in public reviews or listing submissions.</p>

                    <h3>Your Choices</h3>
                    <ul>
                        <li>You may unsubscribe from marketing emails using the unsubscribe link in the message.</li>
                        <li>You may request correction or removal of your account information, review, or submitted listing content by contacting us.</li>
                        <li>You can limit cookies through your browser settings, although some site features may not work correctly without cookies.</li>
                    </ul>

                    <h3>Data Security</h3>
                    <p>We use reasonable safeguards to protect information, but no website or internet transmission is completely secure. Please use caution when submitting information online.</p>

                    <h3>Children</h3>
                    <p>RVParkHQ is not directed to children under 13, and we do not knowingly collect personal information from children under 13.</p>

                    <h3>Contact</h3>
                    <p>Questions about this Privacy Policy can be sent to <a href="mailto:info@rvparkhq.com">info@rvparkhq.com</a>.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>Review Guidelines</h1>
                <span>How to write helpful, fair campground reviews.</span>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Review Guidelines</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <p>RVParkHQ reviews should help campers make better decisions and help campground owners understand what guests experienced. Please keep reviews honest, specific, respectful, and based on real experiences.</p>

                    <h3>What Makes a Helpful Review</h3>
                    <ul>
                        <li><strong>Use first-hand experience.</strong> Review campgrounds you visited, contacted, booked, or directly interacted with.</li>
                        <li><strong>Be specific.</strong> Mention useful details such as site size, hookups, road access, cleanliness, staff communication, noise, Wi-Fi, pet areas, bathrooms, amenities, check-in, and value.</li>
                        <li><strong>Be fair and current.</strong> Note when you stayed or visited and avoid judging a park only on outdated information.</li>
                        <li><strong>Separate facts from opinions.</strong> It is fine to share your opinion, but avoid presenting guesses as facts.</li>
                    </ul>

                    <h3>Content We May Remove or Reject</h3>
                    <ul>
                        <li>Fake reviews, paid reviews that are not disclosed, duplicate reviews, or reviews from people who did not have a real experience with the campground.</li>
                        <li>Personal attacks, hate speech, harassment, threats, profanity aimed at individuals, or discriminatory content.</li>
                        <li>Private information, including personal phone numbers, home addresses, payment details, medical information, or private staff/customer details.</li>
                        <li>Commercial spam, promotional copy, affiliate links, unrelated links, or attempts to sell products or services inside a review.</li>
                        <li>Defamatory claims, accusations of criminal conduct, or serious safety/legal allegations that are not supported by first-hand detail.</li>
                        <li>Content copied from another website or content that infringes another party's rights.</li>
                    </ul>

                    <h3>Conflicts of Interest</h3>
                    <p>If you own, manage, work for, represent, compete with, or are closely connected to a campground, do not post a guest review as if you are an independent camper. Park representatives should use owner/listing tools or contact RVParkHQ to request corrections.</p>

                    <h3>Photos</h3>
                    <p>Only upload photos you have the right to share. Avoid photos that clearly show other guests, license plates, private documents, children, or private areas without permission.</p>

                    <h3>Moderation</h3>
                    <p>RVParkHQ may moderate reviews before or after publication. We may edit formatting, reject submissions, remove content, request verification, or disable accounts when needed to protect review quality, safety, legal compliance, or site integrity.</p>

                    <h3>Disputes and Corrections</h3>
                    <p>If you believe a review or listing is inaccurate, contact us with the campground name, the page URL, the specific issue, and any supporting details. We review correction requests but do not guarantee removal of a review simply because it is negative.</p>

                    <h3>Contact</h3>
                    <p>Review questions or correction requests can be sent to <a href="mailto:info@rvparkhq.com">info@rvparkhq.com</a>.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

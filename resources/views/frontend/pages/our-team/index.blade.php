@extends('frontend.pages.layouts.app')

@section('content')

    <section id="page-title" class="text-light" data-bg-parallax="{{ asset('assets/images/slider/revolution/polo-homepage/dummy.png') }}">
        <div class="container">
            <div class="page-title">
                <h1>Our Team</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li>Our Team</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="py-5 background-grey">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Meet Our Team</h2>
                <p class="text-muted">
                    We’re building more than a campground directory—we’re creating the foundation for a unified, intelligent booking platform that works across the outdoor hospitality industry.
                </p>
            </div>

            <div class="row">
                @foreach($team as $member)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="team-card position-relative">
                            <span class="flag-badge">{{ $member['flag'] }}</span>
                            <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="team-img"
                                @if($member['name'] === 'Dexter Cabagua')
                                     style="height: auto; object-fit: contain;"
                                @endif
                            >
                            <div class="team-body">
                                <div>
                                    <div class="team-name">{{ $member['name'] }}</div>
                                    <div class="team-role">{{ $member['role'] }} — <small>{{ $member['country'] }}</small></div>
                                    <h4 class="mt-5 mb-4 fw-bold border-bottom pb-2">Highlight</h4>
                                    <div class="team-bio">
                                        {{ $member['bio'] }}
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="mailto:{{ $member['email'] }}" class="btn btn-sm btn-outline-primary">
                                        <i class="icon-mail"></i> Contact
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <h5 class="text-muted">
                    Need help claiming your park or updating your listing? Contact any of our Partner Success team members.
                </h5>
            </div>
        </div>
    </section>

@endsection

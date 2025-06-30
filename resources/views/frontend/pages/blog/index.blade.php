@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" class="text-light"
             data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>Blogs</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li>{{ request()->segment(1) }}</li>
                </ul>
            </div>
        </div>
    </section>
    <section id="page-content">
        <div class="container-fluid">
            @if($blogs->count() > 0)
                <div class="row m-b-20 justify-content-center">
                    <div class="col-lg-6 p-t-10 m-b-20 text-center">
                        <strong>Travel stories, campground reviews, and marketing tips for owners — updated
                            weekly.</strong>
                    </div>
                </div>
            @endif
            <div class="shop">
                @if($blogs->count() > 0)
                    <div class="grid-layout grid-5-columns" data-item="grid-item">
                        @foreach($blogs as $blog)
                            <div class="grid-item">
                                <div class="park-card">
                                    <div class="park-image-container">
                                        @php
                                            $imagePath = $blog->thumbnail;
                                            $imageUrl = !empty($imagePath) ?
                                                (preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset('storage/' . $imagePath))
                                                : asset('images/placeholder.jpg');
                                        @endphp

                                        <a href="{{ route('rv-park.blogs.show', $blog->slug) }}">
                                            <img class="main" src="{{ $imageUrl }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('images/placeholder.jpg') }}';"
                                                 alt="Park Image">
                                            <div class="park-overlay">View Blog</div>
                                        </a>
                                    </div>
                                    <div class="p-3 text-center">
                                        <h5 class="mb-0">
                                            <a href="{{ route('rv-park.blogs.show', $blog->slug) }}"
                                               class="text-dark text-decoration-none">
                                                {{ ucfirst($blog->title) }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <div class="mb-3">
                            <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="2"
                                 class="text-secondary">
                                <rect x="8" y="14" width="40" height="28" rx="4" fill="#f8f9fa"/>
                                <path d="M8 18h40" stroke="#dee2e6"/>
                                <circle cx="20" cy="28" r="4" fill="#dee2e6"/>
                                <path d="M16 38l6-8 6 8 10-12 6 10" stroke="#adb5bd" fill="none"/>
                            </svg>
                        </div>
                        <h5 class="card-title text-muted">No Blogs Yet!</h5>
                        <p class="card-text text-muted mb-4">Looks like there’s nothing here right now. Why not
                            be the first to share a story or check back later?</p>
                        @auth
                            <a href="{{ route('rv-park.blogs.create') }}" class="btn btn-primary">
                                Create First Blog
                            </a>
                        @endauth
                    </div>
                @endif
            </div>

            @if($blogs->count() > 0 || $blogs->count() > 12)
                @include('frontend.pages.layouts.partials.pagination', ['paginator' => $blogs])
            @endif
        </div>
    </section>
@endsection

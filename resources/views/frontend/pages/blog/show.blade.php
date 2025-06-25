@extends('frontend.pages.layouts.app')

@section('content')
    <!-- Hero Banner -->
    <section class="py-6 bg-dark text-white position-relative"
             style="background: url('{{ asset('assets/images/parallax/17.jpg') }}') center center / cover no-repeat;">
        <div class="container text-center py-5">
            <h1 class="display-4 fw-bold mb-2" data-animate="animate__fadeInDown">{{ $blog->title }}</h1>
            <p class="lead mb-0" data-animate="animate__fadeInUp">Blog / {{ $blog->title }}</p>
        </div>
        <div class="overlay bg-black opacity-50 position-absolute top-0 start-0 w-100 h-100"></div>
    </section>

    <!-- Blog Content -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- Blog Image -->
                    @if ($blog->thumbnail)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                                 class="img-fluid rounded shadow">
                        </div>
                    @endif

                <!-- Meta Info -->
                    <div class="d-flex justify-content-center text-muted mb-3 small">
                        <div>
                            <i class="fa fa-calendar me-1"></i> {{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('F j, Y') : 'Unpublished' }}
                        </div>
                        <div class="mx-3">|</div>
                        <div><i class="fa fa-user me-1"></i> {{ $blog->user->name ?? 'Admin' }}</div>
                    </div>

                    <!-- Blog Title -->
                    <h2 class="fw-bold text-center mb-4">{{ $blog->title }}</h2>

                    <!-- Blog Excerpt -->
                    @if ($blog->excerpt)
                        <p class="lead text-center text-secondary mb-5">{{ $blog->excerpt }}</p>
                @endif

                <!-- Blog Full Content -->
                    <div class="blog-content fs-5 lh-lg text-dark">
                        {!! $blog->content !!}
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-light py-5 border-top mt-5">
        <div class="container text-center">
            <h3 class="fw-bold">Enjoyed this post?</h3>
            <p class="mb-4">Check out more insights, guides, and stories on our blog.</p>
            <a href="{{ route('rv-park.home') }}" class="btn btn-primary px-4 py-2">Explore More Blogs</a>
        </div>
    </section>
@endsection

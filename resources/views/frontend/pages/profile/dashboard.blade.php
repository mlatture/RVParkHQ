@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="assets/images/parallax/5.jpg">
        <div class="container">
            <div class="page-title text-white text-center">
                <h1 class="display-4 fw-bold">Welcome, {{ Auth::user()->name }}</h1>
                <p class="lead">Manage your favorite parks and personal information here.</p>
            </div>
            <div class="breadcrumb text-white-50 text-center mt-2">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="{{ route('rv-park.home') }}" class="text-white">Home</a></li>
                    <li class="list-inline-item">Dashboard</li>
                </ul>
            </div>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center fw-semibold">Your Account</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <a href="{{ route('rv-park.profile.favourites') }}" class="text-decoration-none">
                                    <div class="p-4 border rounded-4 h-100 hover-shadow bg-light text-dark text-center transition">
                                        <i class="bi bi-heart-fill fs-2 text-danger mb-2"></i>
                                        <h6 class="mb-0 fw-bold">My Favourites</h6>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="#modalProfileEdit" data-lightbox="inline" class="text-decoration-none">
                                    <div class="p-4 border rounded-4 h-100 hover-shadow bg-light text-dark text-center transition">
                                        <i class="bi bi-person-lines-fill fs-2 text-primary mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Edit Profile</h6>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('rv-park.profile.cards') }}" class="text-decoration-none">
                                    <div class="p-4 border rounded-4 h-100 hover-shadow bg-light text-dark text-center transition">
                                        <i class="bi bi-heart-fill fs-2 text-danger mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Payment Method</h6>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('rv-park.profile.bill') }}" class="text-decoration-none">
                                    <div class="p-4 border rounded-4 h-100 hover-shadow bg-light text-dark text-center transition">
                                        <i class="bi bi-heart-fill fs-2 text-danger mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Payment History</h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            background-color: #f8f9fa;
        }

        .transition {
            transition: all 0.3s ease-in-out;
        }
    </style>
@endsection

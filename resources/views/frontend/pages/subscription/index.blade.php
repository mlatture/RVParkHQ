@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="assets/images/parallax/5.jpg">
        <div class="container">
            <div class="page-title">
                <h1>Complete Your Subscription</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Subscription Confirmation</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h3 class="text-uppercase">Confirm Your Details</h3>
                    <p>Please provide your name and ZIP code to complete your subscription.</p>

                    <div class="m-t-30">
                        <form action="{{ route('rv-park.confirm-subscribe.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ request()->get('token') }}">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ $pending->email }}" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                            </div>

                            <div class="form-group">
                                <label for="zip_code">ZIP Code</label>
                                <input type="text" name="zip_code" class="form-control" placeholder="Enter your ZIP code" required>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check-circle"></i> Confirm Subscription
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

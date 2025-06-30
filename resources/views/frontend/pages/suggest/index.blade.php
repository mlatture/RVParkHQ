@extends('frontend.pages.layouts.app')

@section('content')
    @php
        use Illuminate\Support\Str;
        $location = request()->query('country') ?? request()->query('state') ?? request()->query('city');
    @endphp
    <section id="page-title" class="text-light" data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>Suggest a Parks</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Suggest a Parks</li>
                </ul>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row card p-4 shadow-md rounded-lg border border-light">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3 class="text-uppercase">Suggest a Park</h3>
                    </div>

                    <div class="mt-4">
                        <form id="review-form" method="POST" action="{{ route('rv-park.suggest.park.store') }}">
                        @csrf

                        <!-- 🧾 Basic Information -->
                            <h5 class="fw-semibold mb-3 mt-3">🧾 Basic Information</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="park_name">Park Name <span class="text-danger">*</span></label>
                                    <input type="text" name="park_name" required class="form-control @error('park_name') is-invalid @enderror" placeholder="Enter Park Name">
                                    @error('park_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" required class="form-control @error('city') is-invalid @enderror" placeholder="Enter City">
                                    @error('city') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="state">State / Province <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" placeholder="Enter state or province" required>
                                    @error('state') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="USA" required>
                                    @error('country') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="zip">ZIP / Postal Code</label>
                                    <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" placeholder="ZIP Code (optional)">
                                    @error('zip') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- 🌐 Online Presence -->
                            <h5 class="fw-semibold mb-3 mt-5">🌐 Online Presence</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="website_url">Website URL</label>
                                    <input type="url" name="website_url" class="form-control" placeholder="https://example.com">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="social_url">Facebook or Instagram URL</label>
                                    <input type="url" name="social_url" class="form-control" placeholder="https://facebook.com/page">
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@email.com">
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+1 123 456 7890">
                                </div>
                            </div>

                            <!-- 👤 User Info -->
                            <h5 class="fw-semibold mb-3 mt-5">👤 Your Info</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="user_name">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="user_name" class="form-control" placeholder="Your Full Name" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="user_email">Your Email <span class="text-danger">*</span></label>
                                    <input type="email" name="user_email" class="form-control" placeholder="you@example.com" required>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button class="btn btn-dark" type="submit" id="form-submit">
                                    <i class="fa fa-paper-plane"></i>&nbsp;Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

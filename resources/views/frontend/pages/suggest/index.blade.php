@extends('frontend.pages.layouts.app')

@section('content')
    
    <section id="page-title" class="text-light" data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>Suggest a Park</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active">Suggest a Park</li>
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

                                <div class="form-group col-md-6">
                                    <label for="submitted_by">Submitted By <span class="text-danger">*</span></label>
                                    <select class="form-select" id="submitted_by" name="submitted_by" required>
                                        <option value="" selected disabled>-- Select Submitter --</option>
                                        <option value="park_owner">Park Owner</option>
                                        <option value="guest">Guest</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <h5 class="fw-semibold mb-3 mt-3">🧾 Park Info</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="park_name">Park Name <span class="text-danger">*</span></label>
                                    <input type="text" name="park_name" required class="form-control @error('park_name') is-invalid @enderror" placeholder="Enter Park Name">
                                    @error('park_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">Website Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@email.com">
                                    @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address_line_1">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="address_line_1" id="address_line_1" required class="form-control @error('address_line_1') is-invalid @enderror" placeholder="Enter Address Line 1">
                                    @error('address_line_1') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address_line_1">Address Line 2</label>
                                    <input type="text" name="address_line_2" id="address_line_2" required class="form-control @error('address_line_2') is-invalid @enderror" placeholder="Enter Address Line 1">
                                    @error('address_line_2') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" required class="form-control @error('city') is-invalid @enderror" placeholder="Enter City">
                                    @error('city') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="state">State / Province <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" placeholder="Enter state or province" required>
                                    @error('state') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="zip">ZIP / Postal Code</label>
                                    <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" placeholder="ZIP Code (optional)">
                                    @error('zip') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="website_url">Website URL</label>
                                    <input type="url" name="website_url" class="form-control" placeholder="https://example.com">
                                </div>

                                <div class="form-group col-md-6 mt-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+1 123 456 7890">
                                </div>

                                <div class="form-group col-md-12 mt-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Enter any additional park information or notes here..." rows="4"></textarea>
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
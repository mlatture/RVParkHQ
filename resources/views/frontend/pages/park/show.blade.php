@extends('frontend.pages.layouts.app')

@section('content')
    <style>
        .star-rating {
            direction: rtl;
            font-size: 2.5rem; /* Increased from 1.5rem to 2.5rem */
            unicode-bidi: bidi-override;
            display: inline-flex;
            gap: 0.2rem;
        }
        
        .star-rating input[type="radio"] {
            display: none;
        }
        
        .star-rating label {
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f5b301;
        }

    </style>

    <section id="page-title" class="text-light" data-bg-parallax="images/parallax/6.jpg">
        <div class="container">
            <div class="page-title">
                <h1>{{ ucfirst($parks->name) }}</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li>{{ request()->segment(1) }}</li>
                    <li>{{ ucfirst(request()->segment(2)) }}</li>
                    <li>{{ ucfirst(request()->segment(3)) }}</li>
                    <li>{{ ucfirst(request()->segment(4)) }}</li>
                    <li>{{ ucfirst(request()->segment(5)) }}</li>
                    <li>{{ ucfirst(request()->segment(6)) }}</li>
                </ul>
            </div>
        </div>
    </section>
    <section id="product-page" class="product-page p-b-0">
        <div class="container">
            <div class="product">
                <div class="row m-b-40">
                    <div class="col-lg-5">
                        <div class="product-image">
                            @php
                                $imagePath = $parks->main_image_url;
                                if (!empty($imagePath)) {
                                    $imageUrl = preg_match('/^https?:\/\//', $imagePath)
                                        ? $imagePath
                                        : asset('storage/' . $imagePath);
                                } else {
                                    $imageUrl = asset('images/login.jpg');
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" onerror="this.onerror=null;this.src='{{ asset('images/login.jpg') }}';" alt="Park Image" />
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-title">
                            <h3>
                                {{ ucfirst($parks->name) }} <small>({!! strip_tags($parks->short_description, '<b><i><u>') !!})</small>
                            </h3>
                        </div>
                        <div class="seperator m-b-10"></div>
                        <div class="product-description">
                            <p>{!! $parks->description !!}</p>    
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product additional tabs -->
            <div class="tabs tabs-folder">
                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="additional-tab" data-bs-toggle="tab" href="#additional" role="tab"
                           aria-controls="additional" aria-selected="true">
                            <i class="fa fa-info"></i>Additional Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab"
                           aria-controls="reviews" aria-selected="false">
                            <i class="fa fa-star"></i>Reviews
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent3">
                    <div class="tab-pane fade active show" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                        <table class="table table-responsive">
                            <tbody>
                                <tr><td class="fw-bold">Country</td><td>{{ $parks->country }}</td></tr>
                                <tr><td class="fw-bold">City</td><td>{{ $parks->city }}</td></tr>
                                <tr><td class="fw-bold">State</td><td>{{ $parks->state }}</td></tr>
                                <tr><td class="fw-bold">Address</td><td>{{ $parks->address }}</td></tr>
                                <tr><td class="fw-bold">Postal Code</td><td>{{ $parks->postal_code }}</td></tr>
                                <tr><td class="fw-bold">Latitude</td><td>{{ $parks->latitude }}</td></tr>
                                <tr><td class="fw-bold">Longitude</td><td>{{ $parks->longitude }}</td></tr>
                                <tr><td class="fw-bold">Phone</td><td>{{ $parks->phone }}</td></tr>
                                <tr><td class="fw-bold">Email</td><td>{{ $parks->email }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="comments" id="comments">
                            <div class="comment_number">
                                Reviews <span>(3)</span>
                            </div>
                            <div class="comment-list">
                                <div class="comment" id="comment-1">
                                    <div class="image"><img alt="" src="{{ asset('assets/images/blog/author.jpg') }}" class="avatar"></div>
                                    <div class="text">
                                        <h5 class="name">John Doe</h5>
                                        <span class="comment_date">Posted at 15:32h, 06 December</span>
                                        <div class="text_holder">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row card p-4 shadow-lg rounded-lg border border-light">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3 class="text-uppercase">Add Review</h3>
                        <p>Trusted feedback from our community to help you plan the perfect stay.</p>
                    </div>

                    <div class="m-t-30">
                        <form id="review-form" method="POST" action="{{ route('rv-park.add-review') }}">
                            @csrf
                            <input type="hidden" name="park_id" value="{{ $parks->id }}">
                        
                            <div class="form-group mt-3">
                                <label for="rating">Your Rating *</label>
                                <div class="star-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                                        <label for="star{{ $i }}" title="{{ $i }} stars">&#9733;</label>
                                    @endfor
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name *</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter your Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" required class="form-control" placeholder="Enter your Email">
                                </div>
                            </div>
                        
                            <div class="form-group mt-3">
                                <label for="message">Describe Your Feedback *</label>
                                <textarea name="message" rows="5" class="form-control" required placeholder="Enter your Message"></textarea>
                            </div>
                        
                            <button class="btn btn-secondary mt-3" type="submit" id="form-submit">
                                <i class="fa fa-paper-plane"></i>&nbsp;Submit
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#review-form').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let actionUrl = form.attr('action');
            let submitBtn = $('#form-submit');

            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    form[0].reset();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    return;
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (errors) {
                        let errorList = Object.values(errors).flat().join("\n");
                        alert("Please fix the following errors:\n" + errorList);
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },
                complete: function () {
                    submitBtn.html('<i class="fa fa-paper-plane"></i> Submit').prop('disabled', false);
                }
            });
        });
    </script>

@endsection

@extends('frontend.pages.layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        justify-content: flex-start;
        gap: 0.3rem;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 1.75rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107;
    }

    .review-helper-text {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 0.4rem;
    }
    
    .additional-info-table {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .additional-info-table td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    .additional-info-table tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .info-label {
        font-weight: 600;
        color: #333;
        width: 180px;
    }

    .info-value {
        color: #555;
    }

    .info-icon {
        width: 1.2rem;
        margin-right: 8px;
        color: #ffc107;
    }
    
    .reviews-wrapper {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .review-header {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 25px;
        color: #333;
    }

    .review-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #ffc107;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .review-card .avatar {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }

    .review-meta {
        font-size: 0.875rem;
        color: #777;
    }

    .review-message {
        font-size: 1rem;
        color: #444;
    }

    .star-rating span {
        font-size: 1.2rem;
    }
</style>
@section('content')
    <section id="page-title" class="text-light" data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
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
                            <i class="fa fa-star"></i>Reviews ({{ $reviews->count() }})
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent3">
                    <div class="tab-pane fade active show" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                        <div class="table-responsive">
                            <table class="table additional-info-table">
                                <tbody>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-flag info-icon"></i>Country</td>
                                        <td class="info-value">{{ $parks->country }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-city info-icon"></i>City</td>
                                        <td class="info-value">{{ $parks->city }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-map-marker-alt info-icon"></i>State</td>
                                        <td class="info-value">{{ $parks->state }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-map info-icon"></i>Address</td>
                                        <td class="info-value">{{ $parks->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-mail-bulk info-icon"></i>Postal Code</td>
                                        <td class="info-value">{{ $parks->postal_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-globe info-icon"></i>Latitude</td>
                                        <td class="info-value">{{ $parks->latitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-globe info-icon"></i>Longitude</td>
                                        <td class="info-value">{{ $parks->longitude }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-phone info-icon"></i>Phone</td>
                                        <td class="info-value">{{ $parks->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label"><i class="fas fa-envelope info-icon"></i>Email</td>
                                        <td class="info-value">{{ $parks->email }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="comments reviews-wrapper" id="comments">
                            <div class="review-header">
                                {{ $reviews->count() ? 'What Campers Are Saying' : 'No Reviews Yet' }}
                                <span class="text-muted" style="font-size: 1rem;"></span>
                            </div>
                        
                            @if ($reviews && $reviews->count())
                                <div class="comment-list">
                                    @foreach ($reviews as $review)
                                        <div class="review-card d-flex align-items-start">
                                            <div class="me-3">
                                                <img alt="Avatar" src="{{ asset('assets/images/clients/' . rand(1, 10) . '.png') }}" class="avatar">
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $review->name }}</h6>
                                                <div class="review-meta mb-1">Posted by {{ $review->email }} on {{ $review->created_at->format('F j, Y \\a\\t g:i A') }}</div>
                                                <div class="star-rating mb-2 d-inline-block" style="direction: ltr;">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <span style="color: #ffc107">&#9733;</span>
                                                        @else
                                                            <span style="color: #e0e0e0">&#9733;</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="review-message mb-0">{{ $review->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No reviews yet. Be the first to support this park with a review and help it shine in the RVParkHQ Excellence Awards!</p>
                            @endif
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
                        <h3 class="text-uppercase">Support This Park with a Review</h3>
                        <p>Support your favorite parks with your review — and help them earn a place among the best in the RVParkHQ community.</p>
                    </div>

                    <div class="m-t-30">
                        <form id="review-form" method="POST" action="{{ route('rv-park.add-review') }}">
                            @csrf
                            <input type="hidden" name="park_id" value="{{ $parks->id }}">

                            <div class="form-group mt-4">
                                <label for="rating" class="form-label fw-bold">Rate This Park <span class="text-danger">*</span></label>
                                <div class="star-rating mb-2">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                                        <label for="star{{ $i }}" title="{{ $i }} star{{ $i > 1 ? 's' : '' }}">&#9733;</label>
                                    @endfor
                                </div>
                                <div class="review-helper-text">
                                    🌟 Your review helps this park earn a spot in the annual <strong>RVParkHQ Excellence Awards</strong>.
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter your Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" required class="form-control" placeholder="Enter your Email">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="message">Describe Your Feedback <span class="text-danger">*</span></label>
                                <textarea name="message" rows="5" class="form-control" required placeholder="Enter your Message"></textarea>
                            </div>

                            <div class="form-group mt-3 text-start">
                                <small class="text-dark">
                                    By submitting your vote, you agree to receive occasional emails from RVParkHQ with camping tips, special offers, and nearby park promotions. Unsubscribe anytime.
                                </small>
                            </div>
                            <button class="btn btn-dark mt-1" type="submit" id="form-submit">
                                <i class="fa fa-paper-plane"></i>&nbsp;Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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
                    return Swal.fire({
                      title: '🎊 Hurrah!',
                      text: response.message,
                      icon: 'success',
                      position: 'top-end',
                      timerProgressBar: true,
                      timer: 4000,
                      showConfirmButton: false,
                      showClass: {
                        popup: 'animate__animated animate__bounceIn'
                      },
                      hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                      }
                    });
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

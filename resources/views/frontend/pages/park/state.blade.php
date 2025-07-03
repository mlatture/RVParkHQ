@extends('frontend.pages.layouts.app')

@section('content')

    <style>
        .state-item .state-pin svg {
            transition: transform 0.3s cubic-bezier(.32,2,.55,.27), filter 0.2s;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.10));
        }
        .state-item a:hover .state-pin svg,
        .state-item a:focus .state-pin svg {
            transform: translateY(-4px) scale(1.12);
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.18));
        }
        .state-item a {
            transition: box-shadow 0.2s, border-color 0.2s, background 0.2s;
            box-shadow: 0 2px 6px rgba(80,80,100,0.06);
            background: rgba(255,255,255,0.95);
        }
        .state-item a:hover,
        .state-item a:focus {
            border-color: #222 !important;
            background: rgba(245,245,250,0.97);
            box-shadow: 0 6px 24px rgba(60,60,90,0.11);
            outline: 2px solid #333;
            outline-offset: 2px;
        }
    </style>
    
    <section id="page-title" class="text-light"
             data-bg-parallax="{{asset('assets/images/slider/revolution/polo-homepage/dummy.png')}}">
        <div class="container">
            <div class="page-title">
                <h1>Browse by state</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li>{{ request()->segment(1) }}</li>
                    <li>{{ request()->segment(2) }}</li>
                    @if(request()->segment(3))
                        <li class="active">{{ request()->segment(3) }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
    
    <section id="page-content">
        <div>
            <div class="row m-b-20 justify-content-center">
                <div class="col-lg-6 p-t-10 m-b-20 text-center">
                    <strong>Discover a variety of parks perfect for your next getaway. Browse locations, explore
                        amenities, and find the ideal spot to relax, camp, or adventure.</strong>
                </div>
            </div>
            <div id="filter-section">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="p-2">
                            <div class="state-grid mt-1" id="stateContainer">
                                <div class="row g-2">
                                    @foreach ($states as $slug)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 state-item"
                                             data-state="{{ strtolower($slug->state) }}">
                                            <a href="{{ url('/en-us/parks/usa/'.$slug->state) }}"
                                               class="d-block text-decoration-none p-1 rounded-3 fw-semibold shadow-sm transition-all text-dark"
                                               style="background-color: rgba(255,255,255,0.90); border: 2px solid {{ !empty($slug->color) ? $slug->color : '#6c757d' }};"
                                               tabindex="0">
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="mb-1 state-pin" style="width:38px; height:38px;">
                                                        <svg width="34" height="38" viewBox="0 0 34 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <ellipse cx="17" cy="14" rx="10" ry="10" fill="{{ $slug->color ?? '#6c757d' }}" />
                                                            <path d="M17 38C17 38 31 22.2 31 14C31 6.268 24.732 0 17 0C9.268 0 3 6.268 3 14C3 22.2 17 38 17 38Z"
                                                                  fill="{{ $slug->color ?? '#6c757d' }}" fill-opacity="0.25"/>
                                                            <circle cx="17" cy="14" r="5" fill="#fff" fill-opacity="0.85"/>
                                                        </svg>
                                                    </div>
                                                    <span class="pt-1">{{ $slug->state }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

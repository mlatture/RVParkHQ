@extends('frontend.pages.layouts.app')

@section('content')
    <section class="parallax text-light halfscreen" data-bg-parallax="assets/images/parallax/17.jpg">
        <div class="container">
            <div class="container-fullscreen">
                <div class="text-middle text-center text-end">
                    <h1 class="text-uppercase text-medium" data-animate="animate__fadeInDown" data-animate-delay="100">About US
                    </h1>
                    <p class="lead" data-animate="animate__fadeInDown" data-animate-delay="300">RV Park / About US</p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row  m-b-50">
                <div class="col-lg-3">
                    <div class="heading-text heading-section">
                        <h2>ABOUT ME</h2>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">The most happiest time of the day!. Morbi sagittis, sem quis lacinia faucibus, orci ipsum gravida tortor, vel interdum mi sapien ut justo. Nulla varius consequat magna, id molestie ipsum volutpat quis. A true story, that never
                            been told!. Fusce id mi diam, non ornare orci. Pellentesque ipsum erat,
                            <br>
                            <br> facilisis ut venenatis eu, sodales vel dolor. The most happiest time of the day!. Morbi sagittis, sem quis lacinia faucibus, orci ipsum gravida tortor, vel interdum mi sapien ut justo. Nulla varius consequat magna,
                            id molestie ipsum volutpat quis. A true story, that never been told!. Fusce id mi diam, non ornare orci. Pellentesque ipsum erat, facilisis ut venenatis eu, sodales vel dolor. </div>
                        <div class="col-lg-6">Pellentesque ipsum erat, facilisis ut venenatis eu, sodales vel dolor. The most happiest time of the day!. Morbi sagittis, sem quis lacinia faucibus, orci ipsum gravida tortor, vel interdum mi sapien ut justo. Nulla varius
                            consequat magna, id molestie ipsum volutpat quis. A true story, that never been told!. Fusce id mi diam, non ornare orci. Pellentesque ipsum erat, facilisis ut venenatis eu, sodales vel dolor. Pellentesque ipsum erat, facilisis
                            ut venenatis eu, sodales vel dolor.
                            <br>
                            <br>The most happiest time of the day!. Morbi sagittis, sem quis lacinia faucibus, orci ipsum gravida tortor, vel interdum mi sapien ut justo. Nulla varius consequat magna, id molestie ipsum volut.</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="heading-text heading-section m-b-20">
                        <h2>My Skills</h2>
                    </div>Lorem ipsum dolor sit ametusp endisse consectetur fringilla luctus. Fusce id mi diam, non ornare orci. Pellentesque ipsum erat,
                </div>
                <div class="col-lg-9">
                    <div class="m-t-60">
                        <div class="p-progress-bar-container title-up small extra-small color">
                            <div class="p-progress-bar" data-percent="100" data-delay="100" data-type="%">
                                <div class="progress-title">HTML5</div>
                            </div>
                        </div>
                        <div class="p-progress-bar-container title-up small extra-small color">
                            <div class="p-progress-bar" data-percent="94" data-delay="200" data-type="%">
                                <div class="progress-title">CSS3</div>
                            </div>
                        </div>
                        <div class="p-progress-bar-container title-up small extra-small color">
                            <div class="p-progress-bar" data-percent="78" data-delay="300" data-type="%">
                                <div class="progress-title">JQUERY</div>
                            </div>
                        </div>
                        <div class="p-progress-bar-container title-up small extra-small color">
                            <div class="p-progress-bar" data-percent="65" data-delay="400" data-type="%">
                                <div class="progress-title">MYSQL</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="no-padding">
        <!-- Portfolio -->
        <div id="portfolio" class="grid-layout portfolio-5-columns" data-margin="0">
            <!-- portfolio item -->
            <div class="portfolio-item no-overlay ct-photography ct-media ct-branding ct-Media ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-slider">
                        <div class="carousel dots-inside dots-dark arrows-dark" data-items="1" data-loop="true" data-autoplay="true" data-animate-in="fadeIn" data-animate-out="fadeOut" data-autoplay="1500">
                            <a href="#"><img src="images/portfolio/64.jpg" alt=""></a>
                            <a href="#"><img src="images/portfolio/70.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-photography ct-marketing ct-media">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/60.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a title="Paper Pouch!" data-lightbox="image" href="images/portfolio/83l.jpg"><i class="icon-maximize"></i></a>
                        <a href="portfolio-page-grid-gallery.html"><i class="icon-link"></i></a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item large-width  img-zoom ct-photography ct-media ct-branding ct-Media">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/61.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a href="portfolio-page-grid-gallery.html">
                            <h3>Let's Go Outside</h3>
                            <span>Illustrations / Graphics</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item overlay-light img-zoom ct-photography ct-media ct-branding ct-Media ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-slider">
                        <div class="carousel dots-inside arrows-dark dots-dark" data-items="1" data-loop="true" data-autoplay="true" data-autoplay="1800">
                            <a href="#"><img src="images/portfolio/22.jpg" alt=""></a>
                            <a href="#"><img src="images/portfolio/23.jpg" alt=""></a>
                            <a href="#"><img src="images/portfolio/24.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="portfolio-description">
                        <a href="portfolio-page-grid-gallery.html">
                            <h3>Stockholm Fashion</h3>
                            <span>Illustrations / Graphics</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-photography ct-media ct-branding ct-marketing ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/65.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description" data-lightbox="gallery">
                        <a title="Photoshop Mock-up!" data-lightbox="gallery-image" href="images/portfolio/80l.jpg"><i class="icon-copy"></i></a>
                        <a title="Paper Pouch!" data-lightbox="gallery-image" href="images/portfolio/81l.jpg" class="hidden"></a>
                        <a title="Mock-up" data-lightbox="gallery-image" href="images/portfolio/82l.jpg" class="hidden"></a>
                        <a href="portfolio-page-grid-gallery.html"><i class="icon-link"></i></a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-marketing ct-media ct-branding ct-marketing ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/66.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a href="portfolio-page-grid-gallery.html">
                            <h3>Last Iceland Sunshine</h3>
                            <span>Graphics</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-photography ct-media ct-branding ct-marketing ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/67.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a title="Paper Pouch!" data-lightbox="iframe" href="https://www.youtube.com/watch?v=k6Kly58LYzY"><i class="icon-play"></i></a>
                        <a href="portfolio-page-grid-gallery.html"><i class="icon-link"></i></a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item no-overlay ct-photography ct-media ct-branding ct-Media ct-marketing ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-slider">
                        <div class="carousel dots-inside dots-dark arrows-dark" data-items="1" data-loop="true" data-autoplay="true" data-animate-in="fadeIn" data-animate-out="fadeOut" data-autoplay="1500">
                            <a href="#"><img src="images/portfolio/68.jpg" alt=""></a>
                            <a href="#"><img src="images/portfolio/71.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-photography ct-marketing ct-media">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/69.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a href="portfolio-page-grid-gallery.html">
                            <h3>Luxury Wine</h3>
                            <span>Graphics / Branding</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-marketing ct-media ct-branding ct-marketing ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/70.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a href="portfolio-page-grid-gallery.html">
                            <h3>Last Iceland Sunshine</h3>
                            <span>Graphics</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
            <!-- portfolio item -->
            <div class="portfolio-item img-zoom ct-photography ct-media ct-branding ct-marketing ct-webdesign">
                <div class="portfolio-item-wrap">
                    <div class="portfolio-image">
                        <a href="#"><img src="images/portfolio/72.jpg" alt=""></a>
                    </div>
                    <div class="portfolio-description">
                        <a href="portfolio-page-grid-gallery.html">
                            <h3>Towel World</h3>
                            <span>Graphics</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- end: portfolio item -->
        </div>
        <!-- end: Portfolio -->
    </section>
    <hr class="space">
    <hr class="space">
    <div class="call-to-action cta-center">
        <div class="col-lg-10">
            <h3>Ready to buy RV Park Template?</h3>
            <p>This is a simple hero unit, a simple call-to-action-style component for calling extra attention to featured content.</p>
        </div>
        <div class="col-lg-2">
            <a class="btn btn-primary" href="#">Buy now!</a> </div>
    </div>
    <hr class="space">
@endsection

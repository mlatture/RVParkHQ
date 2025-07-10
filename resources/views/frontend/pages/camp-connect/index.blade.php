@extends('frontend.pages.layouts.app')

@section('content')
    <section id="page-title" data-bg-parallax="assets/images/parallax/5.jpg">
        <div class="container">
            <div class="page-title">
                <h1>Camp Connect</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                    <li class="active"><a href="#">Camp Connect</a></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Introduction Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">🌄 Automated Email That Keeps Your Campers Coming Back</h2>
            <p class="lead text-center mb-0">CampConnect is your park’s built-in newsletter system — included in all WebDaVinci Flow plans $99/month and up,<br> or available separately for $99/month per 1,000 subscribers.</p>
        </div>
    </section>

    <!-- What It Does -->
    <section class="py-5 bg-white">
        <div class="container">
            <h3 class="fw-bold mb-3">📬 What It Does</h3>
            <p>CampConnect sends a personalized, professional weekly email to your past and future guests — without you lifting a finger. Designed specifically for campgrounds, it keeps your customers informed, engaged, and coming back for more.</p>
        </div>
    </section>

    <!-- Email Contents -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center fw-bold mb-5">💡 What’s Inside Each Email</h3>
            <div class="row g-4">
                @foreach($features as $feature)
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 border rounded bg-white shadow-sm h-100">
                            <h5 class="fw-semibold text-primary">{{ $feature['title'] }}</h5>
                            <p class="mb-0">{{ $feature['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why It Works -->
    <section class="py-5 bg-white">
        <div class="container">
            <h3 class="text-center fw-bold mb-5">🧠 Why It Works</h3>
            <div class="row g-4">
                @foreach($benefits as $benefit)
                    <div class="col-md-6">
                        <div class="p-4 border rounded bg-light h-100">
                            <h5 class="text-success fw-bold">{{ $benefit[0] }}</h5>
                            <p class="mb-0">{{ $benefit[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
        <div class="container">
            <h3 class="fw-bold mb-3">🚀 Ready to Get Started?</h3>
            <p class="mb-2 fs-5">CampConnect is included in all WebDaVinci Flow packages <strong>$99 and up</strong> — or you can subscribe separately.</p>
            <p class="mb-4">Contact your sales rep or email <a href="mailto:flow@webdavinci.com" class="text-white fw-bold text-decoration-underline">flow@webdavinci.com</a></p>
            <div class="p-countdown-show"><a href="#CampConnect" data-lightbox="inline" class="btn btn-dark btn-lg px-5 py-2 rounded-pill shadow-sm">📧 Preview a CampConnect Newsletter</a></div>
        </div>
        <div id="CampConnect" class="modal no-padding" data-delay="3000" style="max-width: 780px;">
            <div class="modal-dialog modal-dialog-centered modal-xl p-3">
                <div class="klc-newsletter-wrapper border-0 rounded-3 shadow-lg">

                    <div class="klc-header">
                        <span class="sun-icon">☀️</span>
                        <h4 class="fw-bold">🌲 Kayuta Lake Campground</h4>
                        <p class="mb-1">🌞 July Newsletter · By WebDaVinci Flow</p>
                        <small class="opacity-75">Stay updated with events, weather, rewards & more!</small>
                    </div>

                    <div class="modal-body px-0 py-0 bg-light">
                        <div class="bg-white p-4 rounded-3">

                            <div class="klc-content-section pb-3">
                                <h5 class="fw-semibold">👋 Hello Sarah, Your Next Adventure Awaits!</h5>
                                <p class="mb-2 small">
                                    June was incredible! We celebrated Father's Day with over 150 families at our BBQ Bash, had a blast at the Carnival (think face painting, dunk tank, and cotton candy galore!), and roasted a whopping 2,300 marshmallows by the nightly bonfires! 🔥
                                </p>
                                <div class="klc-highlight-card">
                                    📸 Share your moments with **#KayutaLakeCampground** for a chance to be featured in our next newsletter!
                                </div>
                            </div>

                            <div class="klc-content-section pb-3">
                                <h5 class="fw-semibold">🎉 What's Brewing This Month</h5>
                                <ul class="small mb-3 klc-event-list list-unstyled ps-3">
                                    <li><strong><i class="fas fa-sparkles text-warning me-2"></i>July 6–7:</strong> <span class="fw-bold">Stars & S’mores Weekend</span> – Experience dazzling fireworks and communal roasts under the starry sky.</li>
                                    <li><strong><i class="fas fa-paint-roller text-info me-2"></i>July 13:</strong> <span class="fw-bold">Kayuta Color Splash</span> – Don your white clothes for our vibrant color run! It's messy fun for everyone.</li>
                                    <li><strong><i class="fas fa-chili text-danger me-2"></i>July 20:</strong> <span class="fw-bold">Chili Cookoff & Cornhole Tournament</span> – Bring your best chili recipe and challenge your friends to cornhole. Prizes await!</li>
                                </ul>
                                <div class="text-end">
                                    <button class="btn btn-sm klc-btn-primary">Book Your Spot Now <i class="fas fa-arrow-right ms-2"></i></button>
                                </div>
                            </div>

                            <div class="klc-content-section pb-3">
                                <h5 class="fw-semibold">🌤️ Your Kayuta Lake Forecast: Forestport, NY</h5>
                                <div class="klc-weather-card">
                                    <div class="klc-weather-item">
                                        <span class="icon">🌞</span>
                                        <p class="mb-0 small">Mon</p>
                                        <p class="fw-bold mb-0">81°F</p>
                                        <small class="text-muted">Mostly sunny</small>
                                    </div>
                                    <div class="klc-weather-item">
                                        <span class="icon">🌤️</span>
                                        <p class="mb-0 small">Tue</p>
                                        <p class="fw-bold mb-0">78°F</p>
                                        <small class="text-muted">Partly cloudy</small>
                                    </div>
                                    <div class="klc-weather-item">
                                        <span class="icon">🌧️</span>
                                        <p class="mb-0 small">Wed</p>
                                        <p class="fw-bold mb-0">74°F</p>
                                        <small class="text-muted">Thunderstorms</small>
                                    </div>
                                    <div class="klc-weather-item">
                                        <span class="icon">🌤️</span>
                                        <p class="mb-0 small">Thu</p>
                                        <p class="fw-bold mb-0">77°F</p>
                                        <small class="text-muted">Clearing</small>
                                    </div>
                                    <div class="klc-weather-item">
                                        <span class="icon">☀️</span>
                                        <p class="mb-0 small">Fri</p>
                                        <p class="fw-bold mb-0">83°F</p>
                                        <small class="text-muted">Perfect lake day!</small>
                                    </div>
                                </div>
                                <small class="text-muted mt-3 d-block text-center">🌧️ Add the **Sensible Weather Guarantee** at checkout – full refund if it rains!</small>
                            </div>

                            <div class="klc-content-section klc-reward-card">
                                <h6 class="fw-bold mb-2">🏕️ Your Exclusive Campfire Club Reward!</h6>
                                <p class="small mb-2">🎁 It's been a year since your last cozy visit – we've missed you! As a valued Campfire Club member, enjoy a **FREE night** on your next 2-night booking with us.</p>
                                <p class="mb-2">Your special code:</p>
                                <div class="code-display mb-3"><code>FREE1NIGHT-XZ24</code></div>
                                <p class="mb-0 small text-muted">Valid through: July 15, 2025</p>
                                <div class="text-end">
                                    <button class="btn btn-sm klc-btn-reward">Redeem Your Free Night <i class="fas fa-gift ms-2"></i></button>
                                </div>
                            </div>

                            <div class="klc-content-section klc-tip-section">
                                <h5 class="fw-semibold">🔥 Camp Life Hack: Campfire Quesadillas!</h5>
                                <p class="small mb-2">Elevate your campfire cooking with delicious **campfire quesadillas**! Simply fill tortillas with your favorite cheese, beans, and veggies. Wrap them tightly in foil and cook 5–7 minutes per side over hot coals until melted and crispy.</p>
                                <small class="text-muted">🧀 **Pro Tip:** Use non-stick foil or a piece of parchment paper inside the foil to prevent sticking and make cleanup a breeze!</small>
                            </div>

                            <div class="klc-content-section klc-partner-section">
                                <h5 class="fw-semibold">🤝 Spotlight Partner: Adirondack RV Center</h5>
                                <p class="small mb-3">Looking to upgrade your ride or need parts? Our trusted partner, **Adirondack RV Center** in Utica, has you covered! They offer a wide selection of RVs, great trade-in options, and all the parts you'll need.</p>
                                <p class="small mb-3">This month, get **10% off all RV accessories**! Just show them this newsletter to redeem your discount.</p>
                                <button class="btn btn-sm btn-outline-primary">Visit Adirondack RV Center <i class="fas fa-external-link-alt ms-2"></i></button>
                            </div>

                            <hr class="my-4">
                            <footer class="text-center small text-muted">
                                <p class="mb-2 klc-footer-links">
                                    <a href="#">📩 View Online</a> | <a href="#">Unsubscribe</a> | <a href="#">Forward to a Friend</a>
                                </p>
                                <p class="mb-1">Stay Connected: Follow us on social media for daily updates!</p>
                                <p class="mb-3">
                                    <a href="#" class="text-muted mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#" class="text-muted mx-2"><i class="fab fa-instagram fa-lg"></i></a>
                                    <a href="#" class="text-muted mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                                </p>
                                <p class="mb-0">📱 Sign up for **text alerts** – receive only 1 per week with exclusive last-minute deals and updates!</p>
                            </footer>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


@endsection
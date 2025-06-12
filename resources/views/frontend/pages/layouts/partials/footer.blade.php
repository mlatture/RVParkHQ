<style>
    #footer {
        background: #1f1f1f;
        color: #fff;
        padding: 60px 0 20px;
    }

    #footer a {
        color: #fff;
        transition: all 0.3s ease;
    }

    #footer a:hover {
        color: #ffc107;
        text-decoration: none;
    }

    .footer-logo {
        font-size: 1.8rem;
        font-weight: bold;
        color: #fff;
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #fff;
    }

    .footer-content .list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-content .list li {
        margin-bottom: 10px;
    }

    .footer-social a {
        font-size: 1.3rem;
        margin-right: 15px;
        color: #fff;
    }

    .footer-social a:hover {
        color: #ffc107;
    }

    .footer-subscribe input[type="email"] {
        border: none;
        padding: 10px;
        border-radius: 3px 0 0 3px;
        width: 100%;
        max-width: 300px;
    }

    .footer-subscribe button {
        padding: 10px 16px;
        background: #ffc107;
        border: none;
        border-radius: 0 3px 3px 0;
        color: #000;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .footer-subscribe button:hover {
        background: #e0a800;
    }

    .copyright-content {
        background: #111;
        color: #ccc;
        padding: 15px 0;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .footer-subscribe {
            flex-direction: column;
            align-items: stretch;
        }

        .footer-subscribe input[type="email"],
        .footer-subscribe button {
            width: 100% !important;
            border-radius: 4px !important;
            margin-bottom: 10px;
        }

        .footer-social a {
            margin-right: 10px;
        }
    }
</style>

<footer id="footer">
    <div class="footer-content">
        <div class="container">
            <div class="row gy-5">
                <div class="col-md-4">
                    <div class="footer-logo">RVParkHQ</div>
                    <p class="mt-3 text-white">Built with passion for travelers and park owners.<br>Find the best RV parks, reviews, and tips in one place.</p>
                    <div class="footer-social mt-3">
                        <a href="#"><i class="fab fa-facebook-f text-white"></i></a>
                        <a href="#"><i class="fab fa-instagram text-white"></i></a>
                        <a href="#"><i class="fab fa-youtube text-white"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="widget">
                        <div class="widget-title">Quick Links</div>
                        <ul class="list text-white">
                            <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                            <li><a href="{{ route('rv-park.park') }}">Parks</a></li>
                            <li><a href="{{ route('rv-park.about') }}">About</a></li>
                            <li><a href="{{ route('rv-park.service') }}">Services</a></li>
                            <li><a href="{{ route('rv-park.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="widget">
                        <div class="widget-title">Subscribe for Camping Tips</div>
                        <p class="mb-3 text-white">Join our mailing list for top camping tips, exclusive discounts, and nearby park alerts.</p>
                        <form class="footer-subscribe d-flex flex-wrap" method="POST" action="#">
                            @csrf
                            <input type="email" name="subscribe_email" placeholder="Enter your email" required />
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-content">
        <div class="container">
            <div class="text-center text-dark">&copy; 2025 RVParkHQ.com. All rights reserved. Designed with ❤️ for explorers.</div>
        </div>
    </div>
</footer>

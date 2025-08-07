<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $team = [
            [
                'name' => 'Mark Latture',
                'role' => 'Founder, WebDaVinci & RVParkHQ',
                'country' => 'USA',
                'flag' => '🇺🇸',
                'image' => 'images/team/mark-latture.jpg',
                'email' => 'mark@webdavinci.com',
                'bio' => "Mark Latture is the founder of WebDaVinci and the visionary behind RVParkHQ. With a background in software development, technology, marketing, and small business operations, Mark brings a rare mix of strategic thinking and hands-on execution to the campground and outdoor hospitality industry.

After experiencing firsthand how fragmented and outdated campground systems could be, Mark set out to create something better, starting with a smarter directory and evolving into a full-stack platform that combines modern design, artificial intelligence, and automation. His goal was to give park owners the kind of tools typically reserved for major hotel chains, without the complexity or cost.

Under his leadership, WebDaVinci has developed AI-driven chatbots, integrated booking solutions, and multi-channel outreach tools that help RV parks grow revenue while simplifying day-to-day operations. Mark continues to lead product strategy, innovation, and partnerships—always with a focus on making technology approachable and impactful for real-world campground owners."
            ],
            [
                'name' => 'Ahfaz Malik',
                'role' => 'Full Stack Developer / Bot Integration Specialist / Project Manager',
                'country' => 'Pakistan',
                'flag' => '🇵🇰',
                'image' => 'images/team/ahfaz.jpg',
                'email' => 'malikahfaz@webdavinci.com',
                'bio' => "Hi, I'm Ahfaz — a seasoned Full Stack Developer with 6+ years of experience in backend technologies like Laravel, PHP, Node.js, and SQL. I’m also confident on the frontend, working with React, JavaScript, HTML, CSS, and AJAX. I've successfully delivered over 100 full-stack projects including e-commerce platforms, CMS, LMS, and POS systems. My expertise includes AI chatbot integration, RESTful APIs, and building scalable, secure architectures. Beyond coding, I actively lead projects, define scopes, manage teams, and ensure timely delivery with a solution-oriented mindset."
            ],
            [
                'name' => 'Thomas Barrientos',
                'role' => 'Senior Software Engineer / DevOps',
                'country' => 'Philippines',
                'flag' => '🇵🇭',
                'image' => 'images/team/thomas-barrientos.jpg',
                'email' => 'thomasbarrientos@webdavinci.com',
                'bio' => 'A Software Engineer blending code and DevOps to streamline deployment and performance.'
            ],
            [
                'name' => 'Mattia Fiorin',
                'role' => 'Head of Digital Marketing (Italy)',
                'country' => 'Italy',
                'flag' => '🇮🇹',
                'image' => 'images/team/mattia-fiorin.jpg',
                'email' => 'mattia@webdavinci.com',
                'bio' => 'Mattia Fiorin is a seasoned media and marketing professional with an extensive background in digital marketing management, media planning, and event management, managing multi-million dollar budgets and interacting directly with major platforms.'
            ],
            [
                'name' => 'Sky Lake',
                'role' => 'Campground Consultant & Industry Advisor - RVParkHQ',
                'country' => 'USA',
                'flag' => '🇺🇸',
                'image' => 'images/team/sky-lake.jpg',
                'email' => 'sky@webdavinci.com',
                'bio' => 'Sky Lake is the owner and operator of Kayuta Lake Campground, a thriving destination in upstate New York, and a key consultant on the RVParkHQ project. With deep, firsthand experience running a busy campground, Sky brings invaluable insight into the real-world challenges that park owners face — from guest communication and booking logistics to seasonal staffing and revenue management. As a trusted advisor to the RVParkHQ and WebDaVinci teams, Sky helps ensure the platform is grounded in what actually works for park operators — not just what looks good on paper. His feedback has shaped everything from listing layouts and reservation flows to the design of AI-powered tools that streamline operations and boost bookings. Sky’s mission aligns with ours: empower parks with tools that save time, drive revenue, and improve the guest experience without adding complexity.'
            ],
            [
                'name' => 'Rex Wong',
                'role' => 'Database Consultant – RVParkHQ / WebDaVinci',
                'country' => 'United Kingdom',
                'flag' => '🇬🇧',
                'image' => 'images/team/rex-wong.png',
                'email' => 'rex@webdavinci.com',
                'bio' => 'Rex Wong is the data integrity expert behind the scenes at RVParkHQ, serving as a consultant on all things database architecture, performance, and reliability. With years of experience managing large-scale data systems, Rex ensures that the platform\'s core — its listings, user accounts, analytics, and booking data — is structured for speed, accuracy, and long-term scalability.'
            ],
            [
                'name' => 'Jakir',
                'role' => 'Design / Partner Success – RVParkHQ / WebDaVinci',
                'country' => 'Pakistan',
                'flag' => '🇵🇰',
                'image' => 'images/team/jakir.jpg',
                'email' => 'jakir@webdavinci.com',
                'bio' => "Hi, I'm Jakir — a passionate Web Developer, Graphic Designer, and Data Entry Expert. With years of hands-on experience, I bring creative design, clean code, and accurate data handling to help businesses grow online. Let's build something great together!"
            ],
            [
                'name' => 'JM Balaba',
                'role' => 'Design / Partner Success – RVParkHQ / WebDaVinci',
                'country' => 'Philippines',
                'flag' => '🇵🇭',
                'image' => 'images/team/mj.jpg',
                'email' => 'jm@webdavinci.com',
                'bio' => 'JM Balaba brings energy, creativity, and a keen eye for user experience to the RVParkHQ and WebDaVinci teams. As a core member of the design and sales team, JM is responsible for shaping the visual identity of the platform and helping campground owners understand the value of digital tools that actually work.'
            ],
            [
                'name' => 'Dexter Cabagua',
                'role' => 'Finance & Bookkeeping Consultant – RVParkHQ / WebDaVinci',
                'country' => 'Philippines',
                'flag' => '🇵🇭',
                'image' => 'images/team/dexter-cabagua.jpeg',
                'email' => 'dexter@webdavinci.com',
                'bio' => 'Dexter serves as the finance and bookkeeping consultant for RVParkHQ and WebDaVinci, bringing a sharp eye for detail and a strategic mindset to the financial side of our operations. From managing budgets and tracking expenses to advising on pricing models and transaction flows, Dexter plays a critical role in keeping our business grounded and scalable. In addition to managing the numbers, Dexter consults on the financial design of our platform—helping shape how reservation payments, site lock fees, and reporting systems are structured for both park owners and guests. His insights ensure that the platform isn’t just smart—it makes fiscal sense, too. Thanks to Dexter, our ledgers are balanced, and our features are built with real-world financial workflows in mind.'
            ],
        ];

        return view('frontend.pages.our-team.index', compact('team'));
    }
}

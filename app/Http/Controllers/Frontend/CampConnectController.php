<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampConnectController extends Controller
{
    public function index()
    {
        $features = [
            ['title' => 'Upcoming Events & Weather', 'desc' => 'Let guests know what’s happening in your area and at your park.'],
            ['title' => 'Last-Minute Deals', 'desc' => 'Highlight open sites or cabins with one click, delivered via text alerts.'],
            ['title' => 'Campfire Recipes & Travel Tips', 'desc' => 'Fun seasonal content helps your email stand out and builds trust.'],
            ['title' => 'Smart Loyalty & Re-Engagement', 'desc' => 'Reward loyal guests and win back those who haven’t booked in over a year.'],
            ['title' => 'Park News & Upgrades', 'desc' => 'Share improvements from new fire pits to weekend hayrides.']
        ];

        $benefits = [
            ['AI-Generated, Location-Aware', 'The email writes itself using smart prompts and local data. No editing needed.'],
            ['Sent From You', 'Emails use your park name, logo, and reply email, making them feel personal.'],
            ['Easy to Customize', 'Update the message or schedule one-time blasts when you need.'],
            ['Low Cost, High Impact', 'Affordable thanks to tasteful, relevant sponsorships — always camper-friendly.']
        ];

        return view('frontend.pages.camp-connect.index', compact('benefits', 'features'));
    }
}
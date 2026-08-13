<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Park;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user')->where('status', 'published')->latest()->paginate(6);
        $totalParks = Park::query()
            ->defaultSearch()
            ->where('status', 'active')
            ->count();
        $team = [
            ['name' => 'Mark Latture', 'role' => 'Founder / Architect', 'country' => 'USA', 'flag' => '🇺🇸', 'image' => 'https://ui-avatars.com/api/?name=Mark+Latture&background=random', 'email' => 'mark@webdavinci.com'],
            ['name' => 'Malik', 'role' => 'Developer', 'country' => 'Pakistan', 'flag' => '🇵🇰', 'image' => 'https://ui-avatars.com/api/?name=Malik&background=random', 'email' => 'malik@webdavinci.com'],
            ['name' => 'Thomas', 'role' => 'Developer', 'country' => 'Philippines', 'flag' => '🇵🇭', 'image' => 'https://ui-avatars.com/api/?name=Thomas&background=random', 'email' => 'thomas@webdavinci.com'],
            ['name' => 'Josh', 'role' => 'Sola Integrations', 'country' => 'USA', 'flag' => '🇺🇸', 'image' => 'https://ui-avatars.com/api/?name=Josh&background=random', 'email' => 'josh@webdavinci.com'],
            ['name' => 'Sky', 'role' => 'Business Consultant', 'country' => 'USA', 'flag' => '🇺🇸', 'image' => 'https://ui-avatars.com/api/?name=Sky&background=random', 'email' => 'sky@webdavinci.com'],
            ['name' => 'MJ', 'role' => 'Partner Success Specialist', 'country' => 'Philippines', 'flag' => '🇵🇭', 'image' => 'https://ui-avatars.com/api/?name=MJ&background=random', 'email' => 'mj@webdavinci.com'],
            ['name' => 'Jakir', 'role' => 'Partner Success Specialist', 'country' => 'Pakistan', 'flag' => '🇵🇰', 'image' => 'https://ui-avatars.com/api/?name=Jakir&background=random', 'email' => 'jakir@webdavinci.com'],
            ['name' => 'Steve', 'role' => 'Partner Success Specialist', 'country' => 'Wales', 'flag' => '🏴', 'image' => 'https://ui-avatars.com/api/?name=Steve&background=random', 'email' => 'steve@webdavinci.com'],
        ];

        return view('frontend.pages.home.index', compact('blogs', 'team', 'totalParks'));
    }
}

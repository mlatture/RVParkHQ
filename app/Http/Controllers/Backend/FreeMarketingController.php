<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class FreeMarketingController extends Controller
{
    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['free_marketing.view']);

        $free_marketing = SystemLog::orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.free-marketing.index', compact('free_marketing'));
    }
}

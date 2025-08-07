<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['subscribers.view']);

        $subscribers = Subscriber::search($request->search)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.pages.subscriber.index', compact('subscribers'));
    }

    public function destroy($id)
    {
        Subscriber::findOrFail($id)->delete();

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber deleted successfully.');
    }

}

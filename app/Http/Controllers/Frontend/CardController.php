<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function cards()
    {
        $user = Auth::user();
        $cards = Card::where('user_id', $user->id)
            ->with(['payments.bill'])
            ->get();
        return view('frontend.pages.profile.cards', compact('user', 'cards'));
    }

    public function addCard(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'card_number' => [
                'required',
                'digits:16',
                'unique:cards,card_number,NULL,id,user_id,' . $user->id
            ],
            'expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cvc' => ['required', 'digits_between:3,4'],
        ]);
        \App\Models\Card::create([
            'user_id' => $user->id,
            'card_number' => $request->card_number,
            'expiry' => $request->expiry,
            'cvc' => $request->cvc,
        ]);
        return redirect()->route('rv-park.profile.cards')->with(['success' => 'Card added successfully!', 'icon' => 'success']);
    }

    public function deleteCard(\App\Models\Card $card)
    {
        $user = Auth::user();
        if ($card->user_id !== $user->id) {
            abort(403);
        }
        $card->delete();
        return redirect()->route('rv-park.profile.cards')->with(['success' => 'Card deleted successfully!', 'icon' => 'success']);
    }
}

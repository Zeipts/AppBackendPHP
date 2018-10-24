<?php

namespace App\Http\Controllers;

use App\Card;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Zeipt\ZeiptConnect;

class WebController extends Controller
{
    public function showTerms(Request $request)
    {
        $user = Auth::user()->first();
        return view('cards.terms', compact('user'));
    }

    public function presentCardForm(Request $request)
    {
        $user = Auth::user()->first();
        $con = new ZeiptConnect(env('ZEIPT_TOKEN'), env('ZEIPT_USER'), env('ZEIPT_PASS'));
        return view('cards.card', [
            'content' => $con->CreateCardRegister($user->cid, '/', '/', '/')
        ]);
    }

    public function cardSuccess(Request $request)
    {
        $gcid = $request->GCID;
        $user = User::where('cid', $gcid)->first();
        $transfer = $request->zeipt_card_transnr;
        $con = new ZeiptConnect(env('ZEIPT_TOKEN'), env('ZEIPT_USER'), env('ZEIPT_PASS'));
        $cards = $con->GetCard($gcid, $transfer);
        if ($cards) {
            foreach ($cards as $card) {
                Card::create([
                    'user_id' => $user->id,
                    'lastfour' => $card->last_digits,
                    'card_type' => $card->card_type,
                    'card_expires' => $card->expiration_date
                ]);
            }
        }
        return view('cards.success');
    }

    public function cardFailed(Request $request)
    {
        return view('cards.failure');
    }

    public function cardCancelled(Request $request)
    {
        return view('cards.cancelled');
    }

    public function home()
    {
        return view('welcome');
    }
}

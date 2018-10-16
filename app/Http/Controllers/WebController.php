<?php

namespace App\Http\Controllers;

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
        $con = new ZeiptConnect('token', 'alex', 'zeipt.com');
        return view('cards.card', [
            'content' => $con->CreateCardRegister($user->cid, '/', '/', '/')
        ]);
    }
}

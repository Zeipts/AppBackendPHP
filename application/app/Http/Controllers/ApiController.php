<?php

namespace App\Http\Controllers;

use App\User;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Zeipt\ZeiptConnect;
use Carbon\Carbon;

class ApiController extends Controller
{

    public function handleLogin(Request $request)
    {
        $email = $request->name;
        $password = $request->password;
        $customer = User::where('email', $email)->first();
        if ($customer) {
            if (Hash::check($password, $customer->password)) {
                $session = $this->makeSession($customer);
                return response()->json([
                    'success' => 1,
                    'GCID' => $customer->cid,
                    'session_token' => $session->token
                ]);
            }
        }
        return response()->json([
            'success' => 0,
            'msg' => 'Wrong username or password'
        ]);
    }

    public function refreshLogin(Request $request)
    {
        $user = Auth::user();
        $session = $this->makeSession($user);
        return response()->json([
            'success' => 1,
            'session_token' => $session->token
        ]);
    }

    public function handleRegister(Request $request)
    {
        $email = $request->name;

        if (empty($email)) {
            return response()->json([
                'success' => 0,
                'msg' => "Missing parameter email"
            ]);
        }

        $password = $request->password;
        if (User::where('email', $email)->first()) {
            return response()->json([
                'success' => 0,
                'msg' => "Customer already exists"
            ]);
        }

        if (empty($password)) {
            return response()->json([
                'success' => 0,
                'msg' => "Missing parameter password"
            ]);
        }

        $cid = md5(time() . $email);
        //Register gcid with Zeipt
        $con = new ZeiptConnect(env('ZEIPT_TOKEN'), env('ZEIPT_USER'), env('ZEIPT_PASS'));
        $msg = "Failed to register customer with zeipt";
        if ($con->RegisterCustomer($cid)) {
            $customer = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'cid' => $cid
            ]);
            $msg = "Failed to create customer!";
            if ($customer) {
                $customer->registered = true;
                $customer->save();
                $session = $this->makeSession($customer);
                if ($session) {
                    return response()->json([
                        'success' => 1,
                        'msg' => "Customer $email created",
                        'session_token' => $session->token,
                        'cid' => $customer->cid
                    ]);
                }
            }
        }

        return response()->json([
            'success' => 0,
            'msg' => $msg
        ]);
    }

    public function getReceipts(Request $request)
    {
        $user = Auth::user();
        \Log::info("Receipts request made for " . $user->cid . " user_id " . $user->id);
        $con = new ZeiptConnect(env('ZEIPT_TOKEN'), env('ZEIPT_USER'), env('ZEIPT_PASS'));
        $response = $con->GetReceipts($user->cid, Carbon::now()->subMonths(2)->toIso8601String(), Carbon::now()->toIso8601String());
        \Log::info("Receipt response: ");
        \Log::info(json_encode($response));
        return response()->json($response);
    }

    public function getCards(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'success' => 1,
            'cards' => $user->cards
        ]);
    }

    public function removeCard(Request $request, $cid, $cardid)
    {
       $user = Auth::user();
       $con = new ZeiptConnect(env('ZEIPT_TOKEN'), env('ZEIPT_USER'), env('ZEIPT_PASS'));
       if ($user->cards()->where('id', $cardid)) {
           $user->cards()->where('id', $cardid)->delete();
           return response()->json([
                'success' => 1,
                'msg' => 'Card removed'
           ]);
       } else {
           return response()->json([
               'success' => 0,
               'msg' => 'No card to remove'
           ]);
       }
    }

    private function makeSession(User $customer)
    {
        $old_sessions = Session::where('user_id', $customer->id)->where('expired', false)->get();
        foreach ($old_sessions as $old) {
            $old->expired = true;
            $old->save();
        }

        $hash = md5(time().$customer->name);
        $session = Session::create([
            'user_id' => $customer->id,
            'expired' => false,
            'token' => $hash
        ]);
        return $session;
    }
}

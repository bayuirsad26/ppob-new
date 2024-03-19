<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    const TYPE_PULSA = "PULSA";
    const TYPE_TOPUP = "TOPUP";

    public function history(){
        $items = Transaction::where('user_id', Auth::user()->id)
        ->whereNotIn('type', [self::TYPE_TOPUP])
        ->get();        
        return view("payments.all", compact("items"));
    }

    public function topupShow(){
        $items = Transaction::where("type", self::TYPE_TOPUP)->where("user_id",Auth::user()->id)->get();
        return view("payments.topup", compact("items"));
    }

    public function topupPay(Request $request){
        $data = $request->all();
        $fee = 0;
        try {
            $trx = new Transaction();
            $trx->user_id = Auth::user()->id;
            $trx->type = self::TYPE_TOPUP;
            $trx->item = $data["iAmount"];
            $trx->provider = $data["sMethod"];
            $trx->bill_amount = $data["iAmount"];
            $trx->fee_amount = $fee;
            $trx->total_amount = $data["iAmount"] + $fee;
            $trx->save();

            Auth::user()->wallet->increment('balance', $data["iAmount"]);

            return redirect()->back()->with('success', 'Your payment was complete!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
       
    }
    public function pulsaShow(){
        return view("payments/pulsa");
    }

    public function pulsaPay(Request $request){
        $data = $request->all();
        $fee = 0;
        $balance = Auth::user()->wallet->balance;
        if ( $balance > $data["sAmount"]) {
            try {
                $trx = new Transaction();
                $trx->user_id = Auth::user()->id;
                $trx->payment_id = $data["iPhone"];
                $trx->type = self::TYPE_PULSA;
                $trx->item = $data["sAmount"];
                $trx->provider = $data["sProvider"];
                $trx->bill_amount = $data["sAmount"];
                $trx->fee_amount = $fee;
                $trx->total_amount = $data["sAmount"] + $fee;
                $trx->save();

                Auth::user()->wallet->decrement('balance', $data["sAmount"] + $fee);

                return redirect()->back()->with('success', 'Your payment was complete!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Your balance is insufficient!');
        }
    }
}

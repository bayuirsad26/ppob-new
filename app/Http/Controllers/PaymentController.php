<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


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
        $USERNAME = env('DIGIFLAZZ_USERNAME');
        $KEY = env('DIGIFLAZZ_KEY');

        $sign = md5($USERNAME . $KEY . 'pricelist');
        $payload = [
            'cmd'      => 'prepaid',
            'username' => $USERNAME,
            'sign'     => $sign,
        ];

        $response = Http::post('https://api.digiflazz.com/v1/price-list', $payload);

        $data = $response->json();

        $products = collect($data['data'])
        ->filter(fn($item) => $item['category'] === 'Pulsa')
        ->map(function ($item) {
            return [
                'name' => $item['product_name'],
                'price' => $item['price'],
                'sku' => $item['buyer_sku_code'],
                'brand' => $item['brand'],
            ];
        })
        ->sortBy('price')
        ->values();

        // dd($products);
        return view("payments/pulsa",compact('products'));
    }

    public function pulsaPay(Request $request){
        $data = $request->all();
        $fee = 0;
        $balance = Auth::user()->wallet->balance;

        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('DIGIFLAZZ_KEY');

        $refId = Str::upper(Str::random(16));
        $sign = md5($username . $apiKey . $refId);

        $payload = [
            'username'      => $username,
            'buyer_sku_code'=> $data['sSku'],
            'customer_no'   => $data['iPhone'],
            'ref_id'        => $refId,
            'sign'          => $sign,
        ];

        if ( $balance > $data["price"]) {
            try {
                $response = Http::post('https://api.digiflazz.com/v1/transaction', $payload);
                $responseData = $response->json()['data'] ?? [];
                if (!$responseData) {
                    Log::error('Invalid API response from Digiflazz', ['response' => $response->json()]);
                    abort(500, 'Invalid API response');
                }

                Log::info('Digiflazz transaction response', ['data' => $responseData]);

                $refId = $responseData['ref_id'] ?? null;
                $status = $responseData['status'] ?? null;
                $price = $responseData['price'] ?? 0;

                $trx = new Transaction();
                $trx->user_id = Auth::id();
                $trx->payment_id = $refId;
                $trx->type = self::TYPE_PULSA;
                $trx->item = $responseData['buyer_sku_code'] ?? '';
                $trx->provider = $data['sProvider'] ?? '';
                $trx->bill_amount = $price;
                $trx->fee_amount = $fee;
                $trx->total_amount = $price + $fee;

                // Set status sesuai rc
                if ($status === 'Sukses') {
                    $trx->status = 'COMPLETED';
                    Auth::user()->wallet->decrement('balance', $price + $fee);
                } elseif ($status === 'Pending') {
                    $trx->status = 'PENDING';
                } else {
                    $trx->status = 'FAILED';
                }

                $trx->save();


                return redirect()->route('history')->with('success', 'Your payment was complete!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Your balance is insufficient!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStateEnum;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $secret = config('services.digiflazz.webhook_secret');
        $rawPayload = $request->getContent();

        $computedSignature = 'sha1=' . hash_hmac('sha1', $rawPayload, $secret);
        $headerSignature = $request->header('X-Hub-Signature');

        // Log::info($computedSignature);

        if (!hash_equals($computedSignature, $headerSignature)) {
            Log::warning('Invalid Digiflazz webhook signature.');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $data = json_decode($rawPayload, true)['data'] ?? [];

        Log::info('Valid Digiflazz webhook received', $data);

        if (($data['rc'] ?? '') === '00' || ($data['status'] ?? '') === 'Sukses') {
            $refId = $data['ref_id'] ?? null;

            if ($refId) {
                $trx = Transaction::where('payment_id', $refId)->first();

                if ($trx) {
                    Log::info('sukses');
                    $billAmount = $data['price'];
                    $totalAmount = $billAmount + $trx->fee_amount;

                    $trx->status = TransactionStateEnum::COMPLETED->value;
                    $trx->save();

                    if ($trx->user && $trx->user->wallet) {
                        $trx->user->wallet->decrement('balance', $totalAmount);
                    }
                }
            }

        } elseif (in_array($data['rc'] ?? '', ['03', '99']) ||  ($data['status'] ?? '') === 'Pending') {
            Log::info('pending');
            $refId = $data['ref_id'] ?? null;

            if ($refId) {
                $trx = Transaction::where('payment_id', $refId)->first();
                $trx->status = TransactionStateEnum::PENDING->value;
                $trx->save();
            }
        } else {
            Log::info('failed');
            $refId = $data['ref_id'] ?? null;

            if ($refId) {
                $trx = Transaction::where('payment_id', $refId)->first();
                $trx->status = TransactionStateEnum::FAILED->value;
                $trx->save();
            }
        }
        return response()->json(['message' => 'Webhook processed'], 200);
    }
}


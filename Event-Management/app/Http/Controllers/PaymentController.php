<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payment(Request $request): JsonResponse
    {
        Stripe::setApiKey(config(env('STRIPE_KEY')));

          $orderId = $request->json('id');

        if (!$orderId) {
            return response()->json(['error' => 'Request must provide an order_id'], Response::HTTP_NOT_FOUND);
        }


        $totalAmount = Order::find($orderId)->total_amount;

    
        $paymentIntent = PaymentIntent::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd', 
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'message' => ' Payment: successful',
            'client_secret' => $paymentIntent->client_secret,
            'total_amount' => $totalAmount,
        ], Response::HTTP_OK);
    }
    
}

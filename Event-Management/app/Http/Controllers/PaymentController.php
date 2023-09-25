<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\InvoiceService;
use App\Services\OrderResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payment( $order_id, InvoiceService $invoiceService, OrderResponseService $orderResponse ): JsonResponse
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        if (!$order_id) {
            return response()->json(['error' => 'Request must provide an order_id'], Response::HTTP_NOT_FOUND);
        }


        $totalAmount = Order::find($order_id)->total_amount;


        $paymentIntent = PaymentIntent::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        $order = Order::find($order_id);
        $invoiceData = $orderResponse->buildOrderResponse($order);
        $invoiceService->createInvoice($invoiceData);

        return response()->json([
            'message' => ' Payment: successful',
            'client_secret' => $paymentIntent->client_secret,
            'total_amount' => $totalAmount,
        ], Response::HTTP_OK);
    }
}

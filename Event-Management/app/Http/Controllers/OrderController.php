<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendeeValidatorRequest;
use App\Models\Order;
use App\Services\PurchaseService;
use App\Services\TicketValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{


    public function index(): JsonResponse
    {
        $order = Order::get();

        if (!$order) {

            return response()->json(['error' => 'There are no orders available']);
        }
        return response()->json([$order], Response::HTTP_OK);
    }



    public function store(Request $request, AttendeeValidatorRequest $attendeeRequestValidation, TicketValidator $ticketValidator, PurchaseService $purchaseService): JsonResponse
    {


        $validator = Validator::make($request->all(), $attendeeRequestValidation->rules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }


        $ticketValidationMessage = $ticketValidator->validate($request->input('tickets'));

        if ($ticketValidationMessage) {
            return response()->json(['message' => $ticketValidationMessage], Response::HTTP_BAD_REQUEST);
        }


        $order = $purchaseService->createOrder($request->all(), $request->input('tickets'));

        return response()->json(['message' => "Everything went OK!  Order details: ", 'order' => $order], Response::HTTP_ACCEPTED);
    }
}

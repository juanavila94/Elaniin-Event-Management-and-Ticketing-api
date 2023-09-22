<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketTypeStoreRequest;
use App\Models\TicketType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TicketTypeController extends Controller
{

    //  /**
    //   * Display a listing of the resource.
    //   */
    //  public function index()
    //  {
    //       $events = Event::paginate(10);

    //       if (!$events) {

    //            return response()->json(['error' => 'There are no events available']);
    //       }
    //       return response()->json($events);
    //  }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketTypeStoreRequest $request): JsonResponse
    {

        $validated = $request->validated();

        $ticketType = new TicketType([

            'ticket_type_name'  => $validated['ticket_type_name'],
            'available_quantity' => $validated['available_quantity'],
            'sold_quantity' => $validated['sold_quantity'],
            'value' => $validated['value'],
            'description' => $validated['description'],
            'sale_start_date' => $validated['sale_start_date'],
            'sale_end_date' => $validated['sale_end_date'],
            'purchase_limit' => $validated['purchase_limit'],
            'event_id' => $request->get('event_id')

        ]);

        $ticketType->save();

        if (!$ticketType) {

            return response()->json(
                ['message' => 'Ticket Type can not be created!'],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json(
            ['message' => "Ticket Type {$request->ticket_type_name} successfully created"],
            Response::HTTP_CREATED
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketTypeStoreRequest $request, $id): JsonResponse
    {

        $ticketTypeToUpdate = TicketType::findOrFail($id);

        if (!$ticketTypeToUpdate) {
            return response()->json(
                ['message' => "Ticket Type {$ticketTypeToUpdate->ticket_type_name} can not be found"],
                Response::HTTP_NOT_FOUND
            );
        }


        // $request->validate((new TicketTypeStoreRequest)->rules());

        $ticketTypeToUpdate->update($request->all());

        return response()->json(
            ['message' => "Ticket Type: {$ticketTypeToUpdate->ticket_type_name} successfully updated"],
            Response::HTTP_OK
        );
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $ticketType = TicketType::findOrFail($id);

        $refundedOrders = DB::table('ticket_types')
            ->join('tickets', 'ticket_types.id', '=', 'tickets.ticket_type_id')
            ->leftJoin('orders', 'tickets.order_id', '=', 'orders.id')
            ->where('ticket_types.id', $id)
            ->where('orders.status', '=', 'active')
            ->whereNot('orders.status', '=', 'refunded')
            ->count();

        if ($refundedOrders > 0) {
            return response()->json(['message' => "Ticket : {$id}/{$ticketType->ticket_type_name} can not be deleted"], Response::HTTP_BAD_REQUEST);
        }

        $ticketType->delete();

        return response()->json(['message' => "Ticket : {$id}/{$ticketType->ticket_type_name} successfully deleted"], Response::HTTP_OK);
    }
}

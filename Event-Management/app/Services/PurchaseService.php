<?php
namespace App\Services;

use App\Models\Attendee;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function createOrder( array $attendeeData, array $validatedTickets): JsonResponse
    {
      
        DB::beginTransaction();

        $attendee = Attendee::firstOrNew(['email' => $attendeeData['email']]);
        $attendee->first_name = $attendeeData['first_name'];
        $attendee->save();
        
        $order = new Order();
        $order->attendee_id = $attendee->id;
        $order->save();
        
        foreach ($validatedTickets as $ticketData) {
            $ticketType = TicketType::find($ticketData['ticket_type_id']);

           
            if (!$ticketType || $ticketType->available_quantity < $ticketData['quantity']) {
                DB::rollBack();
                return response()->json(['message' => 'There are no available tickets'],Response::HTTP_BAD_REQUEST);
            }

           
            $ticket = new Ticket();
            $ticket->ticket_type_id = $ticketData['ticket_type_id'];
            $ticket->quantity = $ticketData['quantity'];
            $attendeeData['attendee_name'] ?? $attendeeData['first_name'];
            $order->tickets()->save($ticket);

          
            $ticketType->decrement('available_quantity', $ticketData['quantity']);
        }

       
        $order->status = 'completed';
        $order->date_of_purchase = now();

        
        $totalAmount = 0;
        foreach ($validatedTickets as $ticketData) {
            $ticketType = TicketType::find($ticketData['ticket_type_id']);
            $totalAmount += $ticketType->value * $ticketData['quantity'];
        }
        $order->total_amount = $totalAmount;

       
        $order->save();

     
        foreach ($validatedTickets as $ticketData) {
          $ticket = Ticket::where('ticket_type_id', $ticketData['ticket_type_id'])
              ->where('quantity', $ticketData['quantity'])
              ->first();
          $ticket->status = 'checkedOut';
          $ticket->save();

          $ticketType = TicketType::find($ticketData['ticket_type_id']);
          $ticketType->decrement('available_quantity', $ticketData['quantity']);
          $ticketType->increment('sold_quantity', $ticketData['quantity']);
      }

        DB::commit();

      
        return response()->json(['message' => 'Order successfully created'], Response::HTTP_ACCEPTED);
    }
} 
?>
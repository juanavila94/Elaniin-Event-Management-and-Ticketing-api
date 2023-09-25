<?php

namespace App\Services;


use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderResponseService
{
     public function buildOrderResponse(Order $order)
     {
          $orderData = DB::table('orders')
               ->select('orders.id', 'attendees.first_name as name', 'attendees.email', 'orders.date_of_purchase', 'orders.total_amount')
               ->join('attendees', 'orders.attendee_id', '=', 'attendees.id')
               ->where('orders.id', $order->id)
               ->first();

          $ticketsData = DB::table('tickets')
               ->select('tickets.ticket_type_id', 'tickets.attendee_name', 'tickets.quantity', 'ticket_types.ticket_type_name as ticket_type_name', 'events.event_name')
               ->join('ticket_types', 'tickets.ticket_type_id', '=', 'ticket_types.id')
               ->join('events', 'ticket_types.event_id', '=', 'events.id')
               ->where('tickets.order_id', $order->id)
               ->get();

          $response = [
               'id' => $orderData->id,
               'name' => $orderData->name,
               'email' => $orderData->email,
               'date_of_purchase' => $orderData->date_of_purchase,
               'total_amount' => $orderData->total_amount,
               'tickets' => $ticketsData->map(function ($ticket) {
                    return [
                         'ticket_type_name' => $ticket->ticket_type_name,
                         'event_name' => $ticket->event_name,
                         'attendee_name' => $ticket->attendee_name,
                         'quantity' => $ticket->quantity,
                    ];
               }),
          ];

          return $response;
     }
}

<?php

namespace App\Services;

use App\Models\TicketType;

class TicketValidator
{
    public function validate(array $ticketData)
    {

        $errors=[];


        foreach ($ticketData as $ticket) {
            $ticketType = TicketType::find($ticket['ticket_type_id']);

            if (!$ticketType) {
                $errors[] = 'Invalid Ticket Type';
            }

            if ($ticketType->available_quantity < $ticket['quantity']) {
               $errors[] = "Ticket Type:{$ticketType->name} has not enough tickets"; 
            }

            if ($ticketType->purchase_limit > 0 && $ticket['quantity'] > $ticketType->purchase_limit) {
                $errors[] = "You've exceed your purchase limit for :{$ticketType->name} ";
            }
        }

        return $errors;
    }
}
?>
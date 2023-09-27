<?php

namespace Tests\Feature;

use App\Models\Attendee;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    //CREATE ORDER// 
    public function test_order_can_be_created(): void
    {
        $ticketType = TicketType::factory()->create();
       

        $response = $this->post('/api/order/create',[

           
            'first_name' => 'juan',
            'email' => 'juan.cruz@elaniin.com',
             'tickets'=> [
                            [
                            'ticket_type_id' => $ticketType->id,
                            'quantity' => 2,
                            'attendee_name'=> 'juan'
                            ]
                         ],

        ]);
        
            $response->assertAccepted();

    }  

    //GET ORDERS//
    public function test_order_can_be_retrieved_from_db(): void
    {
        $response = $this->get('/api/list/orders');

        $response->assertOk();
    }
}
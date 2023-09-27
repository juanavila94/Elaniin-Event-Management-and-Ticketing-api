<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTypeTest extends TestCase
{
    use RefreshDatabase;

    //CREATE TICKET TYPE//
    public function test_ticket_type_can_be_created(): void
    {
        $event = Event::factory()->create();
        $user  = User::factory()->create();

        $response = $this->actingAs($user)
                         ->post('/ticketTypes/create',[

                            "ticket_type_name" => "Early Birds",
                            "available_quantity"=> 10,
                            "sold_quantity" => 0,
                            "value" => "2555",
                            "description" =>  "primera tranda", 
                            "sale_start_date" => "2023/10/10",
                            "sale_end_date" => "2023/10/11",
                            "purchase_limit"=>  3,
                            "event_id" => $event->id

                         ]);
            $response->assertCreated();
    }

    //GET TICKET TYPE//
    public function test_ticket_type_can_be_retrieved_from_db():void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->get('/ticketTypes/list');


            $response->assertOk();
    }

    //UPDATE TICKET TYPE//
    public function test_ticket_type_can_be_updated():void
    {
        $user  = User::factory()->create();
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $response = $this->actingAs($user)
                         ->put("/ticketTypes/update/{$ticketType->id}", [

                            "ticket_type_name" => "Early Birds",
                            "available_quantity"=> 10,
                            "sold_quantity" => 0,
                            "value" => "2555",
                            "description" =>  "primera tranda", 
                            "sale_start_date" => "2023/10/10",
                            "sale_end_date" => "2023/10/11",
                            "purchase_limit"=>  3,
                            "event_id" => $event->id

                         ]);
            $response->assertOk();
            $this->assertDatabaseMissing('ticket_types', $ticketType->toArray());
        
    }

    //DELETE TICKET TYPE//
    public function test_ticket_type_can_be_deleted(): void
    {
        $user  = User::factory()->create();
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $response = $this->actingAs($user)
                         ->delete("/ticketTypes/{$ticketType->id}");
            
            $response->assertOk();
    }

}

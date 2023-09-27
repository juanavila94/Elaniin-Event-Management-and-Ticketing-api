<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttendeeTest extends TestCase
{
    use RefreshDatabase;
  
    //CREATE //
    public function test_attendee_can_be_created(): void
    {
        $response = $this->post('/api/attendees/create', [

            'first_name' => 'juanjuan',
            'email' => 'juan@live.com.ar',

        ]);
        $response->assertCreated();
    }

    //GET EVENT//
    public function test_attendee_can_get_events(): void
    {
        $response = $this->get('attendees/event/list');
    
            $response->assertOk();
    }

    //GET EVENT DETAIL//
    public function test_attendee_can_get_events_detail(): void
    {
        $event = Event::factory()->create();

        $response = $this->get("/attendees/events/{$event->id}");

            $response->assertOk();
    }
}

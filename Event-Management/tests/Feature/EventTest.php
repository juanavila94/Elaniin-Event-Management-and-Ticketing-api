<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;
    


    //CREATE//
    public function test_event_can_be_created(): void
    {
        $user = User::factory()->create();


        $response = $this->actingAs($user)
                         ->post('/events/create', [

                'event_name' => 'name',
                'description' => 'description',
                'start_date' => '2022/05/09',
                'end_date' => '2022/05/10',
                'location' => 'location',
                'header_image' => 'image_url',
                'status' => 'status',
                'user_id' => $user->id

            ]);


        $response->assertCreated();
    }

    //UPDATE//
    public function test_event_can_be_updated(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->put("events/update/{$event->id}",[

                 'event_name' => 'name',
                 'description' => 'description',
                 'start_date' => '2022-05-09',
                 'end_date' => '2022-05-10',
                 'location' => 'location',
                 'header_image' => 'image_url',
                 'status' => 'status',
                 'user_id' => $user->id,

              ]);
    
              $response->assertOk();
    
              $this->assertDatabaseMissing('events', $event->toArray());
    }

    //GET LIST//
    public function test_events_list_be_retrieved_from_db(): void
    {
        $user = User::factory()->create();

           $response = $this->actingAs($user)
                         ->get('events/list');
    
                $response->assertOk();
    }
            
    //GET DETAIL//
    public function test_event_detail_can_be_retrieved_from_db(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

            $response = $this->actingAs($user)
                             ->get("events/details/{$event->id}");

                $response->assertOk();
    }
     
    //DELETE//
    public function test_event_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

            $response = $this->actingAs($user)
                             ->delete("events/{$event->id}");

                $response->assertOk();
    }

}
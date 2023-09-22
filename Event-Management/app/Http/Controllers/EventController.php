<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
     /**
      * Display a listing of the resource.
      */
     public function index()
     {
          $events = Event::paginate(10);

          if (!$events) {

               return response()->json(['error' => 'There are no events available']);
          }
          return response()->json($events);
     }

     /**
      * Show the form for creating a new resource.
      */
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request): JsonResponse
     {

          $validated = $request->validate([

               'event_name' => ['required', 'string', 'unique:events', 'max:255'],
               'description' => ['required', 'string',  'max:600'],
               'start_date' => ['required', 'date'],
               'end_date' => ['required', 'after:start_date'],
               'location' => ['required', 'string', 'max:255'],
               'header_image' => ['required', 'string'],
               'status' => ['required', 'string'],

          ]);


          $event = new Event([

               'event_name' => $validated['event_name'],
               'description' => $validated['description'],
               'start_date' => $validated['start_date'],
               'end_date' => $validated['end_date'],
               'location' => $validated['location'],
               'header_image' => $validated['header_image'],
               'status' => $validated['status'],
               'user_id' => $request->get('user_id'),
          ]);

          $event->save();

          return response()->json(['message' => 'Event successfully created'], Response::HTTP_CREATED);
     }

     /**
      * Display the specified resource.
      */
     public function show($id)
     {
          $eventDetail = Event::with('ticketTypes')->findOrFail($id);

          if (!$eventDetail) {

               return response()->json(['Message' => "Event {$id} can not be found or it does not exist"]);
          }

          return response()->json([$eventDetail], Response::HTTP_OK);
     }


     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, $id): JsonResponse
     {
          $eventToUpdate = Event::findOrFail($id);

          if (!$eventToUpdate) {
               return response()->json(['message' => "Event :{$eventToUpdate->event_name} can not be found"], Response::HTTP_NOT_FOUND);
          }


          $request->validate(Event::$rules);

          $eventToUpdate->update($request->all());


          return response()->json(['message' => "Event : {$eventToUpdate->event_name} successfully updated"], Response::HTTP_OK);
     }


     /**
      * Remove the specified resource from storage.
      */
     public function destroy($id): JsonResponse
     {

          $event = Event::findOrFail($id);

          $eventOrders = DB::table('events')
               ->join('ticket_types', 'events.id', '=', 'ticket_types.event_id')
               ->join('tickets', 'ticket_types.id', '=', 'tickets.ticket_type_id')
               ->join('orders', 'tickets.order_id', '=', 'orders.id')
               ->where('events.id', $event->id)
               ->whereIn('orders.status', ['active', 'refunded'])
               ->count();

          if ($eventOrders > 0) {
               return response()->json(['message' => "Event : {$id}/{$event->event_name} can not be deleted"], Response::HTTP_BAD_REQUEST);
          }

          $event->delete();

          return response()->json(['message' => "Event : {$id}/{$event->event_name} successfully deleted"], Response::HTTP_OK);
     }
}

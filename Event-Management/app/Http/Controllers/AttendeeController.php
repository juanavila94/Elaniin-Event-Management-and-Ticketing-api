<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttendeeController extends Controller
{

    public function index(): JsonResponse
    {
        $events = Event::paginate(10);

        if (!$events) {

            return response()->json(['error' => 'There are no events available']);
        }
        return response()->json([$events], Response::HTTP_OK);
    }

    public function show($id): JsonResponse
    {
        $eventDetail = Event::with('ticketTypes')->findOrFail($id);

        if (!$eventDetail) {

            return response()->json(['Message' => "Event {$id} can not be found or it does not exist"]);
        }

        return response()->json([$eventDetail], Response::HTTP_OK);
    }



    public function store(Request $request): JsonResponse
    {
        $attendee = new Attendee([

            'first_name' => $request->get('first_name'),
            'email' => $request->get('email'),

        ]);

        $attendee->save();

        return response()->json(
            ['message' => "Attendee {$request->first_name} successfully created"],
            Response::HTTP_CREATED
        );
    }
}

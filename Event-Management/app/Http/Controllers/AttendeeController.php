<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class AttendeeController extends Controller
{
    public function store(Request $request): void
    {
        $attendee = new Attendee([
            
            'name' => $request->get('name'),
            'email' => $request->get('email'),

        ]);

        $attendee->save();
    }
}

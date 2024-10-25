<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function store_schedule(Request $request){
        $validateData = $request->validate([
            'date' => 'required|date',
            'opening_time' => 'required|string',
            'closing_time' => 'required|string',
        ]);

        $schedule = Schedule::create($validateData);

        return response()->json([
            'message' => 'Schedule created successfully',
            'data' => $schedule,
            'success' => true
        ], 200);
    }
}

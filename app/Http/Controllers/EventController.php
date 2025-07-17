<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $events = $user->events;

        return view('events.index', [
            'events' => $events,
            'showingAll' => false
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all()
    {
        $today = Carbon::today();
        
        $events = Event::where('date', '>=', $today)
                    ->orderBy('date', 'asc')
                    ->get();

        return view('events.index', [
            'events' => $events,
            'showingAll' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'event_title' => 'required|string|max:255',
            'event_place' => 'required|string|max:255',
            'event_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar evento
        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $request->event_title,
            'place' => $request->event_place,
            'description' => $request->event_description,
            'date' => $request->event_date,
            'link' => $request->link,
            'instagram' => $request->instagram,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully!',
            'event' => $event
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\EventReservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = Event::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('events.index', compact('events'));
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $events = Event::where('date', '>=', Carbon::today())
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->latest('id')
            ->get();

        return view('events.show', compact('events'));
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
            'event_images' => 'required|array',
            'event_images.*' => 'image|mimes:jpg,jpeg,png|max:5120', // 5MB por archivo
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePaths = [];
        if ($request->hasFile('event_images')) {
            foreach ($request->file('event_images') as $file) {
                $imagePaths[] = $file->store('events', 'public');
            }
        }

        // Guardar evento
        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $request->event_title,
            'place' => $request->event_place,
            'description' => $request->event_description,
            'date' => $request->event_date,
            'image' => $imagePaths,
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
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }


    public function reserve(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        EventReservation::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'date' => now(),
        ]);

        return response()->json(['message' => 'Reservation created successfully.'], 200);
    }

    public function showJson($id)
    {
        $event = Event::findOrFail($id);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'place' => $event->place,
            'date' => $event->date,
            'link' => $event->link,
            'image' => asset('storage/' . $event->image),
        ]);
    }


}

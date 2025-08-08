<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rents = Rent::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('rent_title', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('rents.index', compact('rents'));
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $rents = Rent::where('due_date', '>=', Carbon::today())
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('rent_title', 'like', '%' . $request->search . '%');
            })
            ->latest('id')
            ->get();

        return view('rents.show', compact('rents'));
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
            'rent_title' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_number' => 'required', 
            'due_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar evento
        $event = Rent::create([
            'user_id' => Auth::id(),
            'rent_title' => $request->rent_title,
            'description' => $request->description,
            'contact_number' => $request->contact_number,
            'due_date' => $request->due_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rent created successfully!',
            'event' => $event
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent)
    {
        $rent->delete();
        return response()->json(['success' => true]);
    }
}

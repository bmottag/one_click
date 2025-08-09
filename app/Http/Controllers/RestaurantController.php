<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Restaurant::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('restaurant_name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('restaurants.index', compact('data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $data = Restaurant::when($request->filled('search'), function ($query) use ($request) {
                    $query->where('restaurant_name', 'like', '%' . $request->search . '%');
                })
                ->orderBy('restaurant_name', 'asc')
                ->get();

        return view('restaurants.show', compact('data'));
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
            'restaurant_name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_number' => 'required|string|max:15',
            'address' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'link' => 'nullable|url|max:150',
            'facebook' => 'nullable|url|max:150',
            'instagram' => 'nullable|url|max:150',
            'youtube' => 'nullable|url|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('restaurants', 'public');
        }

        // Guardar evento
        $restaurant = Restaurant::create([
            'user_id' => Auth::id(),
            'restaurant_name' => $request->restaurant_name,
            'description' => $request->description,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'email' => $request->email,
            'image' => $imagePath,
            'link' => $request->link,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Restaurant created successfully!',
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->json(['success' => true]);
    }
}

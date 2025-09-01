<?php

namespace App\Http\Controllers;

use App\Models\Tourism;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TourismController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Tourism::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('company_name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('tourism.index', compact('data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $data = Tourism::when($request->filled('search'), function ($query) use ($request) {
                    $query->where('company_name', 'like', '%' . $request->search . '%');
                })
                ->orderBy('company_name', 'asc')
                ->get();

        return view('tourism.show', compact('data'));
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
            'company_name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_number' => 'required|string|max:15',
            'address' => 'required|string|max:150',
            'email' => 'required|email|max:255',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120', // 5MB por archivo
            'link' => [
                                'nullable',
                                'regex:/^(https?:\/\/)?(www\.)?[a-z0-9\-]+(\.[a-z]{2,})(\/.*)?$/i',
                                'max:150',
                            ],
            'facebook' => [
                                'nullable',
                                'regex:/^(https?:\/\/)?(www\.)?[a-z0-9\-]+(\.[a-z]{2,})(\/.*)?$/i',
                                'max:150',
                            ],
            'instagram' => [
                                'nullable',
                                'regex:/^(https?:\/\/)?(www\.)?[a-z0-9\-]+(\.[a-z]{2,})(\/.*)?$/i',
                                'max:150',
                            ],
            'youtube' => [
                                'nullable',
                                'regex:/^(https?:\/\/)?(www\.)?[a-z0-9\-]+(\.[a-z]{2,})(\/.*)?$/i',
                                'max:150',
                            ],
            'google' => [
                                'nullable',
                                'regex:/^(https?:\/\/)?(www\.)?[a-z0-9\-]+(\.[a-z]{2,})(\/.*)?$/i',
                                'max:150',
                            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('services', 'public');
            }
        }

        // Guardar evento
        $data = Tourism::create([
            'user_id' => Auth::id(),
            'company_name' => $request->company_name,
            'description' => $request->description,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'email' => $request->email,
            'images' => $imagePaths,
            'link' => $request->link,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'google' => $request->google,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Beauty created successfully!',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tourism $tourism)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tourism $tourism)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tourism $tourism)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tourism $tourism)
    {
        $tourism->delete();
        return response()->json(['success' => true]);
    }
}

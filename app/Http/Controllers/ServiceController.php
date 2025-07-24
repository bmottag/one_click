<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::with('user');

        if ($request->filled('search')) {
            $query->where('company_name', 'like', '%' . $request->search . '%');
        }

        $data = $query->latest()->get();

        return view('services.index', [
            'data' => $data,
            'showingAll' => false
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $query = Service::orderBy('company_name', 'asc');

        if ($request->filled('search')) {
            $query->where('company_name', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();

        return view('services.index', [
            'data' => $data,
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
            'company_name' => 'required|string|max:255',
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
            $imagePath = $request->file('image')->store('services', 'public');
        }

        // Guardar evento
        $service = Service::create([
            'user_id' => Auth::id(),
            'company_name' => $request->company_name,
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
            'message' => 'Service created successfully!',
            'service' => $service
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}

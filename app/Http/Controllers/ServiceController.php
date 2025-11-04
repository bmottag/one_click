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
        $data = Service::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('company_name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('services.index', compact('data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $data = Service::when($request->filled('search'), function ($query) use ($request) {
                    $query->where('company_name', 'like', '%' . $request->search . '%');
                })
                ->orderBy('company_name', 'asc')
                ->get();

        return view('services.show', compact('data'));
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
            'google' => $request->google,
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
        $service->delete();
        return response()->json(['success' => true]);
    }
}

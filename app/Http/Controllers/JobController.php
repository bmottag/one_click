<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Job::with('user');

        if ($request->filled('search')) {
            $query->where('job_title', 'like', '%' . $request->search . '%');
        }

        $jobs = $query->latest()->get();

        return view('jobs.index', [
            'jobs' => $jobs,
            'showingAll' => false
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all(Request $request)
    {
        $today = Carbon::today();

        $query = Job::where('due_date', '>=', $today)
                    ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $query->where('job_title', 'like', '%' . $request->search . '%');
        }

        $jobs = $query->get();

        return view('jobs.index', [
            'jobs' => $jobs,
            'showingAll' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'job_title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'contact_number' => 'required', 
            'job_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar evento
        $event = Job::create([
            'user_id' => Auth::id(),
            'job_title' => $request->job_title,
            'job_description' => $request->job_description,
            'contact_number' => $request->contact_number,
            'due_date' => $request->job_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job created successfully!',
            'event' => $event
        ]);
    }
}

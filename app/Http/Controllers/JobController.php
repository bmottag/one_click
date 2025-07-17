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
    public function index()
    {
        $jobs = Job::with('user')->latest()->get();

        return view('jobs.index', [
            'jobs' => $jobs,
            'showingAll' => false
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function show_all()
    {
        $today = Carbon::today();
        
        $jobs = Job::where('date_issue', '>=', $today)
                    ->orderBy('date_issue', 'asc')
                    ->get();

        return view('jobs.index', [
            'jobs' => $jobs,
            'showingAll' => true
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function getStates($country_id)
    {
        $states = DB::table('states')
            ->where('country_id', $country_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = DB::table('cities')
            ->where('state_id', $state_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }
}

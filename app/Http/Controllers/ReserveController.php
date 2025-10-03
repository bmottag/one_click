<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReserveController extends Controller
{
    /**
     * Display the reserve view.
     */
    public function create(): View
    {
        return view('reserve.form');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'status' => ['required'],
            'contact_number' => 'required|string|max:15',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_status' => $request->status,
            'contact_number' => $request->contact_number,
            'password' => Hash::make($request->password),
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'role' => 'registered_user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

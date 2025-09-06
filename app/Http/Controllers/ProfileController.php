<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateEmailRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        // Rellenar los campos validados excepto la imagen
        $user->fill($request->safe()->except('image'));

        // Si cambia el email, limpiar verificación
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Manejar la imagen si se envió
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('avatars', 'public');

            // ⚠️ Si ya tiene imagen, la borramos para no llenar el storage
            if ($user->image && \Storage::disk('public')->exists($user->image)) {
                \Storage::disk('public')->delete($user->image);
            }

            $user->image = $imagePath;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'user' => $user
        ]);
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $user = $request->user();

        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Email updated successfully!',
            'user' => $user
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your account has been deleted. Goodbye!',
            ]);
        }

        return Redirect::to('/');
    }

}

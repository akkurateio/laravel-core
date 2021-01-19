<?php

namespace Akkurate\LaravelCore\Http\Controllers\Auth\Back;

use Akkurate\LaravelCore\Events\Auth\UserConfirmed;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Activate the user with given activation code.
     * @param string $token
     * @return string
     */
    public function verifyUser(string $token)
    {
        $user = user()->where('activation_token', $token)->first();
        if (empty($user)) {
            return redirect('/login');
        }
        $user->activated_at = Carbon::now();
        $user->email_verified_at = Carbon::now();
        $user->save();
        auth()->login($user);

        return redirect()->route('register.profile.edit');
    }

    public function editProfile()
    {
        return view('auth::complete-profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = user()->find(auth()->user()->id);

        $user->update([
            'is_active' => 1,
            'password' => Hash::make($validated['password']),
            'activation_token' => null,
            'firstname' => array_key_exists('firstname', $validated) ? $validated['firstname'] : auth()->user()->firstname,
            'lastname' => array_key_exists('lastname', $validated) ? $validated['lastname'] : auth()->user()->lastname
        ]);

        event(new UserConfirmed($user));

        return redirect(config('laravel-core.admin.route'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Notifications\EmailChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $originalEmail = $user->email;

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] ?: $user->password,
        ]);

        if ($originalEmail !== $user->email) {
            Notification::route('mail', $originalEmail)
                ->notify(new EmailChanged($user, $originalEmail));
        }

        return to_route('profile.edit')->with('success', 'Profile updated!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // echo "<pre>";
        // print_r($request->user()->id);
        // exit;
        return view('Users.profile', [
            'user' => $request->user(),
        ]);
    }


    public function update_profile(Request $request): RedirectResponse
    {
        // echo "<pre>";
        // print_r($request->input('firstname'));
        // exit;
        $request->validate([
            'firstname' => 'required',
            // 'email' => 'required',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find($request->user()->id);

        // print_r($user);
        // exit;
        $user->name = $request->input('firstname');
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = $image->getClientOriginalName();
            $path = "public/{$user->id}/{$imageName}";
            $image->storeAs("public/{$user->id}", $imageName);
            $user->image_path = "{$user->id}/{$imageName}";
        }
        // $user->image_path = $request->image_path->store('images', 'public');
        $user->save();

        return Redirect::route('profile');
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        print_r($request->file('image_path'));
        exit;

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

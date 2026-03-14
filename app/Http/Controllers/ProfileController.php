<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Update coaching state if coaching_admin
        if ($request->user()->role === 'coaching_admin') {
            $coaching = $request->user()->coaching;
            if (!$coaching) {
                // Fallback to email search if coaching_id is missing (though we fixed this)
                $coaching = \App\Models\Coaching::where('email', $request->user()->email)->first();
            }
            
            if ($coaching) {
                $data = [
                    'state' => $request->state,
                    'gst_number' => $request->gst_number,
                    'authorized_signatory' => $request->authorized_signatory,
                ];

                if ($request->hasFile('signatory_image')) {
                    $file = $request->file('signatory_image');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    
                    // Create directory if it doesn't exist
                    $path = public_path('uploads/signatories');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    $file->move($path, $filename);
                    $data['signatory_image'] = $filename;
                }

                $coaching->update($data);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

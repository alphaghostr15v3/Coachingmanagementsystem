<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coaching;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function edit()
    {
        $currentCoaching = Auth::user()->coaching ?? Coaching::first();
        return view('coaching.settings.edit', compact('currentCoaching'));
    }

    public function update(Request $request)
    {
        $coaching = Auth::user()->coaching ?? Coaching::first();

        $validated = $request->validate([
            'coaching_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'state' => 'required|string|max:100',
            'gst_number' => 'nullable|string|max:20',
            'authorized_signatory' => 'nullable|string|max:255',
            'signatory_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'coaching_name' => $validated['coaching_name'],
            'address' => $validated['address'],
            'state' => $validated['state'],
            'gst_number' => $validated['gst_number'],
            'authorized_signatory' => $validated['authorized_signatory'],
        ];

        if ($request->hasFile('signatory_image')) {
            $file = $request->file('signatory_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $path = public_path('uploads/signatories');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            $file->move($path, $filename);
            $data['signatory_image'] = $filename;
            
            // Delete old image if exists
            if ($coaching->signatory_image && file_exists(public_path('uploads/signatories/' . $coaching->signatory_image))) {
                @unlink(public_path('uploads/signatories/' . $coaching->signatory_image));
            }
        }

        $coaching->update($data);

        return redirect()->back()->with('success', 'Institute settings updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::latest()->get();
        return view('coaching.designations.index', compact('designations'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        Designation::create($request->all());
        return back()->with('success', 'Designation created successfully!');
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $designation->update($request->all());
        return back()->with('success', 'Designation updated successfully!');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return back()->with('success', 'Designation deleted successfully!');
    }
}

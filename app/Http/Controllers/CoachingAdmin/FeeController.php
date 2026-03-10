<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = Fee::with('student')->latest()->get();
        return view('coaching.fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('coaching.fees.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:tenant.students,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
            'date' => 'required|date',
        ]);

        Fee::create($request->all());

        return redirect()->route('coaching.fees.index')->with('success', 'Fee record added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fee $fee)
    {
        return view('coaching.fees.show', compact('fee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fee $fee)
    {
        $students = Student::all();
        return view('coaching.fees.edit', compact('fee', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:tenant.students,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
            'date' => 'required|date',
        ]);

        $fee->update($request->all());

        return redirect()->route('coaching.fees.index')->with('success', 'Fee record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee)
    {
        $fee->delete();
        return back()->with('success', 'Fee record removed.');
    }
}

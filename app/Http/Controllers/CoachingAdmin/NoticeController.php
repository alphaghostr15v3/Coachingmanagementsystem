<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->get();
        return view('coaching.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('coaching.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Notice::create($request->all());

        return redirect()->route('coaching.notices.index')->with('success', 'Notice posted successfully.');
    }

    public function edit(Notice $notice)
    {
        return view('coaching.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $notice->update($request->all());

        return redirect()->route('coaching.notices.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return back()->with('success', 'Notice removed successfully.');
    }
}

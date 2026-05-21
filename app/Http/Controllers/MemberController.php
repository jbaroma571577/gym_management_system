<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of members
     */
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store new member
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'phone' => 'nullable',
            'goal' => 'nullable',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Member created successfully');
    }

    /**
     * Show single member
     */
    public function show(string $id)
    {
        $member = Member::findOrFail($id);
        return view('admin.members.show', compact('member'));
    }

    /**
     * Edit form
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update member
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully');
    }

    /**
     * Delete member
     */
    public function destroy(string $id)
    {
        Member::destroy($id);

        return redirect()->route('members.index')->with('success', 'Member deleted');
    }
}
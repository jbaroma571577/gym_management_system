<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = User::where('role', 'trainer')
            ->withCount('assignedMembers')
            ->get();

        return view('admin.trainers', compact('trainers'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('user.feedback.index');
    }

    public function create()
    {
        return view('user.feedback.create');
    }

    public function store()
    {
        return back();
    }
}
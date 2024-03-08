<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index()
    {
        $likes = auth()->user()->likes()->with('blog')->get();


        return view('likes', compact('likes'));
    }
}

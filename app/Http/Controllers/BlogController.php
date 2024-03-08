<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Auth;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:3',
        ]);

        Auth::user()->blogs()->create($request->all());

        return redirect()->back()->with('success', 'Blog created successfully');
    }

    public function show($id)
    {
        $blog = Blog::with('comments')->with('likes')->find($id);

        return view('blog.show', compact('blog'));
    }

    public function like($id)
    {
        $blog = Blog::find($id);

        $like = $blog->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $blog->likes()->create([
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->back();
    }
    public function destroy($id)
    {
        $blog = Blog::find($id);

        $blog->delete();

        return redirect()->route('dashboard')->with('success', 'Blog deleted successfully');
    }
}

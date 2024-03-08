<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, string $blogId)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $blog = Blog::find($blogId);

        $blog->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Comment created successfully');
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }
}

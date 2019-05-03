<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $post = new Post();
        $post->title = $request->get('title');
        $post->save();

        return response()->json($post);
    }
}

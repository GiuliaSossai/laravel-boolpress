<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with(['category', 'tags'])->paginate(3);
        $tags = Tag::all();
        $categories = Category::all();

        return response()->json(compact('posts', 'categories', 'tags'));
    }

    public function show($slug){
        $post = Post::where('slug', $slug)->with(['category', 'tags'])->first();

        if(!$post){
            $post = ['title' => 'Dettagli non presenti', 'content' => ''];    
        }

        return response()->json($post);
    }
}

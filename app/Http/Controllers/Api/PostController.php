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

    //creo due funzioni per ottenere i post che hanno quel determinato tag/categoria - che mi serviranno per far funzionare i bottoni della sidebar

    public function getPostsByCategory($slug_cat){
        //prendo la categoria in base allo slug e in relazione alla tabella dei
        //inizializzo due variabili che mi servono nelle condizioni
        $category = Category::where('slug', $slug_cat)->with('posts.tags')->first();

        $success = true;
        $error = '';

        //se non trovo la categoria devo stampare un messaggio di errore
        //se c'è la categoria, ma non ci sono post a essa correlate, devo stampare un altro messaggio
        //altrimenti faccio il return dei post con quella categoria

        if(!$category){
            $success = false;
            $error = 'La categoria non esiste';
        } elseif($category && count($category['posts']) === 0){
            $success = false;
            $error = 'Non ci sono post per questa categoria';
        }

        return response()->json(compact('success', 'error', 'category'));
    }

    public function getPostsByTag($slug_tag){
        $tag = Tag::where('slug', $slug_tag)->with('posts.category')->first();
        $success = true;
        $error = '';

        if(!$tag){
            $success = false;
            $error = 'Il tag non esiste';
        } elseif($tag && count($tag['posts']) === 0){
            $success = false;
            $error = 'Non ci sono post con questo tag';
        }

        return response()->json(compact('tag', 'success', 'error'));
    }
}

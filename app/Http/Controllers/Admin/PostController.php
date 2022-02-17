<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(4);
        
        $categories = Category::all();
        
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        //file è proprietà di request - gli passo il file che mi aspetto e vado a vederlo
        //dd($request->file('cover')->getClientOriginalName());
        
        $request->validate(
            [
                'title'=>"required|min:2",
                'content'=>"min:3",
                'cover'=>"nullable|image|max:30000"
            ],
            [
                'title.required'=>'The title is compulsory',
                'title.min'=>'The title is too short',
                'content.min'=>'The description is too short',
                'cover.image'=>'File must be an image',
                'cover.max'=>'The file is too big'
            ]
        );

        $data = $request->all();

        //prima del fill e prima di salvare dentro controllare se l'immagine esiste
        if(array_key_exists('cover', $data)){
            //devo prendere il nome originale del file img, salvarlo e prenderne il percorso
            //prendo $data che dovrà essere fillato come ho messo nel model Post, gli assegno la chiave della tabella - sarà uguale al dd provato sopra (con getclientoriginal name per ottenere il nome) - così ho salvato il nome in data
            $data['original_cover_name'] = $request->file('cover')->getClientOriginalName();
            //per il percorso devo importare la facade Storage con metodo statico put, il file andrà quindi in una cartella che chiamo uploads (che crea laravel così) - e l'immagine che ho chiamato cover
            $image_path = Storage::put('uploads', $data['cover']);
            //faccio il fill del dato
            $data['cover'] = $image_path;
            
        }

        $new_post = new Post();
        //posso creare lo slug direttmente in $data
        $data['slug'] = Post::createSlug($data['title']);
        $new_post->fill($data);
        
        //$new_post->slug = Post::createSlug($new_post->title);
        
        $new_post->save();

        //per i tag: devo controllare che esista l'array tags; se esiste faccio l'attach. Dopo il save()!!
        if(array_key_exists('tags', $data)){
            $new_post->tags()->attach($data['tags']);
        }

        return redirect()->route('admin.posts.show', $new_post);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if($post){
           return view('admin.posts.show', compact('post')); 
        }
        //abort(404);
        abort(404, 'Il post che hai cercato non esiste');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $tags = Tag::all();
        
        $post = Post::find($id);
        if($post){
           return view('admin.posts.edit', compact('post', 'categories', 'tags')); 
        }
        abort(404, 'Il post che hai cercato non esiste');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title'=>"required|min:2",
                'content'=>"min:3",
                'cover'=>"nullable|image|max:30000"
            ],
            [
                'title.required'=>'The title is compulsory',
                'title.min'=>'The title is too short',
                'content.min'=>'The description is too short',
                'cover.image'=>'File must be an image',
                'cover.max'=>'The file is too big'
            ]
        );

        $data = $request->all();

        if(array_key_exists('cover', $data)){
            //elimino la vecchia immagine
            if($post->cover){
                Storage::delete($post->cover);
            }

            //come in store
            $data['original_cover_name'] = $request->file('cover')->getClientOriginalName();
            $img_path = Storage::put('uploads', $data['cover']);
            $data['cover'] = $img_path;
        }

        //controllo sullo slug:
        //genero un nuovo slug solo se il titolo del post è stato modificato
        if($data['title'] != $post->title){
            $data['slug'] = Post::createSlug($data['title']);
        }

        $post->update($data);

        //dopo update faccio sync e detach
        if(array_key_exists('tags', $data)){
            $post->tags()->sync($data['tags']);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //elimino l'immagine associata al post se c'è - altrimenti eliminerei sì il post ma nel db resterebbe l'immagine
        if($post->cover){
            Storage::delete($post->cover);
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')->with('deleted', "il post $post->title è stato eliminato con successo");
    }
}

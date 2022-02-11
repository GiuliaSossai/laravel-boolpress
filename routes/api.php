<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//metodo 1 posso scrivere le due rotte separate:
//Route::get('posts', 'Api\PostController@index');
//per vederla vado nella pagina guest e nell'url aggiungno api/posts

//Route::get('posts/{slug}', 'Api\PostController@show');

//oppure in modo più centralizzato:
Route::namespace('Api')
   ->prefix('posts')
   ->group(function(){
      Route::get('/', 'PostController@index');
      Route::get('{slug}', 'PostController@show');
   });



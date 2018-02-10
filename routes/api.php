<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('signup', 'AuthController@signup');
    Route::post('signin', 'AuthController@signin');
});

Route::group(['middleware'=>['api','CheckToken']], function(){
//Rotas basicas para notas
Route::get('notes', 'NoteController@index');
Route::get('notes/{id}', 'NoteController@showIndividualNote'); //mostra tags associadas tbm
Route::post('notes/add', 'NoteController@addNote');
Route::put('notes/update/{id}', 'NoteController@updateNote');
Route::delete('notes/delete/{id}', 'NoteController@deleteNote');

//Rotas basicas para tags
Route::get('tags', 'TagController@index');
Route::get('tags/{id}', 'TagController@showIndividualTag');
Route::post('tags/add', 'TagController@addTag');
Route::put('tags/update/{id}', 'TagController@updateTag');
Route::delete('tags/delete/{id}', 'TagController@deleteTag');

//rotas de busca
//Route::post('notes/search', 'NoteController@searchNote');
//Route::post('tags/search', 'TagController@searchTag');
});

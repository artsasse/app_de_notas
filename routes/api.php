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
//CRUD das notas
Route::get('notes', 'NoteController@index');
Route::post('notes/add', 'NoteController@addNote');
Route::put('notes/update/{id}', 'NoteController@updateNote');
Route::delete('notes/delete/{id}', 'NoteController@deleteNote');

//CRUD das tags
Route::get('tags', 'TagController@index');
Route::post('tags/add', 'TagController@addTag');
Route::put('tags/update/{id}', 'TagController@updateTag');
Route::delete('tags/delete/{id}', 'TagController@deleteTag');


//Rotas com relacionamento entre notas e tags
Route::get('notes/{id}', 'NoteController@showIndividualNote'); //mostra tags associadas
Route::get('tags/{id}', 'TagController@showIndividualTag'); //mostra as notas associadas

//TESTANDO
Route::post('notes/attach/{note_id}/{tag_id}', 'NoteController@attachTag');
Route::delete('notes/dettach/{note_id}/{tag_id}', 'NoteController@dettachTag');
//rotas de busca
//Route::post('notes/search', 'NoteController@searchNote');
//Route::post('tags/search', 'TagController@searchTag');

});

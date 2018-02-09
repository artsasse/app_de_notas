<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome'); //default laravel
});

Auth::routes();

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
Route::post('notes/search', 'NoteController@searchNote');
Route::post('tags/search', 'TagController@searchTag');

//acrescentar middleware!!!

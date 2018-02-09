<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Note;
use App\NoteTag;
use App\Tag;

class NoteController extends Controller
{
    //CRUD BASICO
    public function index()
    {
      $notes = Note::all();
      return view('notes', ['notes' => $notes]);
    }

    public function addNote(Request $request)
    {
      $newNote = new Note;

      $newNote->noteTitle = $request->noteTitle;
      $newNote->noteContent = $request->noteContent;

      $newNote->save();

      return back();
    }

    public function updateNote(Request $request, $id)
    {
      $updatedNote = Note::find($id);

      $updatedNote->noteTitle = $request->noteTitle;
      $updatedNote->noteContent = $request->noteContent;

      $updatedNote->save();

      return back();
    }

    public function deleteNote($id)
    {
      $deletedNote = Note::find($id);
      $deletedNote->delete();
      return back();
    }

    //FUNCOES EXTRAS
    public function showIndividualNote($id)
    {
      $individualNote = Note::find($id);

      $relation = NoteTag::where('note_id', $id)->get();
      $tagsId = $relation->tag_id;
      $relatedTags = Tag::where('id', $tagsId)->get();

      return view('individualNote', ['individualNote' => $individualNote, 'relatedTags' => $relatedTags]);
    }

    public function attachTag(Request $request, $id)
    {
      //ver como passar arrays pela URL
    }

    public function dettachTag($id)
    {

    }
}

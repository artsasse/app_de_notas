<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Tag;
use App\NoteTag;
use App\Note;

class TagController extends Controller
{
    //CRUD BASICO
    public function index()
    {
      $tags = Tag::all();
      return view('tags', ['tags' => $tags]);
    }

    public function addTag(Request $request)
    {
      $newTag = new Tag;

      $newTag->name = $request->name;

      $newTag->save();

      return back();
    }

    public function updateTag(Request $request, $id)
    {
      $updatedTag = Tag::find($id);

      $updatedTag->name = $request->name;

      $updatedTag->save();

      return back();
    }

    public function deleteTag($id)
    {
      $deletedTag = Tag::find($id);
      $deletedTag->delete();
      return back();
    }

    //FUNCOES EXTRAS
    public function showIndividualTag($id)
    {
      $individualTag = Tag::find($id);

      $relation = NoteTag::where('tag_id', $id)->get();
      $notesId = $relation->note_id;
      $relatedNotes = Notes::where('id', $notesId)->get();

      return view('individualTag', ['individualTag' => $individualTag, 'relatedNotes' => $relatedNotes]);
    }
}

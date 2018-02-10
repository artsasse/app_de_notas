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
      return response()->json(['tags' => $tags]);
    }

    public function addTag(Request $request)
    {
      $newTag = new Tag;

      $newTag->name = $request->name;

      $newTag->save();

      return response()->json(['message' => 'Tag criada com sucesso']);
    }

    public function updateTag(Request $request, $id)
    {
      $updatedTag = Tag::find($id);

      $updatedTag->name = $request->name;

      $updatedTag->save();

      return response()->json(['message' => 'Tag editada com sucesso']);
    }

    public function deleteTag($id)
    {
      $deletedTag = Tag::find($id);
      $deletedTag->delete();
      return response()->json(['message' => 'Tag deletada com sucesso']);
    }

    //FUNCOES EXTRAS
    public function showIndividualTag($id)
    {
      $individualTag = Tag::find($id);

      $relation = NoteTag::where('tag_id', $id)->get();
      $notesId = $relation->note_id;
      $relatedNotes = Notes::where('id', $notesId)->get();

      return response()->json(['individualTag' => $individualTag, 'relatedNotes' => $relatedNotes]);
    }
}

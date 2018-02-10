<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Note;
use App\NoteTag;
use App\Tag;
use Illuminate\Support\Collection;

class NoteController extends Controller
{
    //CRUD BASICO
    public function index()
    {
      $notes = Note::all();
      return response()->json(['notes' => $notes]);
    }

    public function addNote(Request $request)
    {
      $newNote = new Note;

      $newNote->noteTitle = $request->noteTitle;
      $newNote->noteContent = $request->noteContent;

      $newNote->save();

      return response()->json(['message' => 'Nota criada com sucesso']);
    }

    public function updateNote(Request $request, $id)
    {
      $updatedNote = Note::find($id);

      $updatedNote->noteTitle = $request->noteTitle;
      $updatedNote->noteContent = $request->noteContent;

      $updatedNote->save();

      return response()->json(['message' => 'Nota editada com sucesso']);
    }

    public function deleteNote($id)
    {
      $deletedNote = Note::find($id);
      $deletedNote->delete();
      return response()->json(['message' => 'Nota deletada com sucesso']);
    }

    //FUNCOES EXTRAS
    public function showIndividualNote($id)
    {
      $individualNote = Note::find($id);
      //encontra as linhas da tabela pivo(NoteTag) onde a nota escolhida participa
      $relations = NoteTag::where('note_id', $id)->get();
      $relatedTags = new Collection;

      //a partir das linhas da tabela pivo, agrupamos as tags associadas a nota escolhida
      foreach ($relations as $relation){
        $relatedTags->push(Tag::where('id', $relation->tag_id)->first());
      }

      //envia a instancia da nota escolhida e as instancias das tags associadas
      return response()->json(['individualNote' => $individualNote, 'relatedTags' => $relatedTags]);
    }

    //fixa uma tag a uma nota
    public function attachTag(Request $request, $id)
    {
      $newRelation = new NoteTag;
      $newRelation->note_id = $id;
      $newRelation->tag_id = $request->id;
      $newRelation->save();

      return response()->json(['message'=>'Nota marcada com sucesso']);
    }

    //Retira uma tag de uma nota q ela marcava
    public function dettachTag(Request $request, $id)
    {
      $relations = NoteTag::where('note_id', $id)->get();
      $deletedRelation = $relations->where('tag_id',$request->id)->first();
      $deletedRelation->delete();

      return response()->json(['message'=>'Nota desmarcada com sucesso']);
    }
}

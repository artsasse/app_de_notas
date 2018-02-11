<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Note;
use App\NoteTag;
use App\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    //CRUD BASICO
    public function index()
    {
      $notes = Note::where('user_id', Auth::user()->id)->get();
      return response()->json(['notes' => $notes]);
    }

    public function addNote(Request $request)
    {
      $newNote = new Note;

      $newNote->noteTitle = $request->noteTitle;
      $newNote->noteContent = $request->noteContent;
      $newNote->user_id = Auth::user()->id;

      $newNote->save();

      return response()->json(['message' => 'Nota criada com sucesso']);
    }

    public function updateNote(Request $request, $id)
    {
      $updatedNote = Note::where('user_id', Auth::user()->id)->findOrFail($id);

      $updatedNote->noteTitle = $request->noteTitle;
      $updatedNote->noteContent = $request->noteContent;

      $updatedNote->save();

      return response()->json(['message' => 'Nota editada com sucesso']);
    }

    public function deleteNote($id)
    {
      $deletedNote = Note::where('user_id', Auth::user()->id)->findOrFail($id);

      $deletedNote->delete();
      return response()->json(['message' => 'Nota deletada com sucesso']);
    }

    //FUNCOES EXTRAS
    public function showIndividualNote($id)
    {
      $individualNote = Note::where('user_id', Auth::user()->id)->findOrFail($id);
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
    public function attachTag($note_id, $tag_id)
    {
      Note::where('user_id', Auth::user()->id)->findOrFail($note_id);
      Tag::where('user_id', Auth::user()->id)->findOrFail($tag_id);
      $newRelation = new NoteTag;
      $newRelation->note_id = $note_id;
      $newRelation->tag_id = $tag_id;
      $newRelation->save();

      return response()->json(['message'=>'Nota marcada com sucesso']);
    }

    //Retira uma tag de uma nota q ela marcava
    public function dettachTag($note_id, $tag_id)
    {
      Note::where('user_id', Auth::user()->id)->findOrFail($note_id);
      Tag::where('user_id', Auth::user()->id)->findOrFail($tag_id);
      $relations = NoteTag::where('note_id', $note_id)->get();
      $deletedRelation = $relations->where('tag_id',$tag_id)->first();
      $deletedRelation->delete();

      return response()->json(['message'=>'Nota desmarcada com sucesso']);
    }

    /*
    *eu ainda quero fazer isso de uma maneira q seja possivel associar
    *e desassociar varias tags de uma vez
    */
}

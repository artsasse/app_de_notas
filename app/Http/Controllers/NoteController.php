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
      $relations = NoteTag::where('note_id', $id)->get();
      $tag_id_list = new Collection;
      $relatedTags = new Collection;
      //cria lista com ids de tags
      foreach ($relations as $relation){
        $tag_id_list->push($relation->tag_id);
      }
      //cria lista com as tags associadas a cada ID da lista de IDs das tags
      foreach($tag_id_list as $tag_id){
        $relatedTags->push(Tag::where('id',$tag_id)->first());
      }
      //AINDA DA PRA MELHORAR ESSE CODIGO

      return response()->json(['individualNote' => $individualNote, 'relatedTags' => $relatedTags]);
    }

    //fixa uma ou mais tags a uma nota
    public function attachTag(Request $request, $id)
    {
      foreach($request as $tag){
        $newRelation = new NoteTag;
        $newRelation->note_id = $id;
        $newRelation->tag_id = $tag->id;
        $newRelation->save();
      }
      return response()->json(['message'=>'Nota marcada com sucesso']);
    }

    //Retira uma ou mais tags das notas q elas marcavam
    public function dettachTag(Request $request, $id)
    {
      $relations = NoteTag::where('note_id', $id)->get();
      foreach($request as $tag){
        $deletedRelation = $relations->where('tag_id',$tag->id);
        $deletedRelation->delete();
      }
      return response()->json(['message'=>'Nota desmarcada com sucesso']);
    }
}

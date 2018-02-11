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
use App\Http\Requests\EditNote;

class NoteController extends Controller
{
    //CRUD BASICO

    //apresentar todas as notas do usuario logado
    public function index()
    {
      $notes = Note::where('user_id', Auth::user()->id)->get();
      return response()->json(['notes' => $notes]);
    }

    //criar nota com a id do usuario logado
    public function addNote(EditNote $request)
    {
      $newNote = new Note;

      $newNote->noteTitle = $request->input('noteTitle');
      $newNote->noteContent = $request->input('noteContent');
      $newNote->user_id = Auth::user()->id;

      $newNote->save();

      return response()->json(['message' => 'Nota criada com sucesso']);
    }

    //editar alguma das notas do usuario logado
    public function updateNote(EditNote $request, $id)
    {
      //verifica se a nota requirida pertence ao usuario logado
      $updatedNote = Note::where('user_id', Auth::user()->id)->findOrFail($id);

      $updatedNote->noteTitle = $request->input('noteTitle');
      $updatedNote->noteContent = $request->input('noteContent');

      $updatedNote->save();

      return response()->json(['message' => 'Nota editada com sucesso']);
    }

    //deletar alguma nota do usuario logado
    public function deleteNote($id)
    {
      //verifica se a nota requirida pertence ao usuario logado
      $deletedNote = Note::where('user_id', Auth::user()->id)->findOrFail($id);

      $deletedNote->delete();
      return response()->json(['message' => 'Nota deletada com sucesso']);
    }

    //FUNCOES EXTRAS

    //mostra a nota de maneira individual junto com suas tags
    public function showIndividualNote($id)
    {
      //verifica se a nota requirida pertence ao usuario logado
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
      //verifica se a nota e a tag pertencem ao usuario logado
      Note::where('user_id', Auth::user()->id)->findOrFail($note_id);
      Tag::where('user_id', Auth::user()->id)->findOrFail($tag_id);

      //cria uma nova linha na tabela pivo com a nota e a tag passadas na URL
      $newRelation = new NoteTag;
      $newRelation->note_id = $note_id;
      $newRelation->tag_id = $tag_id;
      $newRelation->save();

      return response()->json(['message'=>'Nota marcada com sucesso']);
    }

    //Retira uma tag de uma nota q ela marcava
    public function dettachTag($note_id, $tag_id)
    {
      //verifica se a nota e a tag pertencem ao usuario logado
      Note::where('user_id', Auth::user()->id)->findOrFail($note_id);
      Tag::where('user_id', Auth::user()->id)->findOrFail($tag_id);

      //deleta a linha da tabela pivo com a nota e a tag passadas na URL
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

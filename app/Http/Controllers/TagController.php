<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Tag;
use App\NoteTag;
use App\Note;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditTag;

class TagController extends Controller
{
    //CRUD BASICO
    public function index()
    {
      $tags = Tag::where('user_id', Auth::user()->id)->get();
      return response()->json(['tags' => $tags]);
    }

    public function addTag(EditTag $request)
    {
      $newTag = new Tag;

      $newTag->name = $request->input('name');
      $newTag->user_id = Auth::user()->id;

      $newTag->save();

      return response()->json(['message' => 'Tag criada com sucesso']);
    }

    public function updateTag(EditTag $request, $id)
    {
      $updatedTag = Tag::where('user_id', Auth::user()->id)->findOrFail($id);

      $updatedTag->name = $request->input('name');

      $updatedTag->save();

      return response()->json(['message' => 'Tag editada com sucesso']);
    }

    public function deleteTag($id)
    {
      $deletedTag = Tag::where('user_id', Auth::user()->id)->findOrFail($id);
      $deletedTag->delete();
      return response()->json(['message' => 'Tag deletada com sucesso']);
    }

    //FUNCOES EXTRAS
    public function showIndividualTag($id)
    {
      $individualTag = Tag::where('user_id', Auth::user()->id)->findOrFail($id);
      //encontra as linhas da tabela pivo(NoteTag) onde a tag escolhida participa
      $relations = NoteTag::where('tag_id', $id)->get();
      $relatedNotes = new Collection;
      //a partir das linhas da tabela pivo, agrupamos as notas associadas a tag escolhida
      foreach ($relations as $relation){
        $relatedNotes->push(Note::where('id', $relation->note_id)->first());
      }
      //envia a instancia da tag escolhida e as instancias das notas associadas
      return response()->json(['individualTag' => $individualTag, 'relatedNotes' => $relatedNotes]);
      //(talvez seja melhor enviar apenas a id e o nome das notas para carregar mais rapido)
      //(mas ai ja eh um problema de escalabilidade, algo pro futuro)
    }
}

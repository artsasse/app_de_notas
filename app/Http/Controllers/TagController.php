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

    //apresentar todas as tags do usuario logado
    public function index()
    {
      $tags = Tag::where('user_id', Auth::user()->id)->get();
      return response()->json(['tags' => $tags]);
    }

    //criar tag com a id do usuario logado
    public function addTag(EditTag $request)
    {
      $newTag = new Tag;

      $newTag->name = $request->input('name');
      $newTag->user_id = Auth::user()->id;

      $newTag->save();

      return response()->json(['message' => 'Tag criada com sucesso']);
    }

    //editar alguma das tags do usuario logado
    public function updateTag(EditTag $request, $id)
    {
      //verifica se a tag pertence ao usuario logado
      $updatedTag = Tag::where('user_id', Auth::user()->id)->findOrFail($id);

      $updatedTag->name = $request->input('name');

      $updatedTag->save();

      return response()->json(['message' => 'Tag editada com sucesso']);
    }

    //deletar alguma das tags do usuario logado
    public function deleteTag($id)
    {
      //verifica se a tag pertence ao usuario logado
      $deletedTag = Tag::where('user_id', Auth::user()->id)->findOrFail($id);
      $deletedTag->delete();
      return response()->json(['message' => 'Tag deletada com sucesso']);
    }

    //FUNCOES EXTRAS

    //mostra a tag de maneira individual junto com suas notas
    public function showIndividualTag($id)
    {
      //verifica se a tag pertence ao usuario logado
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
  use softDeletes;
  protected $dates = ['deleted_at'];
  protected $guarded = [];

  public function tags()
  {
    return $this->belongsToMany('App\Tag', 'note_tags', 'note_id', 'tag_id')->withTimestamps()->using('App\NoteTag');
  }

  public function user()
    {
        return $this->belongsTo('App\User');
    }
}

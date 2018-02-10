<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
  use softDeletes;
  protected $dates = ['deleted_at'];
  protected $guarded = [];

  public function notes()
  {
    return $this->belongsToMany('App\Note', 'note_tags', 'tag_id', 'note_id')->withTimestamps()->using('App\NoteTag');
  }

  public function user()
    {
        return $this->belongsTo('App\User');
    }
}

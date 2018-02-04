<?php

namespace App;

Use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NoteTag extends Pivot
{
    protected $table = 'note_tags';
    use softDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];
}

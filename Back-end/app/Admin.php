<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use Notifiable;

    protected $name;
    protected $email;

    public function __construct()
    {
      $this->name = config('admin.name');
      $this->email = config('admin.email');
    }
}

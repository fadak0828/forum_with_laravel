<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /* Relationships*/

    public function articles(){
      return $this->hasMany(Article::class, 'author_id');
    }

    public function comments(){
      return $this->hasMany(Comment::class, 'author_id');
    }



}

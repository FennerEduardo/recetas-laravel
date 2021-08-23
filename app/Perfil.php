<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfils';
    /** Relación de 1:1 de Usuario a Perfil inversa */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model{
     /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'perfiles';
    
    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable=[
        'nombre', 'descripcion', 'estatus'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}


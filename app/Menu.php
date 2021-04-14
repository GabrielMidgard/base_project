<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model{
     /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'menus';
    
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
        'fk_parent','title','name','is_heading','is_active','route','class_name','is_icon_class','icon', 'priority', 'active'
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


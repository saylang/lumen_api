<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=['name','display_name','description'];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }
}

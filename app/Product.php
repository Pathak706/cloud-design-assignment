<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function categoryRel()
    {
        return $this->belongsTo('\App\Category', 'category');
    }
}

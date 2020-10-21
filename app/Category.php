<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function path() {
        return '/category';
    }

    public function opPath() {
        return '/category/'. $this->id;
    }
}

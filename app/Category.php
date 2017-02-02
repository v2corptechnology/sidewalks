<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['shop_id', 'name'];

    public function items()
    {
        return $this->belongsToMany(\App\Item::class);
    }
}

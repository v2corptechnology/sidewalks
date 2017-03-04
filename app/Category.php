<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Marker;

class Category extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function items()
    {
        return $this->belongsToMany(\App\Item::class);
    }

    public function markers()
    {
        return $this->morphMany(Marker::class, 'markable');
    }

    public function getTitleAttribute()
    {
        return $this->name;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['user_id', 'shop_id', 'title', 'description', 'amount', 'symbol', 'quantity', 'images', 'extra'];

    protected $casts = ['amount' => 'float', 'images' => 'array', 'extra' => 'array'];

    public function categories()
    {
        return $this->belongsToMany(\App\Category::class);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = (int) $value * 100;
    }

    public function getAmountAttribute($value)
    {
        return (float) $value / 100;
    }
}

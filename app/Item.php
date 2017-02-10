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

    public function coverImage(string $size = '400x200')
    {
        preg_match("/(\d*)x(\d*)@?(\d)?/", $size, $params);
        $width = $params[1] * ($params[3] ?? 1);
        $height = $params[2] * ($params[3] ?? 1);

        return "https://e6vwrfe.cloudimg.io/crop/{$width}x{$height}/q80.tjpg/". asset("storage/items/originals/{$this->id}/{$this->images[0]}");
    }
}

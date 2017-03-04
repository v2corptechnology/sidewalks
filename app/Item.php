<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Marker;

class Item extends Model
{
    protected $fillable = ['user_id', 'path_id', 'title', 'description', 'amount', 'symbol', 'quantity', 'images', 'extra'];
    protected $casts = ['amount' => 'float', 'images' => 'array', 'extra' => 'array'];
    protected $appends = ['display_url', 'src', 'srcset'];

    public function categories()
    {
        return $this->belongsToMany(\App\Category::class);
    }
    
    public function markers()
    {
        return $this->morphMany(Marker::class, 'markable');
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = (int) $value * 100;
    }

    public function getAmountAttribute($value)
    {
        return (float) $value / 100;
    }

    public function getDisplayUrlAttribute()
    {
        return route('items.show', $this);
    }

    public function getSrcAttribute()
    {
        return $this->getImageSrc('400x200');
    }

    public function getsrcsetAttribute()
    {
        return $this->getImageSrc('400x200@2x') . ' 2x';
    }

    public function getImageSrc(string $size = '400x200')
    {
        preg_match("/(\d*)x(\d*)@?(\d)?/", $size, $params);
        $width = $params[1] * ($params[3] ?? 1);
        $height = $params[2] * ($params[3] ?? 1);

        return "https://eazkmue.cloudimg.io/crop/{$width}x{$height}/q80.tjpg/". asset("storage/items/originals/{$this->id}/{$this->images[0]}");
    }
}

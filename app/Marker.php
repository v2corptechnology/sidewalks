<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MarkersCollection;
use App\Item;

class Marker extends Model
{
    protected $fillable = ['shop_id', 'item_id', 'latitude', 'longitude', 'latitude_px', 'longitude_px'];

    protected $appends = ['psv_info'];

    public function item() 
    {
        return $this->belongsTo(Item::class);
    }

    public function getPsvInfoAttribute()
    {
        return [
            'image'   => asset('img/pin_green.svg'),
            'anchor'  => 'bottom center',
            'width'   => 32,
            'height'  => 32,
            'tooltip' => $this->item->title,
        ];   
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MarkersCollection;
use App\Item;

class Marker extends Model
{
    protected $fillable = ['shop_id', 'markable_id', 'markable_type', 'latitude', 'longitude', 'latitude_px', 'longitude_px'];

    protected $appends = ['psv_info'];

    public function markable()
    {
        return $this->morphTo();
    }

    public function getPsvInfoAttribute()
    {
        return [
            'image'   => asset('img/pin_green.svg'),
            'anchor'  => 'bottom center',
            'width'   => 32,
            'height'  => 32,
            'tooltip' => $this->markable->title,
        ];   
    }
}

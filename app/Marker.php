<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $fillable = ['panorama_id', 'markable_id', 'markable_type', 'latitude', 'longitude', 'latitude_px', 'longitude_px'];
    protected $appends = ['filter', 'psv_info'];

    public function panorama()
    {
        return $this->belognsTo(\App\Panorama::class);
    }

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

    public function getFilterAttribute()
    {
        return ucfirst($this->markable_type) . ': ' . $this->markable_id;
    }
}

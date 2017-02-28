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
            'id'        => $this->id,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'anchor'    => 'center center',
            'html'      => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
            'tooltip'   => "Walk here",
            'view_id'   => 3,
        ];   
    }

    public function getFilterAttribute()
    {
        return ucfirst($this->markable_type) . ': ' . $this->markable_id;
    }
}

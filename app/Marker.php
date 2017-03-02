<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $fillable = ['panorama_id', 'markable_id', 'markable_type', 'latitude', 'longitude', 'latitude_px', 'longitude_px'];
    protected $appends = ['anchor', 'html', 'tooltip', 'view_id'];

    public function panorama()
    {
        return $this->belognsTo(\App\Panorama::class);
    }

    public function markable()
    {
        return $this->morphTo();
    }

    public function getAnchorAttribute()
    {
        return 'center center';
    }

    public function getHtmlAttribute()
    {
        return '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-3x"></i>';
    }

    public function getTooltipAttribute()
    {
        return 'Walk here';
    }

    public function getViewIdAttribute()
    {
        return $this->markable_id;
    }
}

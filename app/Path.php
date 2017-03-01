<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Panorama;

class Path extends Model
{
    protected $fillable = ['user_id', 'name'];
    protected $appends = ['urls', 'mainPanoramaUrl'];

    public function panoramas()
    {
        return $this->hasMany(Panorama::class);
    }
    
    public function getUrlsAttribute()
    {
        return [
            'view' => route('paths.show', $this),
            'edit' => route('paths.edit', $this),
        ];
    }

    public function getMainPanoramaUrlAttribute()
    {
        if (! $this->panoramas->first()) 
            return null;

        return $this->panoramas->first()->imageUrl;
    }
}

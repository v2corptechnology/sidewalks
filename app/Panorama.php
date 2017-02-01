<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Markers;

class Panorama extends Model
{
    protected $fillable = ['picture'];

    public function markers()
    {
    	return $this->hasMany(Marker::class);
    }
}

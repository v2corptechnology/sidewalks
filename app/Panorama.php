<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Markers;

class Panorama extends Model
{
    protected $fillable = ['path_id', 'image', 'exif'];
    protected $appends = ['urls', 'imageUrl'];
    protected $casts = ['exif' => 'array'];

    public function path()
    {
        return $this->belongsTo(\App\Path::class);
    }

    public function markers()
    {
    	return $this->hasMany(Marker::class);
    }
    
    public function getImageUrlAttribute()
    {
        return asset('storage/panoramas/' . $this->image);
    }
    
    public function getUrlsAttribute()
    {
        return [
            'view' => route('panoramas.show', $this),
            'edit' => route('panoramas.edit', $this),
        ];
    }

    public function getGPSLongitudeAttribute() : float
    {
        return $this->getGps($this->exif["GPSLongitude"], $this->exif['GPSLongitudeRef']);
    }

    public function getGPSLatitudeAttribute() : float
    {
        return $this->getGps($this->exif["GPSLatitude"], $this->exif['GPSLatitudeRef']);
    }

    // http://stackoverflow.com/a/2572991/488620
    private function getGps($exifCoord, $hemi) 
    {
        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }

    private function gps2Num($coordPart) 
    {
        $parts = explode('/', $coordPart);

        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }
}

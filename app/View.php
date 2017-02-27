<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
	protected $fillable = ['path_id', 'image', 'exif'];
    protected $appends = ['urls'];
    protected $casts = ['exif' => 'array'];
    
    public function getUrlsAttribute()
    {
        return [
            'view' => route('views.show', $this),
            'edit' => route('views.edit', $this),
        ];
    }
}

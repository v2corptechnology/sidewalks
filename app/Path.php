<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\View;

class Path extends Model
{
	protected $fillable = ['name'];
	protected $appends = ['url'];

	public function views()
	{
	    return $this->hasMany(View::class);
	}
	
    public function getUrlAttribute()
    {
        return route('paths.show', $this);
    }
}

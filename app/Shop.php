<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use App\Item;
use App\Marker;
use App\Schedule;
use App\User;

class Shop extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'panorama'];

    protected $dates = ['deleted_at'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function items() 
    {
    	return $this->hasMany(Item::class);
    }

    public function markers() 
    {
        return $this->hasMany(Marker::class);
    }

    public function schedules() 
    {
        return $this->hasMany(Schedule::class)->orderBy('day_of_week', 'asc');
    }

    public function categories() 
    {
        return $this->hasMany(Category::class);
    }
}

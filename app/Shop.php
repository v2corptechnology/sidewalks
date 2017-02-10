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

    protected $fillable = ['name', 'phone', 'email', 'address', 'contact', 'panorama'];

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

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = \Crypt::encrypt($value);
    }

    public function getEmailAttribute($value)
    {
        return \Crypt::decrypt($value);
    }

    public function addressImage(string $size = '260x150', int $scale = 1)
    {
        return "//maps.googleapis.com/maps/api/staticmap?center=". urlencode($this->address) ."&zoom=13&size={$size}&maptype=roadmap&scale={$scale}&markers=". urlencode($this->address) ."&key=AIzaSyB7FyN9T9YarDU7F8ZCEXM0EAh6_2swL9A";
    }

}

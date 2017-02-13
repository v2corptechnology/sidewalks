<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MarkersCollection;
use App\Item;

class Marker extends Model
{
    protected $fillable = ['shop_id', 'item_id', 'latitude', 'longitude', 'latitude_px', 'longitude_px'];

    public function item() 
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new MarkerCollection($models);
    }
}

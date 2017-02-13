<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class MarkerCollection extends Collection
{
    public function toPSV() :string
    {
    	$this->load('item');

        return base64_encode($this->each(function($marker) {
            $marker->image = asset('img/pin_green.svg');
            $marker->anchor = "bottom center";
            $marker->width = 32;
            $marker->height = 32;
            $marker->title = $marker->item->title;
            $marker->tooltip = $marker->item->title;
        })->toJson());
    }
}

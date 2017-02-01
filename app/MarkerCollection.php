<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class MarkerCollection extends Collection
{
    public function toPSV() :string
    {
        return base64_encode($this->each(function($item) {
            $item->image = asset('img/pin_green.svg');
            $item->anchor = "bottom center";
            $item->width = 32;
            $item->height = 32;
        })->toJson());
    }
}

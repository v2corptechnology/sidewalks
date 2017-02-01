<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['shop_id', 'day_of_week', 'time_open', 'working_time'];
}

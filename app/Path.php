<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\View;

class Path extends Model
{
    protected $fillable = ['name'];
    protected $appends = ['urls'];

    public function views()
    {
        return $this->hasMany(View::class);
    }
    
    public function getUrlsAttribute()
    {
        return [
            'view' => route('paths.show', $this),
            'edit' => route('paths.edit', $this),
        ];
    }
}

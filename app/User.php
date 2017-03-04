<?php

namespace App;

use Laravel\Spark\User as SparkUser;
use App\Category;
use App\Shop;
use App\Path;

class User extends SparkUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'date',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function paths()
    {
        return $this->hasMany(Path::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function hasShop() :bool 
    {
        return (bool) $this->shop()->count();
    }
}

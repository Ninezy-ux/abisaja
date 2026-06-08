<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Many to Many (inverse): Category dimiliki banyak Campaign
     */
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_category');
    }
}

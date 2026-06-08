<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'campaign_id',
        'donor_name',
        'donor_email',
        'amount',
        'message',
    ];

    /**
     * One to Many (inverse): Donation milik satu Campaign
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}

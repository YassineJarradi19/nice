<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estimates extends Model
{
    use HasFactory;

    protected $table = 'estimates';

    // Declare the fields that are mass assignable
    protected $fillable = [
        'estimate_number',
        'type_demande',
        'estimate_date',
        'expiry_date',
        'other_information',
        'user_id'  // Add user_id to the fillable attributes
    ];

    /**
     * User relationship: An estimate belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

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
        'other_information'
    ];
}
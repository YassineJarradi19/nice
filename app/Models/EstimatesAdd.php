<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimatesAdd extends Model
{
    use HasFactory;
    protected $fillable = [
        'item',
        'estimate_number',
        'description',
        'qty',
        'motif'
    ];
    public function estimate()
    {
        return $this->belongsTo(Estimates::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estimates extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estimates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estimate_number',
        'type_demande',
        'estimate_date',
        'expiry_date',
        'status',
        'validators',
        'validation_orther',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'estimate_date' => 'date',
        'expiry_date' => 'date',
    ];


    /**
     * User relationship: An estimate belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(EstimatesAdd::class);
    }

    public function details()
    {
        return $this->hasMany(EstimateDetail::class);
    }


    public function validators()
    {
        return $this->belongsToMany(Validator::class, 'user_validator_assignments', 'estimate_id', 'validator_id');
    }
}

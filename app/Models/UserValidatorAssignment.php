<?php

// app/Models/UserValidatorAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserValidatorAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'validator_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(Validator::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Info extends Model
{
    use HasFactory;

    protected $table = "user_infos";

    protected $fillable = [
        'user_id',
        'verified_by',
    ];
}

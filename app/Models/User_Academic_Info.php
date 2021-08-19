<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Academic_Info extends Model
{
    use HasFactory;

    protected $table = "user_academic_infos";

    protected $fillable = [
        'user_id',
        'user_info_id',
        'user_academic_type',
        'user_class',
        'user_institute_name',
    ];
}

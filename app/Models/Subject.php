<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;

class Subject extends Model
{
    use HasFactory;

    protected $table = "subjects";

    protected $fillable = [
        'name',
        'class_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class ,'class_id');
    }
}

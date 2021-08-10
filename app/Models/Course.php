<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = "offer_courses";

    protected $fillable = [
        'class',
        'subject',
        'class_type',
        'start_time',
        'end_time',
        'day',
        'student_limit',
        'course_fee',
        'enrollment_last_date',
        'status',
    ];
}

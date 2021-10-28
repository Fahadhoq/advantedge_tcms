<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\Subject;

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

    public function classss()
    {
        return $this->belongsTo(Classes::class ,'class');
    }

    public function subjectss()
    {
        return $this->belongsTo(Subject::class ,'subject');
    }


}

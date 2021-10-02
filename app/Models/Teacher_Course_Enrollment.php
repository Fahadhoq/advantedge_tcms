<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Course;

class Teacher_Course_Enrollment extends Model
{
    use HasFactory;

    protected $table = "teacher_course_enrollments";

    protected $fillable = [
        'user_id',
        'course_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

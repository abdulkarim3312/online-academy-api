<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    use HasFactory;
    protected $table = 'course_details';
    protected $guarded = [];

    public function course_circullums(){
        return $this->hasMany(CourseCircullum::class);
    }
    public function course_requirements(){
        return $this->hasMany(CourseRequirement::class);
    }
}

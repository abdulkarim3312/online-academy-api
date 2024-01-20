<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOverview extends Model
{
    use HasFactory;
    protected $table = 'course_overviews';
    protected $guarded = [];
}

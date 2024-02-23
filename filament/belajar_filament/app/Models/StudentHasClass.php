<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHasClass extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    // public function homeroom(){
    //     return $this->belongsTo(HomeRoom::class, 'homerooms_id', 'id');
    // }

    public function classrooms(){
        return $this->belongsTo(Classroom::class, 'classrooms_id', 'id');
    }

    public function periode(){
        return $this->belongsTo(Periode::class, 'periode_id', 'id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'students_id', 'id');
    }
}

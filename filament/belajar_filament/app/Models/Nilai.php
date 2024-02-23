<?php

namespace App\Models;

use App\Models\Periode;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\CategoryNilai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id', 'id');

    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
        
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'id');
        
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
        
    }

    public function category_nilai(): BelongsTo
    {
        return $this->belongsTo(CategoryNilai::class, 'category_nilai_id', 'id');
        
    }
}

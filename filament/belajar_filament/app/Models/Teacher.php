<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['nip', 'name', 'address', 'profile'];

    protected $guarded = [];
    public function classroom(){
        return $this->hasMany(HomeRoom::class, 'teachers_id', 'id');
    }
}

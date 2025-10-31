<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
     protected $fillable = ['title', 'description', 'user_id'];
      public function teacher() {
        // Relation avec l'enseignant
        return $this->belongsTo(User::class, 'user_id');
    }  // Relation avec les étudiants (Many-to-Many)Les étudiants inscrits au cours
     public function students() {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Les cours que l'enseignant a créés
    public function coursesCreated() {
        return $this->hasMany(Course::class, 'user_id');
    }

    // Les cours où l'étudiant est inscrit
    public function coursesEnrolled() {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')
                    ->withTimestamps();
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

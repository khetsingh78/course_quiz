<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quizze extends Model
{
    protected $table = 'quizzes';
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(questions::class, 'quiz_id', 'id');
    }

    public function isTestAttempt()
    {
        return $this->hasOne(quiz_attempts::class, 'quiz_id');
    }
}

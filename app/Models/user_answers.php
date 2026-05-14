<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_answers extends Model
{
    //
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsTo(questions::class, 'question_id', 'id');
    }

    public function quizAttempt()
    {
        return $this->belongsTo(quiz_attempts::class, 'quiz_attempt_id');
    }
}

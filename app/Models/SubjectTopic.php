<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectTopic extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function lectures()
    {
        return $this->hasMany(SubjectTopicLecture::class);
    }
}

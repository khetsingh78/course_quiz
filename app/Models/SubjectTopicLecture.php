<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectTopicLecture extends Model
{

    use SoftDeletes;

    protected $guarded = [];
    public function topic()
    {
        return $this->belongsTo(SubjectTopic::class, 'subject_topic_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(options::class, 'question_id', 'id');
    }
}

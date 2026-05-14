<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'course_id', 'id');
    }
    public function quizzes()
    {
        return $this->hasMany(Quizze::class, 'course_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'course_id');
    }

  

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription_plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function subscripton_exam()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    'subject',
    'description',
    'category',
    'priority',
    'status'
];

// ටිකට්පත අයිති පරිශීලකයා
public function user()
{
    return $this->belongsTo(User::class);
}

// ටිකට්පතට අදාළ පිළිතුරු (Threaded discussion)
public function comments()
{
    return $this->hasMany(Comment::class);
}
}

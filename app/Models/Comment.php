<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   // app/Models/Comment.php

protected $fillable = [
    'ticket_id',
    'user_id',
    'body'
];

// පිළිතුර අදාළ වන ටිකට්පත
public function ticket()
{
    return $this->belongsTo(Ticket::class);
}

// පිළිතුර ලියූ පුද්ගලයා
public function user()
{
    return $this->belongsTo(User::class);
}
}

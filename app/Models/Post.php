<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);

        //return $this->likes()->where('user_id', $user->id)->exists();

        /*return Like::where('user_id', $user->id)
            ->where('post_id', $this->id)
            ->exists();*/
    }

    /*public function ownedBy(User $user)
    {
        return $user->id === $this->user_id;
    }*/
}

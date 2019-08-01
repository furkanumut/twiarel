<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }   

    public function article(){
        return $this->belongsTo(Article::class);
    }   

    public function comments(){
        return $this->hasMany(Comment::class,"parent_id");
    }

    public function comment(){
        return $this->belongsTo(Comment::class,"parent_id");
    }
}

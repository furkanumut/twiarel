<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $appends = array('summary', 'user');
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function delete() {
        $this->comments()->delete();
        $this->tags()->sync([]);
        return parent::delete();
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}

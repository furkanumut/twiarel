<?php

namespace App;

use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Followed;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'name', 'email', 'password', 'birth_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'birth_date',
    ];

    public function getAgeAttribute()
    {
        return $this->birth_date->age;
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followee_id');
    }

    public function followees()
    {
        return $this->belongsToMany(User::class, 'followers', 'followee_id', 'follower_id');
    }

    public function follow(User $user)
    {
        if ($this->isFollowing($user)) {
            return true;
        }
        $follow = $this->followees()->attach($user);
        $user->notify(new Followed($this));
        return true;
    }

    public function unfollow(User $user)
    {
        if (!$this->isFollowing($user)) {
            return true;
        }

        return $this->followees()->detach($user);
    }

    public function isFollowing(User $user)
    {
        return $this->followees->contains($user); //bu bunu içeriyormu diyesorar
    }

    public function commentedArticles()
    {
        return $this->belongsToMany(Article::class, 'comments','user_id','article_id')->groupBy('pivot_article_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // sync veya attach kullaancaksam eğer dışardan veri alabilmesini görebilmek için 
    // tag alanına izin verdik aksi taktirde firstOrCreate olayına izin vermez hataya düşerdi.
    protected $fillable = ['tag'];

    public function articles(){
        return $this->belongsToMany(Article::class);
    }

    public function getRouteKeyName()
    {
        return "tag";
    }
}
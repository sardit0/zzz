<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'foto',
        'url_video',
        'id_kategori',
    ];
    protected $table = 'film'; 

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class , 'id_kategori');
    }

    public function genre()
    {
        return $this->belongsToMany(Genre::class ,'genre_film','id_film','id_genre');
    }

    public function actor()
    {
        return $this->belongsToMany(Actor::class ,'actor_film','id_film','id_actor');
    }
}
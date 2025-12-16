<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeris';
    protected $primaryKey = 'galeri_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'nama',
        'kategori',
        'foto',
        'tahun',
        'instagram_dim',
        'link_instagram_dim',
        'instagram_dia',
        'link_instagram_dia',
        'deskripsi',
    ];
}

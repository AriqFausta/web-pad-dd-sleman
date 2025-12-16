<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'beritas';
    protected $primaryKey = 'berita_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'judul_berita',
        'kategori_id',
        'gambar_berita',
        'isi_berita',
        'carousel_active',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id', 'kategori_id');
    }
}

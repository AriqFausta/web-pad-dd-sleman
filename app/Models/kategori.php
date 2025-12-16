<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'kategori_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'nama_kategori',
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori_id', 'kategori_id');
    }
}

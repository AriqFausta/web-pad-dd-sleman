<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $table = 'organisasis';
    protected $primaryKey = 'organisasi_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'gambar_struktur_organisasi',
        'visi_misi',
    ];
    public function cards()
    {
        return $this->hasMany(Organisasi_Card::class, 'organisasi_id', 'organisasi_id');
    }
}

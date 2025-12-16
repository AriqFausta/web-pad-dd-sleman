<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class konten extends Model
{
    protected $table = 'kontens';
    protected $primaryKey = 'konten_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'judul',
        'icon',
        'deskripsi',
    ];
}

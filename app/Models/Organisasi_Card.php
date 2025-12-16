<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisasi_Card extends Model
{
    protected $table = 'organisasi__cards';
    protected $primaryKey = 'organisasi_card_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'organisasi_id',
        'foto',
        'nama',
        'jabatan',
    ];
    public function organisasi_card()
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id', 'organisasi_id');
    }
}

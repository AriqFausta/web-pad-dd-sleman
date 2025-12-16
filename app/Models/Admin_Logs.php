<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_Logs extends Model
{
    protected $table = 'admin_logs';
    protected $primaryKey = 'log_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // hanya created_at di migration

    protected $fillable = [
        'admin_id',
        'action',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}

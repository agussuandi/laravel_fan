<?php

namespace App\Models\Epresence;

use Illuminate\Database\Eloquent\Model;

class TrxEpresence extends Model
{
    protected $table = 'trx_epresence';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\Models\Users', 'id', 'users_id');
    }

    public function scopeAlreadyIn($query, $user)
    {
        return $query->where('users_id', $user)->where('type', 'IN')->whereDate('waktu', date('Y-m-d'));
    }

    public function scopeAlreadyOut($query, $user)
    {
        return $query->where('users_id', $user)->where('type', 'OUT')->whereDate('waktu', date('Y-m-d'));
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $guarded = [];

    public function jabatan(){
        $this->belongsTo(Jabatan::class, 'jabatan');
    }
}

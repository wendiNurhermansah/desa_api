<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    protected $table = 'rukun_warga';
    protected $guarded = [];

    public function kampung(){
        $this->belongsTo(Kampung::class, 'id_kampung');
    }
}

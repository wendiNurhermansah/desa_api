<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $table = 'rukun_tetangga';
    protected $guarded = [];

    public function kampung(){
        $this->belongsTo(Kampung::class, 'id_kampung');
    }
}

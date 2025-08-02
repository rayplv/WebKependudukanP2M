<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $table = 'pekerjaan';
    
    protected $fillable = [
        'nama'
    ];

    public function dataPribadi()
    {
        return $this->hasMany(DataPribadi::class, 'pekerjaan_id');
    }
}
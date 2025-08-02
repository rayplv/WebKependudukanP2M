<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendidikanTerakhir extends Model
{
    protected $table = 'pendidikan_terakhir';
    
    protected $fillable = [
        'nama'
    ];

    public function dataPribadi()
    {
        return $this->hasMany(DataPribadi::class, 'pendidikan_terakhir_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    protected $table = 'hubungan_keluarga';
    
    protected $fillable = [
        'nama'
    ];

    public function dataPribadi()
    {
        return $this->hasMany(DataPribadi::class, 'hubungan_keluarga_id');
    }
}
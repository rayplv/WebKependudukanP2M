<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKeluarga extends Model
{
    protected $table = 'data_keluarga';
    protected $primaryKey = 'no_kk';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'no_kk',
        'alamat',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'tanggal_dikeluarkan'
    ];

    protected $casts = [
        'tanggal_dikeluarkan' => 'date'
    ];

    public function anggotaKeluarga()
    {
        return $this->hasMany(DataPribadi::class, 'no_kk_id', 'no_kk');
    }

    public function kepalaKeluarga()
    {
        return $this->hasOne(DataPribadi::class, 'no_kk_id', 'no_kk')
                    ->whereHas('hubunganKeluarga', function($query) {
                        $query->where('nama', 'KEPALA KELUARGA');
                    });
    }
}
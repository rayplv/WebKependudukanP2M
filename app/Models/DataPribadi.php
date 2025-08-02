<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPribadi extends Model
{
    protected $table = 'data_pribadi';
    protected $primaryKey = 'nik';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'nik',
        'no_kk_id',
        'hubungan_keluarga_id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama_id',
        'status_perkawinan',
        'tanggal_perkawinan',
        'tanggal_perceraian',
        'pendidikan_terakhir_id',
        'pekerjaan_id',
        'kewarganegaraan',
        'penyandang_disabilitas',
        'nama_ayah',
        'nama_ibu'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_perkawinan' => 'date',
        'tanggal_perceraian' => 'date',
        'penyandang_disabilitas' => 'boolean'
    ];

    // Relasi ke data keluarga
    public function dataKeluarga()
    {
        return $this->belongsTo(DataKeluarga::class, 'no_kk_id', 'no_kk');
    }

    // Relasi ke hubungan keluarga
    public function hubunganKeluarga()
    {
        return $this->belongsTo(HubunganKeluarga::class, 'hubungan_keluarga_id');
    }

    // Relasi ke agama
    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    // Relasi ke pendidikan terakhir
    public function pendidikanTerakhir()
    {
        return $this->belongsTo(PendidikanTerakhir::class, 'pendidikan_terakhir_id');
    }

    // Relasi ke pekerjaan
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    // Scope untuk mencari berdasarkan NIK
    public function scopeByNik($query, $nik)
    {
        return $query->where('nik', $nik);
    }

    // Scope untuk mencari berdasarkan No KK
    public function scopeByNoKk($query, $noKk)
    {
        return $query->where('no_kk_id', $noKk);
    }

    // Accessor untuk umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    // Accessor untuk tempat tanggal lahir
    public function getTempatTanggalLahirAttribute()
    {
        if ($this->tempat_lahir && $this->tanggal_lahir) {
            return $this->tempat_lahir . ', ' . $this->tanggal_lahir->format('d F Y');
        }
        return null;
    }
}
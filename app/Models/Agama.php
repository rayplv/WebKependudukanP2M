<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agama';
    
    protected $fillable = [
        'nama'
    ];

    public function dataPribadi()
    {
        return $this->hasMany(DataPribadi::class, 'agama_id');
    }
}
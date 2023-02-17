<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'M_Karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nama',
        'no_ktp',
        'ttl',
        'jk',
        'agama',
        'gol_darah',
        'alamat',
        'no_telp',
        'id_user'
    ];

    function agama(){
        return $this->hasOne(Agama::class, 'id_agama', 'agama');
    }

    function jk(){
        return $this->hasOne(JenisKelamins::class, 'id', 'jk');
    }
}

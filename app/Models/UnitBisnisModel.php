<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitBisnisModel extends Model
{
    protected $table            = 'unit_bisnis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id', 'nama', 'tagline', 'wilayah', 'komoditas', 
        'kapasitas', 'alamat', 'phone', 'jam', 'maps', 
        'deskripsi', 'foto_sampul', 'dokumentasi'
    ];
}

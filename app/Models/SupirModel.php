<?php

namespace App\Models;

use CodeIgniter\Model;

class SupirModel extends Model
{
    protected $table            = 'supir';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama', 'telepon', 'nomor_kendaraan', 'status'
    ];
}

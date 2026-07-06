<?php

namespace App\Models;

use CodeIgniter\Model;

class PanenModel extends Model
{
    protected $table            = 'panen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'produk_id', 'user_id', 'volume', 'satuan', 'kualitas', 'tanggal_panen', 'catatan'
    ];
}

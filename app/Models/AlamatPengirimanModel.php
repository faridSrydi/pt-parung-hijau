<?php

namespace App\Models;

use CodeIgniter\Model;

class AlamatPengirimanModel extends Model
{
    protected $table            = 'alamat_pengiriman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id', 'recipient_name', 'phone', 'address_line', 'is_default'
    ];
}

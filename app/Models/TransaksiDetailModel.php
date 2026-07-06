<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table            = 'transaksi_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'transaksi_id', 'produk_id', 'qty', 'harga_satuan', 'subtotal'
    ];
}

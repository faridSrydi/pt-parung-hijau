<?php

namespace App\Models;

use CodeIgniter\Model;

class PengirimanModel extends Model
{
    protected $table            = 'pengiriman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'transaksi_id', 'metode_pengiriman', 'ekspedisi_nama', 
        'supir_id', 'nomor_resi', 'status_pengiriman', 
        'tanggal_kirim', 'tanggal_diterima', 'estimasi_tiba'
    ];
}

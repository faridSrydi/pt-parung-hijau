<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id', 'pelanggan_id', 'total_harga', 'recipient_name', 
        'recipient_phone', 'shipping_address', 'catatan_pengiriman', 
        'metode_pembayaran', 'status_pembayaran', 'bukti_transfer', 
        'is_ekspor', 'tanggal_transaksi'
    ];
}

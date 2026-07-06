<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id', 'parent_id', 'unit_bisnis_id', 'nama', 'harga', 
        'satuan', 'stok', 'image_path', 'gallery', 'deskripsi_singkat', 
        'deskripsi_lengkap', 'spesifikasi'
    ];
}

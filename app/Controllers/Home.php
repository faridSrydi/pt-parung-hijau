<?php

namespace App\Controllers;

use App\Models\UnitBisnisModel;

class Home extends BaseController
{
    public function index()
    {
        $unitModel = new UnitBisnisModel();
        $units = $unitModel->findAll();
        return view('home', [
            'title' => 'Home',
            'units' => $units
        ]);
    }

    public function tentangKami()
    {
        return view('tentang_kami', ['title' => 'Tentang Kami']);
    }

    public static function getDatabaseProductsFormatted()
    {
        $db = \Config\Database::connect();
        
        // Fetch all parent products (where parent_id is null)
        $parentProducts = $db->table('produk')
            ->where('parent_id', null)
            ->get()->getResultArray();

        $allProductsFormatted = [];

        $units = $db->table('unit_bisnis')->get()->getResultArray();
        $unitMap = [];
        foreach ($units as $u) {
            $unitMap[$u['id']] = $u['nama'];
        }

        foreach ($parentProducts as $parent) {
            $variants = $db->table('produk')
                ->where('parent_id', $parent['id'])
                ->get()->getResultArray();

            $categoryLabel = $unitMap[$parent['unit_bisnis_id']] ?? 'Lainnya';

            $specsDecoded = json_decode($parent['spesifikasi'] ?? '{}', true);
            $galleryDecoded = json_decode($parent['gallery'] ?? '[]', true) ?: [];

            $formatted = [
                'id'            => $parent['id'],
                'name'          => $parent['nama'],
                'category'      => $parent['unit_bisnis_id'],
                'categoryLabel' => $categoryLabel,
                'image'         => $parent['image_path'] ?? 'assets/images/produk/pisang.jpg',
                'gallery'       => $galleryDecoded,
                'shortDesc'     => $parent['deskripsi_singkat'],
                'desc'          => $parent['deskripsi_lengkap'],
                'specs'         => $specsDecoded ?: new \stdClass(),
            ];

            if (!empty($variants)) {
                $formatted['variants'] = [];
                foreach ($variants as $variant) {
                    $formatted['variants'][] = [
                        'id'       => $variant['id'],
                        'name'     => str_replace($parent['nama'] . ' ', '', $variant['nama']),
                        'price'    => (int)$variant['harga'],
                        'priceStr' => 'Rp ' . number_format($variant['harga'], 0, ',', '.')
                    ];
                }
            } else {
                $formatted['price'] = (int)$parent['harga'];
                $formatted['priceStr'] = 'Rp ' . number_format($parent['harga'], 0, ',', '.');
            }

            $allProductsFormatted[] = $formatted;
        }

        return $allProductsFormatted;
    }

    public function produkKami()
    {
        $db = \Config\Database::connect();
        $units = $db->table('unit_bisnis')->get()->getResultArray();
        return view('produk_kami', [
            'title'            => 'Produk Kami',
            'units'            => $units,
            'databaseProducts' => self::getDatabaseProductsFormatted()
        ]);
    }

    public function kontak()
    {
        return view('kontak', ['title' => 'Hubungi Kami']);
    }

    public function checkout()
    {
        return view('checkout', [
            'title'            => 'Checkout Pesanan',
            'databaseProducts' => self::getDatabaseProductsFormatted()
        ]);
    }

    public function prosesCheckout()
    {
        $json = $this->request->getJSON(true);
        if (!$json) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid payload']);
        }

        $userId = auth()->id();
        if (!$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $orderId = 'TRX-' . strtoupper(substr(uniqid(), -5));

        $totalHarga = 0;
        $detailsToInsert = [];
        $isAuto = $json['metode_pembayaran'] === 'auto';

        $totalQty = 0;
        foreach ($json['items'] as $item) {
            $prod = $db->table('produk')->where('id', $item['productId'])->get()->getRowArray();
            if ($prod) {
                $subtotal = $prod['harga'] * $item['qty'];
                $totalHarga += $subtotal;
                $totalQty += $item['qty'];

                $detailsToInsert[] = [
                    'transaksi_id' => $orderId,
                    'produk_id'    => $item['productId'],
                    'qty'          => $item['qty'],
                    'harga_satuan' => $prod['harga'],
                    'subtotal'     => $subtotal
                ];

                // Deduct stock immediately ONLY if auto-paid
                if ($isAuto) {
                    $db->table('produk')
                        ->where('id', $item['productId'])
                        ->update(['stok' => max(0, $prod['stok'] - $item['qty'])]);
                }
            }
        }

        // Insert Transaction
        $db->table('transaksi')->insert([
            'id'                 => $orderId,
            'pelanggan_id'       => $userId,
            'total_harga'        => $totalHarga,
            'recipient_name'     => $json['recipient_name'],
            'recipient_phone'    => $json['recipient_phone'],
            'shipping_address'   => $json['shipping_address'],
            'catatan_pengiriman' => $json['catatan_pengiriman'] ?? '',
            'metode_pembayaran'  => $json['metode_pembayaran'],
            'status_pembayaran'  => $isAuto ? 'Lunas' : 'Menunggu Pembayaran',
            'tanggal_transaksi'  => date('Y-m-d H:i:s')
        ]);

        // Insert Details
        if (!empty($detailsToInsert)) {
            $db->table('transaksi_detail')->insertBatch($detailsToInsert);
        }

        // Recommendation based on volume (>= 50 is manual, < 50 is ekspedisi)
        $method = ($totalQty >= 50) ? 'manual' : 'ekspedisi';
        $courier = ($method === 'ekspedisi') ? 'JNE' : '';

        // Insert Shipment
        $db->table('pengiriman')->insert([
            'transaksi_id'      => $orderId,
            'metode_pengiriman' => $method,
            'ekspedisi_nama'    => $courier,
            'status_pengiriman' => 'Menunggu Penjadwalan'
        ]);

        // Save address
        if (!empty($json['save_address'])) {
            $existing = $db->table('alamat_pengiriman')
                ->where('user_id', $userId)
                ->where('address_line', $json['shipping_address'])
                ->get()->getRow();
            if (!$existing) {
                $db->table('alamat_pengiriman')->insert([
                    'user_id'        => $userId,
                    'recipient_name' => $json['recipient_name'],
                    'phone'          => $json['recipient_phone'],
                    'address_line'   => $json['shipping_address'],
                    'is_default'     => 0
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save order']);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'orderId'  => $orderId,
            'total'    => $totalHarga,
            'redirect' => base_url('pelanggan/dashboard')
        ]);
    }

    public function cekStok()
    {
        $json = $this->request->getJSON(true);
        if (!$json || !isset($json['items'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Payload tidak valid']);
        }

        $db = \Config\Database::connect();
        $insufficientItems = [];

        foreach ($json['items'] as $item) {
            $prod = $db->table('produk')->where('id', $item['productId'])->get()->getRowArray();
            if (!$prod) {
                $insufficientItems[] = [
                    'productId' => $item['productId'],
                    'name'      => 'Produk tidak ditemukan',
                    'requested' => $item['qty'],
                    'available' => 0
                ];
            } elseif ($prod['stok'] < $item['qty']) {
                $insufficientItems[] = [
                    'productId' => $item['productId'],
                    'name'      => $prod['nama'],
                    'requested' => $item['qty'],
                    'available' => (int)$prod['stok']
                ];
            }
        }

        if (!empty($insufficientItems)) {
            return $this->response->setJSON([
                'status' => 'insufficient',
                'items'  => $insufficientItems
            ]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }
}

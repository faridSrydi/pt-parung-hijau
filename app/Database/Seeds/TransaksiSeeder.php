<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        // Get user_id for pelanggan_test
        $user = $this->db->table('users')->where('username', 'pelanggan_test')->get()->getRow();
        $pelangganId = $user ? $user->id : 4;

        $orders = [
            [
                'id'                 => 'TRX-1024',
                'pelanggan_id'       => $pelangganId,
                'total_harga'        => 7000000,
                'recipient_name'     => 'Budi Handoko',
                'recipient_phone'    => '0812345678',
                'shipping_address'   => 'Kebon Jeruk, Jakarta',
                'catatan_pengiriman' => 'Titip di satpam',
                'metode_pembayaran'  => 'auto',
                'status_pembayaran'  => 'Lunas',
                'bukti_transfer'     => null,
                'is_ekspor'          => 0,
                'tanggal_transaksi'  => date('Y-m-d H:i:s')
            ],
            [
                'id'                 => 'TRX-1025',
                'pelanggan_id'       => $pelangganId,
                'total_harga'        => 480000,
                'recipient_name'     => 'Siti Aminah',
                'recipient_phone'    => '08987654321',
                'shipping_address'   => 'Cisarua, Bogor',
                'catatan_pengiriman' => null,
                'metode_pembayaran'  => 'manual',
                'status_pembayaran'  => 'Lunas',
                'bukti_transfer'     => 'bukti1.jpg',
                'is_ekspor'          => 0,
                'tanggal_transaksi'  => date('Y-m-d H:i:s', strtotime('-1 hour'))
            ],
            [
                'id'                 => 'TRX-1027',
                'pelanggan_id'       => $pelangganId,
                'total_harga'        => 680000,
                'recipient_name'     => 'Joko Susilo',
                'recipient_phone'    => '0855667788',
                'shipping_address'   => 'Sawangan, Depok',
                'catatan_pengiriman' => 'Pagar hitam',
                'metode_pembayaran'  => 'auto',
                'status_pembayaran'  => 'Lunas',
                'bukti_transfer'     => null,
                'is_ekspor'          => 0,
                'tanggal_transaksi'  => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'id'                 => 'TRX-1021',
                'pelanggan_id'       => $pelangganId,
                'total_harga'        => 170000,
                'recipient_name'     => 'Dewi Lestari',
                'recipient_phone'    => '0899887766',
                'shipping_address'   => 'Pancoran, Jakarta',
                'catatan_pengiriman' => null,
                'metode_pembayaran'  => 'manual',
                'status_pembayaran'  => 'Lunas',
                'bukti_transfer'     => 'bukti2.jpg',
                'is_ekspor'          => 0,
                'tanggal_transaksi'  => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];

        foreach ($orders as $row) {
            $existing = $this->db->table('transaksi')->where('id', $row['id'])->get()->getRow();
            if (!$existing) {
                $this->db->table('transaksi')->insert($row);
            }
        }

        // Details
        $details = [
            [
                'transaksi_id' => 'TRX-1024',
                'produk_id'    => 'sungrow-cavendish-a',
                'qty'          => 200,
                'harga_satuan' => 35000,
                'subtotal'     => 7000000
            ],
            [
                'transaksi_id' => 'TRX-1025',
                'produk_id'    => 'chicken-eggs',
                'qty'          => 15,
                'harga_satuan' => 32000,
                'subtotal'     => 480000
            ],
            [
                'transaksi_id' => 'TRX-1027',
                'produk_id'    => 'chicken-kampung',
                'qty'          => 8,
                'harga_satuan' => 85000,
                'subtotal'     => 680000
            ],
            [
                'transaksi_id' => 'TRX-1021',
                'produk_id'    => 'waste-fertilizer',
                'qty'          => 10,
                'harga_satuan' => 15000,
                'subtotal'     => 150000
            ]
        ];

        foreach ($details as $row) {
            $existing = $this->db->table('transaksi_detail')
                ->where('transaksi_id', $row['transaksi_id'])
                ->where('produk_id', $row['produk_id'])
                ->get()->getRow();
            if (!$existing) {
                $this->db->table('transaksi_detail')->insert($row);
            }
        }

        // Deliveries
        $deliveries = [
            [
                'transaksi_id'      => 'TRX-1024',
                'metode_pengiriman' => 'manual',
                'ekspedisi_nama'    => null,
                'supir_id'          => 1,
                'nomor_resi'        => 'DEL-1024',
                'status_pengiriman' => 'Menunggu Penjadwalan',
                'tanggal_kirim'     => null,
                'tanggal_diterima'  => null,
                'estimasi_tiba'     => null
            ],
            [
                'transaksi_id'      => 'TRX-1025',
                'metode_pengiriman' => 'ekspedisi',
                'ekspedisi_nama'    => 'JNE Express',
                'supir_id'          => null,
                'nomor_resi'        => 'JN827391902',
                'status_pengiriman' => 'Dikirim',
                'tanggal_kirim'     => date('Y-m-d'),
                'tanggal_diterima'  => null,
                'estimasi_tiba'     => date('Y-m-d', strtotime('+2 days'))
            ],
            [
                'transaksi_id'      => 'TRX-1027',
                'metode_pengiriman' => 'ekspedisi',
                'ekspedisi_nama'    => 'GoSend',
                'supir_id'          => null,
                'nomor_resi'        => 'GK-982739',
                'status_pengiriman' => 'Dikirim',
                'tanggal_kirim'     => date('Y-m-d'),
                'tanggal_diterima'  => null,
                'estimasi_tiba'     => date('Y-m-d')
            ],
            [
                'transaksi_id'      => 'TRX-1021',
                'metode_pengiriman' => 'manual',
                'ekspedisi_nama'    => null,
                'supir_id'          => 2,
                'nomor_resi'        => 'DEL-1021',
                'status_pengiriman' => 'Selesai',
                'tanggal_kirim'     => date('Y-m-d', strtotime('-1 day')),
                'tanggal_diterima'  => date('Y-m-d', strtotime('-1 day')),
                'estimasi_tiba'     => date('Y-m-d', strtotime('-1 day'))
            ]
        ];

        foreach ($deliveries as $row) {
            $existing = $this->db->table('pengiriman')->where('transaksi_id', $row['transaksi_id'])->get()->getRow();
            if (!$existing) {
                $this->db->table('pengiriman')->insert($row);
            }
        }
    }
}

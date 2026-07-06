<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PanenSeeder extends Seeder
{
    public function run()
    {
        // Get user_id for produksi_test
        $user = $this->db->table('users')->where('username', 'produksi_test')->get()->getRow();
        $userId = $user ? $user->id : 2;

        $data = [
            [
                'produk_id'     => 'sungrow-cavendish-a',
                'user_id'       => $userId,
                'volume'        => 80,
                'satuan'        => 'Sisir',
                'kualitas'      => 'grade_a',
                'tanggal_panen' => date('Y-m-d'),
                'catatan'       => 'Kulit mulus, tingkat kematangan 75%'
            ],
            [
                'produk_id'     => 'chicken-kampung',
                'user_id'       => $userId,
                'volume'        => 150,
                'satuan'        => 'Ekor',
                'kualitas'      => 'grade_a',
                'tanggal_panen' => date('Y-m-d', strtotime('-1 day')),
                'catatan'       => 'Bobot rata-rata 1.2 kg per ekor, segar'
            ],
            [
                'produk_id'     => 'patin-segar',
                'user_id'       => $userId,
                'volume'        => 240,
                'satuan'        => 'Kg',
                'kualitas'      => 'grade_b',
                'tanggal_panen' => date('Y-m-d', strtotime('-2 days')),
                'catatan'       => 'Ukuran campur (3-4 ekor per kg)'
            ],
            [
                'produk_id'     => 'waste-fertilizer',
                'user_id'       => $userId,
                'volume'        => 300,
                'satuan'        => 'Pack',
                'kualitas'      => 'grade_a',
                'tanggal_panen' => date('Y-m-d', strtotime('-3 days')),
                'catatan'       => 'Kemasan kering 5kg, siap didistribusikan'
            ]
        ];

        foreach ($data as $row) {
            // Avoid duplicates
            $existing = $this->db->table('panen')
                ->where('produk_id', $row['produk_id'])
                ->where('tanggal_panen', $row['tanggal_panen'])
                ->get()->getRow();
            if (!$existing) {
                $this->db->table('panen')->insert($row);
            }
        }
    }
}

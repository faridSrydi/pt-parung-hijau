<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupirSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'            => 'Pak Jono',
                'telepon'         => '081234567890',
                'nomor_kendaraan' => 'B 9201 PH (Avanza Boks)',
                'status'          => 'Aktif'
            ],
            [
                'nama'            => 'Pak Mamat',
                'telepon'         => '089876543210',
                'nomor_kendaraan' => 'B 8911 PA (Pick Up)',
                'status'          => 'Aktif'
            ],
            [
                'nama'            => 'Pak Budi',
                'telepon'         => '085566778899',
                'nomor_kendaraan' => 'B 7733 PC (Blind Van)',
                'status'          => 'Aktif'
            ]
        ];

        foreach ($data as $row) {
            // Check if already exists
            $existing = $this->db->table('supir')->where('nama', $row['nama'])->get()->getRow();
            if (!$existing) {
                $this->db->table('supir')->insert($row);
            }
        }
    }
}

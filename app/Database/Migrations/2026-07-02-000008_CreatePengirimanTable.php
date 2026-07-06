<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengirimanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'transaksi_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'metode_pengiriman' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'ekspedisi_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'supir_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'nomor_resi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'status_pengiriman' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'tanggal_kirim' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tanggal_diterima' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'estimasi_tiba' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengiriman', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengiriman', true);
    }
}

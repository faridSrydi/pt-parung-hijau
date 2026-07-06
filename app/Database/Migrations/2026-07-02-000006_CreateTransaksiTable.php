<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'pelanggan_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'total_harga' => [
                'type' => 'INT',
            ],
            'recipient_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'recipient_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'shipping_address' => [
                'type' => 'TEXT',
            ],
            'catatan_pengiriman' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'metode_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'status_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'bukti_transfer' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'is_ekspor' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'tanggal_transaksi' => [
                'type' => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi', true);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi', true);
    }
}

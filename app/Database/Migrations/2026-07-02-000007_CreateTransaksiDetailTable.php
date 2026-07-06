<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiDetailTable extends Migration
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
            'produk_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'qty' => [
                'type' => 'INT',
            ],
            'harga_satuan' => [
                'type' => 'INT',
            ],
            'subtotal' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_detail', true);
    }
}

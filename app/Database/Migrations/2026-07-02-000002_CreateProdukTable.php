<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdukTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'parent_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'unit_bisnis_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'harga' => [
                'type' => 'INT',
            ],
            'satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'stok' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'gallery' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'deskripsi_singkat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'deskripsi_lengkap' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'spesifikasi' => [
                'type' => 'TEXT', // For JSON string storage
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('produk', true);
    }

    public function down()
    {
        $this->forge->dropTable('produk', true);
    }
}

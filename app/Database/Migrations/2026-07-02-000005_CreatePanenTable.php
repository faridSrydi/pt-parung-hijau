<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePanenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'produk_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'volume' => [
                'type' => 'INT',
            ],
            'satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'kualitas' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_panen' => [
                'type' => 'DATE',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('panen', true);
    }

    public function down()
    {
        $this->forge->dropTable('panen', true);
    }
}

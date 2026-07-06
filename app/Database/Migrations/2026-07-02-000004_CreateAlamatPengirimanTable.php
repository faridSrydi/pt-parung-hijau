<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlamatPengirimanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'recipient_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
              'null'       => true,
            ],
            'address_line' => [
                'type' => 'TEXT',
            ],
            'is_default' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('alamat_pengiriman', true);
    }

    public function down()
    {
        $this->forge->dropTable('alamat_pengiriman', true);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSupirTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nomor_kendaraan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('supir', true);
    }

    public function down()
    {
        $this->forge->dropTable('supir', true);
    }
}

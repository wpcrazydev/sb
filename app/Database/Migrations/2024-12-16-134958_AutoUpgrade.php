<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AutoUpgrade extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'package_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'upgrade_to' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auto_upgrade');
    }

    public function down()
    {
        $this->forge->dropTable('auto_upgrade');
    }
}

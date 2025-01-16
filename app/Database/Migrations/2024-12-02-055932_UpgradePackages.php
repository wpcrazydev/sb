<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpgradePackages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'direct_commission' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'mlm_commission' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'null' => true
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
        $this->forge->createTable('upgrade_packages');
    }

    public function down()
    {
        $this->forge->dropTable('upgrade_packages');
    }
}

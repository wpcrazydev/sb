<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Commission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'from_uid' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['direct', 'mlm', 'manual'],
                'null' => true
            ],
            'linked_order' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['verified', 'pending'],
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
        $this->forge->createTable('commission');
    }

    public function down()
    {
        $this->forge->dropTable('commission');
    }
}

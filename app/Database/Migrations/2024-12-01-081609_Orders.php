<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Orders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'txn_id' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'package_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'gateway' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['paid', 'pending'],
                'null' => true
            ],
            'temp_token' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Temporary token for storing user and upi payment encrypted data'
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
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}

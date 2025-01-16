<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Payouts extends Migration
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
                'null' => true
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid'],
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
        $this->forge->createTable('payouts');
    }

    public function down()
    {
        $this->forge->dropTable('payouts');
    }
}

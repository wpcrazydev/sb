<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'gateway' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'data' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('payment_log');
    }

    public function down()
    {
        $this->forge->dropTable('payment_log');
    }
}

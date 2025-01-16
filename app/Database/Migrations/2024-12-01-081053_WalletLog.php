<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WalletLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'uid' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['credit', 'debit'],
                'null' => true
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'updated_amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'balance' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'description' => [
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
        $this->forge->createTable('wallet_log');
    }

    public function down()
    {
        $this->forge->dropTable('wallet_log');
    }
}

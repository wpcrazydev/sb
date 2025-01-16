<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WalletOtp extends Migration
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
            'for' => [
                'type' => 'ENUM',
                'constraint' => ['transfer', 'order'],
                'null' => true
            ],
            'txn_id' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'otp' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'used'],
                'default' => 'pending'
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
        $this->forge->createTable('wallet_otp');
    }

    public function down()
    {
        $this->forge->dropTable('wallet_otp');
    }
}

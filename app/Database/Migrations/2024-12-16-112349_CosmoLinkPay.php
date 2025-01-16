<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CosmoLinkPay extends Migration
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
            'link' => [
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
        $this->forge->createTable('cosmo_link_pay');
    }

    public function down()
    {
        $this->forge->dropTable('cosmo_link_pay');
    }
}

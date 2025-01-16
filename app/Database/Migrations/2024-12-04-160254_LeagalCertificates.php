<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LeagalCertificates extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('leagal_certificates');
    }

    public function down()
    {
        $this->forge->dropTable('leagal_certificates');
    }
}

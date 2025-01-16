<?php

namespace App\Database\Migrations\Alter;

use CodeIgniter\Database\Migration;

class UpgradePackage extends Migration
{
    public function up()
    {
        $this->forge->addColumn('upgrade_packages', [
            'upgrade_from' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'id',
            ],
            'upgrade_to' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'upgrade_from',
            ]
        ]);
        $this->forge->dropColumn('upgrade_packages', ['image', 'name']);
    }

    public function down()
    {
        $this->forge->dropColumn('upgrade_packages', 'upgrade_from');
        $this->forge->dropColumn('upgrade_packages', 'upgrade_to');
    }
}

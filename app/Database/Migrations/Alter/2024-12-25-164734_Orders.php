<?php

namespace App\Database\Migrations\Alter;

use CodeIgniter\Database\Migration;

class Orders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [
            'payment_screenshot' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'txn_id',
            ],
            'payment_ref' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'payment_screenshot',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'payment_screenshot');
        $this->forge->dropColumn('orders', 'payment_ref');
    }
}

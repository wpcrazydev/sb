<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Common extends Seeder
{
    public function run()
    {
        $superAdmin = [
            'name' => 'Super Admin',
            'phone' => '8700145253',
            'email' => 'bizfunnel.online@gmail.com',
            'status' => 'active',
            'password' => password_hash('bizfunnel.online@gmail.com', PASSWORD_DEFAULT),
        ];
        $this->db->table('super_admins')->insert($superAdmin);

        $adminData = [
            'name' => 'Admin',
            'phone' => '8700145253',
            'email' => 'bizfunnel.online@gmail.com',
            'status' => 'active',
            'password' => password_hash('bizfunnel.online@gmail.com', PASSWORD_DEFAULT),
        ];
        $this->db->table('admins')->insert($adminData);

        $packageData = [
            'name' => 'Demo Package',
            'price' => 100,
            'direct_commission' => 50,
            'mlm_commission' => 25,
            'status' => 'active',
        ];
        $this->db->table('packages')->insert($packageData);
    }
}

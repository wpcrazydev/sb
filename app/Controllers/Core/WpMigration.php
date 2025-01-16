<?php

namespace App\Controllers\Core;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class WpMigration extends BaseController
{
    // @ioncube.dk dynamicHash("XOTvp52SV5VjjCat", "zbMJKxXanPTiHJ4V") -> "5a78d3e511e24f785cfefdacfa7496cefd98a36db374d77387cc9b03bd7fb98d"
    public function downloadSampleCsv()
    {
        $file = WRITEPATH . 'static/sample_csv.csv';
        if (file_exists($file)) {
            return $this->response->download($file, null);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File not found.']);
        }
    }

    // @ioncube.dk dynamicHash("VxkcyG0rYYS1DXed", "w6e6LzcQyAzDr8Ux") -> "d9589208e825003218a31d7e4d1c43e5bbada09677401d17ea7eb19f13ea7c2e"
    public function wpMigration()
    {
        if (env('WP_INSTALLED')) {
            return redirect()->to(env('app.superAdminURL').'/wp-migration')->with('error', 'WordPress Already Migrated.');
            exit;
        }
        $file = $this->request->getFile('wp_data');
        if (!$file) {
            return redirect()->to(env('app.superAdminURL').'/wp-migration')->with('error', 'No file uploaded.');
        }
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();
            if (($handle = fopen($filePath, 'r')) !== false) {
                $isFirstRow = true;
                $userModel = new \App\Models\Users();
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }
                    $data = [
                        'name' => $row[0],
                        'phone' => $row[1],
                        'email' => $row[2],
                        'password' => $row[3],
                        'ref_code' => $row[4],
                        'ref_by_code' => $row[5],
                        'wallet' => $row[6],
                        'paid' => $row[7],
                        'plan_id' => $row[8],
                        'plan_status' => $row[9],
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $userId = $userModel->insert($data);
                    $refCode = $row[4];
                    $refByCode = $row[5];
                    $parentUser = $userModel->where('ref_code', $refByCode)->first();
                    $data['parent_id'] = $parentUser ? $parentUser['id'] : null;
                    $userModel->update($userId, ['parent_id' => $data['parent_id']]);
                }
                fclose($handle);
                if($this->importCommissions()) {
                    return redirect()->to(env('app.superAdminURL').'/wp-migration')->with('success', 'Data imported successfully!');
                } else {
                    return redirect()->to(env('app.superAdminURL').'/wp-migration')->with('error', 'Failed to import commissions.');
                }
            } else {
                return redirect()->to(env('app.superAdminURL').'/wp-migration')->with('error', 'Failed to open the uploaded file.');
            }
        } else {
            return redirect()->to(env('app.superAdminURL').'/wp-migration')->with('error', 'Failed to upload the file.');
        }
    }

    // @ioncube.dk dynamicHash("PMjKK5lofHQNJwah", "2LivaA8Lkh6A2xHG") -> "82ade5153c18dbf2a57c2a585be9cd125023761f7518158138b7942653086c94"
    private function importCommissions() {
        $userModel = new \App\Models\Users();
        $commissionModel = new \App\Models\Commission();
        $users = $userModel->findAll();
        foreach ($users as $user) {
            $data = [
                'user_id' => $user['id'],
                'amount' => $user['wallet'] + $user['paid'],
                'type' => 'manual',
                'status' => 'verified',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $commissionModel->insert($data);
        }
        return true;
    }
}

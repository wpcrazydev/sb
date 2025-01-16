<?php

namespace App\Controllers\Core;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
include_once APPPATH. 'Controllers/CommonController.php';
class UpdateController extends ResourceController
{
    public function __construct()
    {
        $this->appController = new \App\Controllers\AppController();
        $this->encryption = \Config\Services::encrypter();
        $this->coreHome = new \App\Controllers\Core\HomeController();
    }

    // @ioncube.dk dynamicHash("Fl72J1UqNryblXub", "5x7YEdbkwl4za5S8") -> "687d8988e2e3dfae900cd1c6564dceca4ac15fffcd6cf8c7826c98f023de52ee"
    public function checkVersion()
    {
        $bizCheckResult = $this->appController->bizCheck();
        if ($bizCheckResult['status'] !== 'Active') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'License is not active.',
            ]);
        }
        $postData = json_encode(['version' => env('app.current_version')]);
        $apiEndpoint = 'https://api.bizfunnel.in/versionCheck/edtech';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        if ($curlError) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to check version. Please try again.',
            ]);
        }
        $responseData = json_decode($response, true);
        if (!$responseData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid response from server.',
            ]);
        }
        if ($responseData['status'] === 'success' && $responseData['isAvailable'] === true) {
            $tokenData = [
                'new_version' => $responseData['new_version'],
                'new_features_url' => $responseData['new_features_url'],
                'video_url' => $responseData['video_url'],
            ];
            if (file_put_contents(WRITEPATH . 'static/newUpdate.json', json_encode($tokenData))) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Version check completed successfully.',
                ]);
            }
        }
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Something went wrong.',
        ]);
    }

    // @ioncube.dk dynamicHash("59EJoTfPuVUc45mR", "wjgCEygz8dDmCDIy") -> "83c8a6bff9fa64b9514a9217bcb27de6d7f5fcadfa25fcebd7810a8eb06e1161"
    public function getNewVersion()
    {
        $bizCheckResult = $this->appController->bizCheck();
        if ($bizCheckResult['status'] === 'Active') {
            $newVersion = $this->coreHome->newVersionData();
            if ($newVersion['new_version'] > env('app.current_version')) {
                $postData = json_encode(['version' => $newVersion['new_version']]);
                $apiEndpoint = 'https://api.bizfunnel.in/getUpdate/edtech';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json'
                ]);
                $response = curl_exec($ch);
                curl_close($ch);
                $responseData = json_decode($response, true);
                if ($responseData['status'] === 'success' && isset($responseData['update_file_url'])) {
                    $upgradeFinalResult = $this->index($responseData);
                    $upgradeFinalResponse = $upgradeFinalResult->getBody();
                    $upgradeFinalData = json_decode($upgradeFinalResponse, true);
                    if ($upgradeFinalData['status'] === 'success') {
                        return $this->response->setJSON([
                            'status' => 'success',
                            'message' => 'Update completed successfully.',
                        ]);
                    }
                }
            }
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    // @ioncube.dk dynamicHash("HclWnrr6npIJay5F", "ut8ZLugLCPK2abeH") -> "1f8f2249e313fd853c24f3982aa30b6479449da44c85bda389018a40647ed30d"
    public function index($data = null)
    {
        if ($data === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No update data provided.'
            ]);
        }
        $currentVersion = env('app.current_version');
        if (version_compare($data['new_version'], $currentVersion, '>')) {
            $backupResult = (new \App\Controllers\superAdmin\HomeController())->generateBackup('AppDir', APPPATH);
            $backupResponse = $backupResult->getBody();
            $backupData = json_decode($backupResponse, true);
            if (!$backupData['success']) {
                return $this->response->setJSON(['status' => 'error', 'message' => $backupData['message']]);
            }
            $upgradeResult = $this->downloadAndUpdate($data['update_file_url']);
            $upgradeResponse = $upgradeResult->getBody();
            $upgradeData = json_decode($upgradeResponse, true);
            if ($upgradeData['status'] === 'success') {
                $runMigrationsResult = $this->runMigrations();
                $runMigrationsResponse = $runMigrationsResult->getBody();
                $runMigrationsData = json_decode($runMigrationsResponse, true);
                if ($runMigrationsData['status'] === 'success') {
                    $updateEnvResult = $this->appController->updateEnv('app.current_version', $data['new_version']);
                    if ($updateEnvResult) {
                        return $this->response->setJSON([
                            'status' => 'success',
                            'message' => 'Update completed successfully.'
                        ]);
                    }
                }
            }
        }
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No update available.'
        ]);
    }

    // @ioncube.dk dynamicHash("Z43Rp7BvNjsohrCe", "Zn3OTi5It47mjO7c") -> "e3415fe8d7fae59825270ab63cd1e9bd7719e0025d8830e22a44f070d66810e9"
    private function downloadAndUpdate($url)
    {
        $destPath = ROOTPATH . 'public/';
        $zipContent = file_get_contents($url);
        file_put_contents($destPath . 'upgrade.zip', $zipContent);
        $zip = new \ZipArchive();
        $zip->open($destPath . '/upgrade.zip');
        $zip->extractTo($destPath);
        $zip->close();
        $extractedFolder = glob($destPath . '/biz_*', GLOB_ONLYDIR);
        $extractedFolder = $extractedFolder[0];
        $move = $this->moveFiles($extractedFolder, ROOTPATH);
        $moveResponse = $move->getBody();
        $moveData = json_decode($moveResponse, true);
        if ($moveData['status'] === 'success') {
            $deleteResult = $this->deleteDirectory($extractedFolder);
            $deleteResponse = $deleteResult->getBody();
            $deleteData = json_decode($deleteResponse, true);
            if ($deleteData['status'] === 'success') {
                unlink($destPath . '/upgrade.zip');
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Update completed successfully.'
                ]);
            }
        }
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Failed to update.'
        ]);
    }

    // @ioncube.dk dynamicHash("dk0VuM9hvWETGiCv", "lPHeEjQ97v6MCJpV") -> "5f9301123d177d3b57537765db994d8a78f21d51224b6fd05cb8676fb4cd0cdb"
    private function moveFiles($src, $dest)
    {
        if (!is_dir($src)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Source directory does not exist: ' . $src
            ]);
        }

        $files = array_diff(scandir($src), ['.', '..']);
        foreach ($files as $file) {
            $filePath = "$src/$file";
            $destPath = "$dest/$file";

            if (is_dir($filePath)) {
                if (!is_dir($destPath) && !mkdir($destPath, 0755, true)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Failed to create directory: ' . $destPath
                    ]);
                }
                $this->moveFiles($filePath, $destPath);
            } else {
                if (!copy($filePath, $destPath)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Failed to copy file: ' . $filePath
                    ]);
                }
            }
        }
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Files moved successfully.'
        ]);
    }

    // @ioncube.dk dynamicHash("1ClAhjdjoi3awP0x", "WFdSgEj9SMr8YAcy") -> "7e5713ddc82800f816ac2eb1321520c2c1f5e04186d3b81efb35adc1df53f8fc"
    private function deleteDirectory($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = "$dir/$file";
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }
        rmdir($dir);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Directory deleted successfully: ' . $dir
        ]);
    }

    // @ioncube.dk dynamicHash("ij490UYwOQk7SALP", "MdJiuJVhuwYunbFh") -> "e8e4787716e75d570ef7b767b54510f966814e575cecc6a038d73f6da18be273"
    public function runMigrations()
    {
        $runner = service('migrations');
        try {
            $runner->latest();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Migrations executed successfully.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

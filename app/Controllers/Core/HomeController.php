<?php

namespace App\Controllers\Core;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class HomeController extends BaseController
{
    public function __construct()
    {
        $this->encryption = \Config\Services::encrypter();
        $this->app = new \App\Controllers\AppController();
    }

    public function newVersionData()
    {
        $data = json_decode(file_get_contents(WRITEPATH . 'static/newUpdate.json'), true);
        return $data;
    }

    // @ioncube.dk dynamicHash("wTxqzDwAtIgGpMPU", "OlsRwyApK6g6QBYT") -> "5fc49b2456b62cbb66e486f9623ca1ec011beceb581ac33b8c1848758cba37fd"
    public function licenseError()
    {
        $agencyLabel = (new \App\Controllers\HomeController())->agencyToken();
        $bizCheckResult = $this->app->bizCheck();
        if (env('CI_ENVIRONMENT') == 'development' && $bizCheckResult['status'] != 'Active') {
            unset($bizCheckResult['description']);
        }
        return view('licenseError', [
            'title' => 'License Error',
            'agencyLabel' => $agencyLabel,
            'bizCheckResult' => $bizCheckResult
        ]);
    }

    // @ioncube.dk dynamicHash("r3Nr1f2jxGS1IvG8", "k8LbJLmNs7wryPYp") -> "b300448b25e6448915a871c90953336e0af8928cedffc5b6dd460c10f174f7a5"
    public function checkVersion()
    {
        $this->app->checkLicense();
        $currentVersion = env('app.current_version');
        $newVersion = $this->newVersionData()['new_version'];
        if (version_compare($newVersion, $currentVersion, '>')) {
            return true;
        }
        return false;
    }
}

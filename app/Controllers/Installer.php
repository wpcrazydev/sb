<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\AppController;
include_once APPPATH. 'Controllers/CommonController.php';
class Installer extends BaseController
{
    public function __construct()
    {
        $this->rootPath = $_SERVER['REQUEST_URI'];
    }

    // @ioncube.dk dynamicHash("WRGCQUZdiCRLqhip", "pevU5YkCJBVj2dib") -> "cd81776d3e43c2dba394b8780c4d9d992ea7168321b16a220ba0d78e0266c8af"
    private function installerBranding()
    {
        $data['installerName'] = 'Edtech Installer';
        $data['installerBrand'] = 'Bizfunnel';
        $data['installerLogo'] = 'https://bizfunnel.in/wp-content/uploads/2024/11/2.png';
        return $data;
    }

    // @ioncube.dk dynamicHash("Yt4o9HnT1z2FgY5x", "9p4D5TlOazhfLZKd") -> "8a2bebf84c0a8e39fdca5444ed5f41c9bfa860244cec4adbabddf4835fe25591"
    public function index()
    {
        $data = $this->installerBranding();
        $data['title'] = 'Installer';
        $data['rootPath'] = $this->rootPath;
        $data['step'] = $this->request->getGet('step') ?? 0;
        $data['backUrl'] = $this->request->getGet('step') - 1 ?? '/';
        $data['session'] = session()->get();
        return view('installer/homePage', ['data' => $data]);
    }

    // @ioncube.dk dynamicHash("iHniwXXifEfcSoCs", "4RIYEebVXQDN6lGY") -> "6553b64ac33c7a99157427daf9a4c81454429af50e5e017f754a7fad79d1a927"
    private function convertToBytes($value)
    {
        $unit = strtoupper(substr($value, -1));
        $number = (int) $value;

        switch ($unit) {
            case 'K':
                return $number * 1024;
            case 'M':
                return $number * 1024 * 1024;
            case 'G':
                return $number * 1024 * 1024 * 1024;
            default:
                return $number;
        }
    }

    // @ioncube.dk dynamicHash("0K6NNJGNlTZbC2O7", "C49Jwz7o7dJnTMMZ") -> "5e49711246f8071c0fc3aed33242ef2115b97bc48a86710c4dafe8a4ebe868f2"
    public function checkRequirements ()
    {
        if (!session()->get('step_1')) {
            $data['compatible'] = true;
            $checks = [
                'PHP Version (8.1 or above)' => version_compare(PHP_VERSION, '8.1', '>=') ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
                'MySQLi Extension' => extension_loaded('mysqli') ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
                'Writable "writable/" Directory' => is_writable(WRITEPATH) ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
                'Memory Limit (256M or above)' => $this->convertToBytes(ini_get('memory_limit')) >= (256 * 1024 * 1024) ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
                'Upload Max Size (8M or above)' => $this->convertToBytes(ini_get('upload_max_filesize')) >= (8 * 1024 * 1024) ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
                'ionCube Loader' => extension_loaded('ionCube Loader') ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
                'HTTPS Enabled' => isset($_SERVER['HTTPS']) ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>',
            ];
            foreach ($checks as $key => $value) {
                if ($value == '<i class="bi bi-x-circle-fill text-danger"></i>') {
                    $data['compatible'] = false;
                    session()->set('step_1', false);
                }
            }
            if ($data['compatible']) {
                session()->set('step_1', true);
                return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Error in requirements', 'data' => $checks]);
        }
        return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
    }


    // @ioncube.dk dynamicHash("1hy6D7h6nmNzmKFn", "fEk5DQcOIhosqLZJ") -> "cb8443bd28de34dfd0e4f17bf03437f61bbb36f652c9331f4169a09b1c55043d"
    public function verifyKey()
    {
        if (!session()->get('step_1')) {
            return redirect()->to('/installer?step=1');
        }
        if (!session()->get('step_2')) {
            $data = $this->request->getJSON();
            $bizcheckResult = $this->bizCheck($data->license_key, $data->license_email);
            if ($bizcheckResult['status'] != 'Active') {
                session()->set('step_2', false);
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid license key or email', 'data' => $bizcheckResult]);
            }
            session()->set([
                'license_key' => $data->license_key,
                'license_email' => $data->license_email,
                'step_2' => true
            ]);
            return $this->response->setJSON(['success' => true, 'message' => 'License verified! Please continue to next step.']);
        }
        return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
    }


    // @ioncube.dk dynamicHash("iIFuTvFpB7DE4735", "XC9XkBaSQZ1HplyM") -> "4f1ff1a7e79b61e163ff006c0067af04443600e58e1f0f25b11ef8283e9f7582"
    public function checkDatabase()
    {
        if (!session()->get('step_1') && !session()->get('step_2')) {
            return redirect()->to('/installer?step=1');
        }
        if (!session()->get('step_3')) {
            $data = $this->request->getJSON();
            $dbConfig = [
                'DSN'      => '',
                'hostname' => $data->db_host,
                'username' => $data->db_user,
                'password' => $data->db_password,
                'database' => $data->db_name,
                'DBDriver' => 'MySQLi',
                'DBPrefix' => 'biz_',
                'pConnect' => false,
                'DBDebug'  => true,
                'charset'  => 'utf8',
                'DBCollat' => 'utf8_general_ci',
            ];
            log_message('info', print_r($dbConfig, true));
            $db = \Config\Database::connect($dbConfig);
            try {
                if ($db->connect()) {
                    session()->set([
                        'db_host' => $data->db_host,
                        'db_user' => $data->db_user,
                        'db_password' => $data->db_password,
                        'db_name' => $data->db_name,
                        'step_3' => true
                    ]);
                    return $this->response->setJSON(['success' => true, 'message' => 'Database connected! Please continue to next step.']);
                }
            } catch (\Exception $e) {
                session()->set('step_3', false);
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to connect to database: ' . $e->getMessage()]);
            }
        }
        return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
    }


    // @ioncube.dk dynamicHash("mlRgKrenToe276eq", "qm9bCLXiOltIdO9K") -> "c16846d4f90851dc4c4ae4253b6eba675b6311cb7b91cf5d202a5291035685d0"
    public function checkAdmin()
    {
        if (!session()->get('step_1') && !session()->get('step_2') && !session()->get('step_3')) {
            return redirect()->to('/installer?step=1');
        }
        if (!session()->get('step_4')) {
            $data = $this->request->getJSON();
            session()->set([
                'admin_name' => $data->admin_name,
                'admin_phone' => $data->admin_phone,
                'admin_email' => $data->admin_email,
                'admin_password' => password_hash($data->admin_password, PASSWORD_DEFAULT),
                'step_4' => true
            ]);
            return $this->response->setJSON(['success' => true, 'message' => 'Admin details verified! Please continue to next step.']);
        }
        return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
    }

    // @ioncube.dk dynamicHash("mk52nXK6RGF4htig", "eC7mYYmp4BJwZ75b") -> "c3093566fb32116698ecccaf5fc7564e0eebadaf96a0444e4e994a4d0c636f19"
    public function websiteDetails()
    {
        if (!session()->get('step_1') && !session()->get('step_2') && !session()->get('step_3') && !session()->get('step_4')) {
            return redirect()->to('/installer?step=1');
        }
        if (!session()->get('step_5')) {
            $data = $this->request->getJSON();
            session()->set([
                'website_name' => $data->website_name,
                'website_slogan' => $data->website_tagline,
                'website_url' => $data->website_url,
                'admin_url' => $data->admin_url,
                'super_admin_url' => $data->super_admin_url,
                'step_5' => true
            ]);
            return $this->response->setJSON(['success' => true, 'message' => 'Website details verified! Please continue to next step.']);
        }
        return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
    }

    // @ioncube.dk dynamicHash("z3HtE2xSPTEmM1kW", "85UD3JL4gnMo5jxx") -> "6ddc9bff51921e80f0788ef68d432f9e6881a853d455f828c529d4a559cc572b"
    public function finalize()
    {
        $data = $this->request->getJSON();
        if (!session()->get('step_1') && !session()->get('step_2') && !session()->get('step_3') && !session()->get('step_4') && !session()->get('step_5')) {
            return redirect()->to('/installer?step=1');
        }

        if (!session()->get('step_6')) {
            $data = $this->request->getJSON();
            if ($data->step == 1) {
                return $this->response->setJSON(['success' => true, 'message' => 'Provided details are correct. Going to next step.']);
            }
            if ($data->step == 2) {
                $app = new \App\Controllers\AppController();
                if ($app->updateEnv('app.license_key', session()->get('license_key'))) {
                    if ($app->updateEnv('app.license_email', session()->get('license_email'))) {
                        if ($app->updateEnv('database.default.hostname', session()->get('db_host'))) {
                            if ($app->updateEnv('database.default.username', session()->get('db_user'))) {
                                if ($app->updateEnv('database.default.password', session()->get('db_password'))) {
                                    if ($app->updateEnv('database.default.database', session()->get('db_name'))) {
                                        return $this->response->setJSON(['success' => true, 'message' => 'Environment setup complete. Going to next step.']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($data->step == 3) {
                $app = new \App\Controllers\AppController();
                if ($app->updateEnv('app.name', '"' . session()->get('website_name') . '"')) {
                    if ($app->updateEnv('app.slogan', '"' . session()->get('website_slogan')) . '"') {
                        if ($app->updateEnv('app.baseURL', '"' . session()->get('website_url') . '"')) {
                            if ($app->updateEnv('app.adminURL', session()->get('admin_url'))) {
                                if ($app->updateEnv('app.superAdminURL', session()->get('super_admin_url'))) {
                                    return $this->response->setJSON(['success' => true, 'message' => 'Website details setup complete! Going to next step.']);
                                }
                            }
                        }
                    }
                }
            }
            if ($data->step == 4) {
                if ($this->migrate()) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Database Migrated! Going to next step.']);
                }
            }
            if ($data->step == 5) {
                $superadmin = new \App\Models\SuperAdmins();
                if ($superadmin->insert([
                    'name' => session()->get('admin_name'),
                    'phone' => session()->get('admin_phone'),
                    'email' => session()->get('admin_email'),
                    'password' => session()->get('admin_password')
                ])) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Admin Account created! Going to next step.']);
                }
            }
            if ($data->step == 6) {
                session()->destroy();
                return $this->response->setJSON(['success' => true, 'message' => 'Congratulations! Your installation is complete.']);
            }
        }
        return $this->response->setJSON(['success' => true, 'message' => 'All Done! Please continue to next step.']);
    }

    // @ioncube.dk dynamicHash("NEMQMP2Y2CWnRWRi", "bdyFlTduSY7rlfae") -> "bb03bdb5b18419a06e17da29a7e81e0b681cb06640046161c7d4a98b32a46533"
    public function migrate()
    {
        $runner = service('migrations');
        try {
            $runner->latest();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // @ioncube.dk dynamicHash("sYH6KRNFIuN9apFq", "hmmLX1tcEtFRHZzZ") -> "d59a8095b5d1d571056fec5fedac47dd0f8cbb1a1a68a1672a6e13fa2e4b3a5d"
    public function bizCheck($licensekey = '', $licenseEmail = '')
    {
        $localkey = false;
        $whmcsurl = 'https://licensing.bizfunnel.in/';
        $licensing_secret_key = 'x71Uq8JWipNx9f7bU1Yf4V0Aa80wX6z9wY5lD_0aHg9ZvYQL7o30PkUl';
        $localkeydays = 10;
        $allowcheckfaildays = 5;
        $check_token = time() . md5(mt_rand(100000000, mt_getrandmax()) . $licensekey);
        $checkdate = date('Ymd');
        $domain = $_SERVER['SERVER_NAME'];
        $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
        $dirpath = dirname(__FILE__);
        $verifyfilepath = 'modules/servers/licensing/validate.php';
        $localkeyvalid = false;
        $originalcheckdate = null;
        if ($localkey) {
            $localkey = str_replace("\n", '', $localkey);
            $localdata = substr($localkey, 0, strlen($localkey) - 32);
            $md5hash = substr($localkey, strlen($localkey) - 32);
            if ($md5hash == md5($localdata . $licensing_secret_key)) {
                $localdata = strrev($localdata);
                $md5hash = substr($localdata, 0, 32);
                $localdata = substr($localdata, 32);
                $localdata = base64_decode($localdata);
                $localkeyresults = json_decode($localdata, true);
                $originalcheckdate = $localkeyresults['checkdate'];
                if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                    $localexpiry = date('Ymd', mktime(0, 0, 0, date('m'), date('d') - $localkeydays, date('Y')));
                    if ($originalcheckdate > $localexpiry) {
                        $localkeyvalid = true;
                        $results = $localkeyresults;
                        $validdomains = explode(',', $results['validdomain']);
                        if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                            $localkeyvalid = false;
                            $localkeyresults['status'] = 'Invalid';
                            $results = array();
                        }
                        $validips = explode(',', $results['validip']);
                        if (!in_array($usersip, $validips)) {
                            $localkeyvalid = false;
                            $localkeyresults['status'] = 'Invalid';
                            $results = array();
                        }
                        $validdirs = explode(',', $results['validdirectory']);
                        if (!in_array($dirpath, $validdirs)) {
                            $localkeyvalid = false;
                            $localkeyresults['status'] = 'Invalid';
                            $results = array();
                        }
                    }
                }
            }
        }
        if (!$localkeyvalid) {
            $responseCode = 0;
            $postfields = array('licensekey' => $licensekey, 'domain' => $domain, 'ip' => $usersip, 'dir' => $dirpath);
            if ($check_token) {
                $postfields['check_token'] = $check_token;
            }
            $query_string = '';
            foreach ($postfields as $k => $v) {
                $query_string .= $k . '=' . urlencode($v) . '&';
            }
            if (function_exists('curl_exec')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $whmcsurl . $verifyfilepath);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $data = curl_exec($ch);
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
            }
            if ($responseCode != 200) {
                $localexpiry = date('Ymd', mktime(0, 0, 0, date('m'), date('d') - ($localkeydays + $allowcheckfaildays), date('Y')));
                if ($originalcheckdate > $localexpiry) {
                    $results = $localkeyresults;
                } else {
                    $results = array();
                    $results['status'] = 'Invalid';
                    $results['description'] = 'Remote Check Failed';
                    return $results;
                }
            } else {
                $data = $this->decryptWithPublicKey($data);
                if ($data == null) {
                    $results = array();
                    $results['status'] = 'InvalidSignature';
                    $results['description'] = 'Signature Verification Failed';
                    return $results;
                }
                $data = $this->verifySignature($data);
                if ($data) {
                    preg_match_all('/<(.*?)>([^<]+)<\/\1>/i', $data, $matches);
                    $results = array();
                    foreach ($matches[1] as $k => $v) {
                        $results[$v] = $matches[2][$k];
                    }
                } else {
                    $results = array();
                    $results['status'] = 'InvalidSignature';
                    $results['description'] = 'Signature Verification Failed';
                    return $results;
                }
            }
            if (!is_array($results)) {
                $results['status'] = 'InvalidResponse';
                $results['description'] = 'Invalid License Server Response';
                return $results;
            }
            if (isset($results['md5hash'])) {
                if ($results['md5hash'] != md5($licensing_secret_key . $check_token . $licenseEmail)) {
                    $results['status'] = 'Invalid';
                    $results['description'] = 'MD5 Checksum Verification Failed';
                    return $results;
                }
            }
            if (isset($results['status']) && $results['status'] == 'Active') {
                $results['checkdate'] = $checkdate;
                $data_encoded = json_encode($results);
                $data_encoded = base64_encode($data_encoded);
                $data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
                $data_encoded = strrev($data_encoded);
                $data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
                $data_encoded = wordwrap($data_encoded, 80, "\n", true);
                $results['localkey'] = $data_encoded;

                (new \App\Controllers\AppController())->updateEnv('app.license_local_key', $results['localkey']);
            }
            $results['remotecheck'] = true;
        }
        unset($postfields, $data, $matches, $whmcsurl, $licensing_secret_key, $checkdate, $usersip, $localkeydays, $allowcheckfaildays, $md5hash);
        return $results;
    }

    // @ioncube.dk dynamicHash("WaoL1skubgLypi5E", "iXJOdHoMDXmb8mDe") -> "b5c88c5781cab100747a80cec8e865fe9774f6ff195462cd9be14d49e979e0a5"
    private function verifySignature($data)
    {
        $publicKey = file_get_contents(ROOTPATH . 'app/ThirdParty/publicKey.key');
        preg_match('/<signature>(.*?)<\/signature>/', $data, $matches);
        $signature = $matches[1];
        $data_without_signature = trim(preg_replace('/<signature>.*?<\/signature>/', '', $data));
        $signature = base64_decode($signature);
        $isValid = openssl_verify($data_without_signature, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        if ($isValid === 1) {
            return $data_without_signature;
        }
        return null;
    }

    // @ioncube.dk dynamicHash("LQxay6F0XXAPoyJv", "NpD5O1sgfByWvqFp") -> "17e12134ec28a6a0691b9cee52c6369c8dec67fcd07fb15fe48f340e200ab8cd"
    private function decryptWithPublicKey($encryptedData)
    {
        
        $publicKey = file_get_contents(ROOTPATH . 'app/ThirdParty/publicKey.key');
        if (empty($encryptedData)) {
            return '';
        }
        $decodedData = base64_decode($encryptedData);
        if ($decodedData === false) {
            return null;
        }
        $keyDetails = openssl_pkey_get_details(openssl_pkey_get_public($publicKey));
        if ($keyDetails === false) {
            return null;
        }
        $chunkSize = ceil($keyDetails['bits'] / 8);
        $chunks = str_split($decodedData, $chunkSize);
        $decrypted = '';
        foreach ($chunks as $chunk) {
            if (!openssl_public_decrypt($chunk, $partialDecrypted, $publicKey)) {
                return null;
            }
            $decrypted .= $partialDecrypted;
        }
        return $decrypted;
    }
}
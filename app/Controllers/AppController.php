<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class AppController extends BaseController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->response = \Config\Services::response();
        $this->encryption = \Config\Services::encrypter();
        $this->migration = \Config\Services::migrations();
        helper('text');
    }

    // @ioncube.dk dynamicHash("B1I2LCaWXXTKZ4wa", "ntA166QMjJcj0HhX") -> "edcd20dcddf2bfc3330a2b197fdeea95d6268bd3df983be9b9b27dc09dad7291"
    public function updateEnv($key, $value)
    {
        $envFile = ROOTPATH . '.env';
        if (!is_file($envFile) || !is_writable($envFile)) {
            log_message('error', 'Environment file is not writable');
            return false;
        }
        $value = str_replace(["\r", "\n"], '', $value);
        $content = file_get_contents($envFile);
        if (strpos($content, "$key=") === false) {
            log_message('error', "Environment key '$key' not found");
            return false;
        }
        $pattern = "/^{$key}=[\"']?(.*?)[\"']?$/m";
        $newContent = preg_replace($pattern, "{$key}={$value}", $content);
        if (file_put_contents($envFile, $newContent) === false) {
            log_message('error', 'Failed to write to environment file');
            return false;
        }
        return true;
    }

    // @ioncube.dk dynamicHash("s2Ym8gCxShoOfxC1", "fOyNDFsRag0HJ3c8") -> "57250c73b2bb52a7029d5a1d89a31b36fa17d1e62aaa76010f408ed7dc2856a6"
    public function bizCheck()
    {
        $licensekey = env('app.license_key');
        $localkey = env('app.license_local_key');
        $licenseEmail = env('app.license_email');
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
                $this->updateEnv('app.license_local_key', $results['localkey']);
            }
            $results['remotecheck'] = true;
        }
        unset($postfields, $data, $matches, $whmcsurl, $licensing_secret_key, $checkdate, $usersip, $localkeydays, $allowcheckfaildays, $md5hash);
        // log_message('info', print_r($results, true));
        return $results;
    }

    // @ioncube.dk dynamicHash("BexlnYfkpOgQhGf6", "NNrXJHYZDKbWZUxV") -> "4d219b85ac2967d2ed57539d6f1c5b9081b3a20c22ad5b15324f417330fd0c2d"
    public function checkLicense() 
    {
        $result = $this->bizCheck();
        if ($result['status'] == 'Active') {
            return true;
        }
        header('Location: /core/license-error');
        exit;
    }

    // @ioncube.dk dynamicHash("XeyCDtMCwWRlYEZf", "rKpbXkDr3ByFgbrT") -> "8e6d54c082c44c6dbf5b060d786669e677816cacad78b443ed4926d3e908c274"
    public function checkAddon($addonArray = [])
    {
        $homeController = new \App\Controllers\HomeController();
        if (empty($addonArray)) {
            return [];
        }
        $result = $this->bizCheck();
        $addonStatus = [];
        if ($result['status'] == 'Active') {
            if (isset($result['addons'])) {
                $addons = explode('|', $result['addons']);
                foreach ($addons as $addonString) {
                    parse_str(str_replace(';', '&', $addonString), $addonDetails);
                    if (in_array($addonDetails['name'], $addonArray)) {
                        $addonStatus[$addonDetails['name']] = $addonDetails['status'];
                        $addonStatus['badge'] = '<button type="button" class="badge btn btn-primary premium-badge"><i class="bi bi-pin-fill" style="margin-left: 0px;"></i> Premium</button> <a href="'.$homeController->agencyToken()['cart_url'].'" target="_blank" class="badge btn btn-outline-primary"><i class="bi bi-box-arrow-up-right" style="margin-left: 0px;"></i></a>';
                    }
                }
            }
        }
        foreach ($addonArray as $addon) {
            if (!isset($addonStatus[$addon])) {
                $addonStatus[$addon] = 'NA';
                $addonStatus['badge'] = '<button type="button" class="badge btn btn-primary premium-badge"><i class="bi bi-pin-fill" style="margin-left: 0px;"></i> Premium</button> <a href="'.$homeController->agencyToken()['cart_url'].'" target="_blank" class="badge btn btn-outline-primary"><i class="bi bi-box-arrow-up-right" style="margin-left: 0px;"></i></a>';
            }
        }
        return $addonStatus;
    }
    
    // @ioncube.dk dynamicHash("ZUCMYeuXMluXV4A8", "5w1EQzIOvHcChIey") -> "7d2604732f544dc6474b6f6373d8d2a89435a10f079fd6e68ef1d9d1c0fea03f"
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

    // @ioncube.dk dynamicHash("X76Mir25LbFuXBJe", "rRbbkM03xAMT5DLi") -> "f295b4737d330260506844f2c0aa502667df01189b59caf70be9476b389a5278"
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

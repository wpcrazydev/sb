<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class HomeController extends BaseController
{
    public function __construct()
    {
        $this->pager = \Config\Services::pager();
        $this->coreHome = new \App\Controllers\Core\HomeController();
        $this->app = new \App\Controllers\AppController();
        $this->encryption = \Config\Services::encrypter();
        $this->home = new \App\Controllers\HomeController();
    }

    // @ioncube.dk dynamicHash("bL4dmiwCdaMeIOIr", "0LL33rJcgndD2oF7") -> "903d9dcb1b49d8b364263fe86661cc78c5c77c214fb1bdce7cf5fd88071178c6"
    public function licenseRefresh()
    {
        if ($this->app->updateEnv('app.license_local_key', 'na')) {
            if ($result = $this->app->bizCheck()) {
                return $this->response->setJSON(['success' => true]);
            }
        }
        return $this->response->setJSON(['success' => false]);
    }

    // @ioncube.dk dynamicHash("jQkCZwuwHcJz5V3O", "cXYZE9vcBBdnR7Mg") -> "b4aca4357ec6fbf99bbafe31be1b87c20959142858529310852a04fd4e83d446"
    public function reissueLicense()
    {
        if ($result = $this->app->bizCheck()) {
            return $this->response->setJSON(['success' => true, 'message' => 'License refreshed']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Unable to refresh license']);
    }

    // @ioncube.dk dynamicHash("70eBdgLNxkWsS6JM", "OJeQZFOydVAva5fX") -> "88faa271b92a8fbe880d652c09b693f7c5b58397cfd90c5071a6f029bfd3222e"
    public function dashboard()
    {
        return view('superAdmin/dashboard', [
            'title' => 'Dashboard',
            'superAdminData' => $this->superAdminData,
            'isNewVersion' => $this->coreHome->checkVersion(),
            'licenseCheck' => $this->app->checkLicense(),
            'newVersion' => $this->coreHome->newVersionData()
        ] );
    }

    // @ioncube.dk dynamicHash("V8x4b4Pm6wZxV2hp", "8VktDkfSlD07GvY7") -> "0ea131f885648c10b128160bf43928160a62edab769cd1d3b082e9a43452a1aa"
    public function customizer()
    {
        return view('superAdmin/customizer', [
            'title' => 'Customizer',
            'superAdminData' => $this->superAdminData,
            'themeConfig' => require WRITEPATH . 'static/style.php'
        ]);
    }

    // @ioncube.dk dynamicHash("i2mdQm7bCxNcu2fd", "E0OmRcfy8he3mmnb") -> "0722c900a9145ceda839adfcbd8b1014f579dde838c0b88b6c26b604ddee0bf0"
    public function agencyArea()
    {
        return view('superAdmin/agencyArea', [
            'title' => 'Agency Area',
            'superAdminData' => $this->superAdminData,
            'agencyToken' => $this->home->agencyToken(),
            'addonStatus' => $this->app->checkAddon([
                'agency_area'
            ])
        ]);
    }

    // @ioncube.dk dynamicHash("czIs8xlfHwO8l9BP", "OpWcaSFNY2uhSYL9") -> "b29a26d32d59af00904a3416210b3a64fc490598253a336fd4dbd826d8614a4c"
    public function agencyTokenUpdate()
    {
        $data = $this->request->getPost();
        if (isset($data['csrf_token'])) {
            unset($data['csrf_token']);
        }
        $filePath = WRITEPATH . 'static/agency.json';
        foreach ($data as $key => $value) {
            $data[$key] = $this->encryption->encrypt($value);
        }
        if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
            return redirect()->to(env('app.superAdminURL') . '/agency')->with('success', 'Agency data updated');
        }
        return redirect()->to(env('app.superAdminURL') . '/agency')->with('error', 'Agency data not updated');
    }

    // @ioncube.dk dynamicHash("z8KZxJ3jNbxuPAs3", "6fxJEHd5AM5ee39G") -> "f878d7c1a483fe1bce995f4b7837c5d6eb15d5d55f485d31a4ebf270d0151c41"
    public function wpMigration()
    {
        return view('superAdmin/wpMigration', [
            'title' => 'WP Migration',
            'superAdminData' => $this->superAdminData,
            'agencyToken' => $this->home->agencyToken()
        ]);
    }

    // @ioncube.dk dynamicHash("iGtK0ZJGX2NXrk54", "e19HJb2isIHfJjH4") -> "cc07c90990a267073d61f162685258bbec9d20b7cd5be4a68476697690a17036"
    public function gatewaySetting()
    {
        return view('superAdmin/setting', [
            'title' => 'Setting',
            'superAdminData' => $this->superAdminData,
            'gateWays' => json_decode(file_get_contents(WRITEPATH . 'static/gateWays.json'), true)
        ]);
    }

    // @ioncube.dk dynamicHash("9acaqXOobXht5Dpv", "mZp2pjq3tDNKfqXd") -> "a0a05c3b90ab195141d7c785f74217530ddea8614052d7eff85ddafaa0ef97d1"
    public function gatewayUpdate()
    {
        $data = $this->request->getPost();
        if (isset($data['csrf_token'])) {
            unset($data['csrf_token']);
        }
        if (!isset($data['gateway'])) {
            return redirect()->to(env('app.superAdminURL') . '/setting')->with('error', 'Gateway not found');
        }
        $gateway = $data['gateway'];
        unset($data['gateway']);
        $filePath = WRITEPATH . 'static/gateWays.json';
        $existingData = json_decode(@file_get_contents($filePath), true);
        if ($existingData === null) {
            $existingData = ['gateways' => []];
        }
        $gatewayFound = false;
        foreach ($existingData['gateways'] as &$gatewayEntry) {
            if (isset($gatewayEntry['gateway']) && $gatewayEntry['gateway'] === $gateway) {
                $gatewayEntry['data'] = array_merge($gatewayEntry['data'], $data);
                $gatewayFound = true;
                break;
            }
        }
        if (!$gatewayFound) {
            $existingData['gateways'][] = [
                'gateway' => $gateway,
                'data' => $data
            ];
        }
        if (file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT))) {
            return redirect()->to(env('app.superAdminURL') . '/setting')->with('success', 'Setting data updated');
        }
        return redirect()->to(env('app.superAdminURL') . '/setting')->with('error', 'Setting data not updated');
    }

    // @ioncube.dk dynamicHash("pNQoEACodWqdABcf", "NryL9gtnB3fpcsHj") -> "d435a0778e36a523e70f6934b594b31f879f7883da07352a4a9c7753b179d22b"
    public function generateBackup($zipname, $sourcePath)
    {
        $zip = new \ZipArchive();
        $zipFileName = WRITEPATH . 'backup/' . $zipname . '_' . env('app.name') . '_' . date('Y-m-d_H-i-s') . '.zip';
        if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $this->addFolderToZip($sourcePath, $zip);
            $zip->close();
            return $this->response->setJSON(['success' => true, 'message' => 'Backup created']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to create the ZIP file.']);
        }
    }

    // @ioncube.dk dynamicHash("qY3tF0WtSUxs3mnw", "Ah4inJiyAF4AXUHA") -> "6262b0a5db89575d8374742cc1af87a22fdf1afe795520583b319d6a09b0a004"
    private function addFolderToZip($folderPath, \ZipArchive $zip, $zipPath = '')
    {
        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $fullPath = $folderPath . DIRECTORY_SEPARATOR . $file;
            $localPath = $zipPath . $file;
            if (is_dir($fullPath)) {
                $zip->addEmptyDir($localPath);
                $this->addFolderToZip($fullPath, $zip, $localPath . '/');
            } else {
                $zip->addFile($fullPath, $localPath);
            }
        }
    }

    // @ioncube.dk dynamicHash("G9paRGSHdnHtLtWD", "s70qML760doYfeSN") -> "4af90cc634e6b866201298270bf0f9084bcd143c42aa70e8bb2ee3e00d3fe759"
    public function updateLogo()
    {
        $data = $this->request->getPost();
        $logoPath = ROOTPATH . 'public/logo/';
        
        if (is_dir($logoPath)) {
            $files = glob($logoPath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        } else {
            mkdir($logoPath, 0777, true);
        }

        $rules = [
            'favicon' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[favicon]',
                    'is_image[favicon]',
                    'max_size[favicon,5120]',
                    'mime_in[favicon,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'light_logo' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[light_logo]',
                    'is_image[light_logo]',
                    'max_size[light_logo,5120]',
                    'mime_in[light_logo,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'dark_logo' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[dark_logo]',
                    'is_image[dark_logo]',
                    'max_size[dark_logo,5120]',
                    'mime_in[dark_logo,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->to(env('app.superAdminURL') . '/setting')->with('error', 'Logo not updated');
        }
    
        $favicon = $this->request->getFile('favicon');
        if ($favicon->isValid() && !$favicon->hasMoved()) {
            $newFavicon = $favicon->getRandomName();
            $favicon->move($logoPath, $newFavicon);
            $data['favicon'] = $newFavicon;
        }
    
        $lightLogo = $this->request->getFile('light_logo');
        if ($lightLogo->isValid() && !$lightLogo->hasMoved()) {
            $newLightLogo = $lightLogo->getRandomName();
            $lightLogo->move($logoPath, $newLightLogo);
            $data['light_logo'] = $newLightLogo;
        }
    
        $darkLogo = $this->request->getFile('dark_logo');
        if ($darkLogo->isValid() && !$darkLogo->hasMoved()) {
            $newDarkLogo = $darkLogo->getRandomName();
            $darkLogo->move($logoPath, $newDarkLogo);
            $data['dark_logo'] = $newDarkLogo;
        }
    
        $logoData = [
            'favicon' => $data['favicon'],
            'light_logo' => $data['light_logo'],
            'dark_logo' => $data['dark_logo']
        ];
    
        foreach ($logoData as $key => $value) {
            if (!$this->app->updateEnv($key, $value)) {
                return redirect()->to(env('app.superAdminURL') . '/setting')->with('error', 'Logo not updated');
            }
        }
        return redirect()->to(env('app.superAdminURL') . '/setting')->with('success', 'Logo updated successfully');
    }

    // @ioncube.dk dynamicHash("Ab5X3cGZyQ8dZvRO", "bGTUdi4yxHy7cfX0") -> "4a865b6bc6279406bd66824b810d03e48cc8770be7abdc6f742a4127aedb223a"
    public function updateNameUrl()
    {
        $data = $this->request->getPost();
        $dataToUpdate = [
            'app.name' => '"' . $data['website_name'] . '"',
            'app.slogan' => '"' . $data['website_tagline'] . '"',
            'app.baseURL' => '"' . $data['website_url'] . '"',
            'app.adminURL' => $data['admin_url'],
            'app.superAdminURL' => $data['super_admin_url'],
            'REFCODE_PREFIX' => $data['refcode_prefix']
        ];
        foreach ($dataToUpdate as $key => $value) {
            if (!$this->app->updateEnv($key, $value)) {
                return redirect()->to(env('app.superAdminURL') . '/setting')->with('error', 'Name and URL not updated');
            }
        }
        return redirect()->to($data['super_admin_url'] . '/setting')->with('success', 'Name and URL updated successfully');
    }

    // @ioncube.dk dynamicHash("W4AgLERSApWyPOiN", "FRAJ0BEH8FfqWGaZ") -> "6e9c3a83f374645589a13e6106c2312ce263527e0e998dbca2ab919e09347be2"
    public function updateEmailCredentails()
    {
        $data = $this->request->getPost();
        $dataToUpdate = [
            'email.fromEmail' => $data['from_email'],
            'email.fromName' => '"' . $data['from_name'] . '"',
            'email.SMTPHost' => $data['smtp_host'],
            'email.SMTPUser' => $data['smtp_username'],
            'email.SMTPPass' => $data['smtp_password'],
            'email.SMTPPort' => $data['smtp_port'],
            'email.SMTPCrypto' => $data['smtp_encryption'],
        ];
        foreach ($dataToUpdate as $key => $value) {
            if (!$this->app->updateEnv($key, $value)) {
                return redirect()->to(env('app.superAdminURL') . '/setting')->with('error', 'Email credentials not updated');
            }
        }
        return redirect()->to(env('app.superAdminURL') . '/setting')->with('success', 'Email credentials updated successfully');
    }

    // @ioncube.dk dynamicHash("rAvttrhFPQJgYHdF", "pPiee4WAesUE6AO5") -> "c9898fa7e3b1d689184b4ac24a909be88dac885e93a55c117a77d58d555434c0"
    public function updateTheme()
    {
        $data = $this->request->getPost();
        $file = $this->request->getFile('theme_file');
        $rules = [
            'theme_file' => [
                'label' => 'Theme File',
                'rules' => [
                    'uploaded[theme_file]',
                    'mime_in[theme_file,application/zip]'
                ],
            ],
            'theme_type' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        if (!$file->isValid() || $file->getExtension() !== 'zip') {
            return redirect()->back()->with('error', 'Please upload a valid ZIP file');
        }
        if ($data['theme_type'] === 'site') {
            if ($data['file_type'] === 'assets') {
                $this->generateBackup('siteAssets', ROOTPATH . 'public/assets/site/');
                $destPath = ROOTPATH . 'public/assets/site/';
            } else {
                $this->generateBackup('siteView', APPPATH . 'Views/site/');
                $destPath = APPPATH . 'Views/site/';
            }
        } elseif ($data['theme_type'] === 'user') {
            if ($data['file_type'] === 'assets') {
                $this->generateBackup('userAssets', ROOTPATH . 'public/assets/user/');
                $destPath = ROOTPATH . 'public/assets/user/';
            } else {
                $this->generateBackup('userView', APPPATH . 'Views/user/');
                $destPath = APPPATH . 'Views/user/';
            }
        } elseif ($data['theme_type'] === 'email') {
            $this->generateBackup('emailView', APPPATH . 'Views/emails/');
            $destPath = APPPATH . 'Views/emails/';
        } else {
            return redirect()->back()->with('error', 'Invalid theme type');
        }
        $tempPath = WRITEPATH . 'uploads/' . $file->getRandomName();
        if (!mkdir($tempPath, 0777, true)) {
            return redirect()->back()->with('error', 'Failed to create temporary directory');
        }
        if (!$file->move($tempPath)) {
            return redirect()->back()->with('error', 'Failed to upload file');
        }
        $zip = new \ZipArchive();
        $zipFile = $tempPath . '/' . $file->getName();
        if ($zip->open($zipFile) === TRUE) {
            $zip->extractTo($tempPath);
            $zip->close();
            $extractedFiles = scandir($tempPath);
            $sourceDir = $tempPath;
            $dirs = array_filter($extractedFiles, function($item) use ($tempPath) {
                return $item !== '.' && $item !== '..' && is_dir($tempPath . '/' . $item);
            });
            if (count($dirs) === 1) {
                $sourceDir = $tempPath . '/' . reset($dirs);
            }
            $this->recursiveCopy($sourceDir, $destPath);
            $this->deleteDirectory($tempPath);
            return redirect()->back()->with('success', 'Theme updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to open ZIP file');
        }
    }

    // @ioncube.dk dynamicHash("74RPL7cLO4I8Mwm8", "yc0pYCso1fNovP8r") -> "301345a4b342a954a3ff42ccabce520b5dee9ff93ce10d4f5017f499ab7e3008"
    private function recursiveCopy($src, $dst)
    {
        $dir = opendir($src);
        if (!file_exists($dst)) {
            mkdir($dst, 0777, true);
        }
        while (($file = readdir($dir))) {
            if ($file != '.' && $file != '..') {
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;
                if (is_file($srcPath) && pathinfo($srcPath, PATHINFO_EXTENSION) === 'zip') {
                    continue;
                }

                if (is_dir($srcPath)) {
                    $this->recursiveCopy($srcPath, $dstPath);
                } else {
                    copy($srcPath, $dstPath);
                }
            }
        }
        closedir($dir);
    }

    // @ioncube.dk dynamicHash("OQnbm2tJMF9hEOds", "bydY2Cv0nzSmPbP3") -> "009377110e3c51b07d0d40d885b91fefe3d007dace83886d564203602727829b"
    private function deleteDirectory($dir) 
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    // @ioncube.dk dynamicHash("iiT7nA05hf1RQg96", "0JNVBtdw5mMyAbt8") -> "724379097995e49229f6b45133fc79bec0b6c18d40241a752129f59a18c7ec4b"
    public function policies()
    {
        $filePath = WRITEPATH . 'static/policies.json';
        if ($this->request->getMethod() === 'GET') {
            $existingData = json_decode(@file_get_contents($filePath), true);
            if ($existingData === null) {
                $existingData = ['policies' => []];
            }
            $data = [
                'title' => 'Policies',
                'superAdminData' => $this->superAdminData,
                'policies' => $existingData['policies'] ?? []
            ];
            return view('superAdmin/policies', $data);
        }

        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            if (isset($data['csrf_token'])) {
                unset($data['csrf_token']);
            }
            if (!isset($data['policy'])) {
                return redirect()->to(env('app.superAdminURL') . '/policies')->with('error', 'Policy not found');
            }
            $policy = $data['policy'];
            unset($data['policy']);
            $existingData = json_decode(@file_get_contents($filePath), true);
            if ($existingData === null) {
                $existingData = ['policies' => []];
            }
            $policyFound = false;
            foreach ($existingData['policies'] as &$policyEntry) {
                if (isset($policyEntry['policy']) && $policyEntry['policy'] === $policy) {
                    $policyEntry['data'] = array_merge($policyEntry['data'], $data);
                    $policyFound = true;
                    break;
                }
            }
            if (!$policyFound) {
                $existingData['policies'][] = [
                    'policy' => $policy,
                    'data' => $data
                ];
            }
            if (file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT))) {
                return redirect()->to(env('app.superAdminURL') . '/policies')->with('success', 'Policy data updated');
            }
            return redirect()->to(env('app.superAdminURL') . '/policies')->with('error', 'Policy data not updated');
        }
    }

    // @ioncube.dk dynamicHash("NzGPmyd48wSHiXBH", "TDrbupr553IOZvTG") -> "63a4d1332d5dfa4f9848992a77233ace4a7441be1f9aeff4a666162da1f3af66"
    public function admins()
    {
        $admin = new \App\Models\Admins();
        $perPage = 10;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $admin;
        if (!empty($search)) {
            $query = $query->like('phone', $search)->orLike('email', $search);
        }
        $total = $query->countAllResults(false);
        $admins = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('superAdmin/admins', [
            'title' => 'Admins',
            'superAdminData' => $this->superAdminData,
            'data' => $admins ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("8f3ij8DPcnUrVjAX", "w4mWYhE4Y5rTEDzl") -> "788ea879d117abdf6999a58465fa39bb8bce93fd7c9f272ff66b2caae15bd131"
    public function addAdmin()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $rules = [
                'name' => 'required',
                'email' => 'required|valid_email',
                'phone' => 'required',
                'password' => 'required'
            ];
            if (!$this->validate($rules)) {
                return redirect()->back()->with('error', $this->validator->getErrors());
            }
            $admin = new \App\Models\Admins();
            $checkAdmin = $admin->where('email', $data['email'])->first();
            if ($checkAdmin) {
                return redirect()->back()->with('error', 'Email already exists');
            }
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            if ($admin->insert($data)) {
                return redirect()->to(env('app.superAdminURL') . '/admins')->with('success', 'Admin added successfully');
            }
            return redirect()->to(env('app.superAdminURL') . '/admins')->with('error', 'Admin not added');
        }
    }

    public function faq()
    {
        $faq = new \App\Models\Faqs();
        $perPage = 10;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $faq;
        if (!empty($search)) {
            $query = $query->like('question', $search);
        }
        $total = $query->countAllResults(false);
        $faqs = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('superAdmin/faq', [
            'title' => 'FAQ',
            'superAdminData' => $this->superAdminData,
            'data' => $faqs ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    public function addFaq()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $rules = [
                'question' => 'required',
                'answer' => 'required'
            ];
            if (!$this->validate($rules)) {
                return redirect()->back()->with('error', $this->validator->getErrors());
            }
            $faq = new \App\Models\Faqs();
            if ($faq->insert($data)) {
                return redirect()->to(env('app.superAdminURL') . '/faq')->with('success', 'FAQ added successfully');
            }
            return redirect()->to(env('app.superAdminURL') . '/faq')->with('error', 'FAQ not added');
        }
    }

    public function faqDelete()
    {
        $id = request()->getGet('id');
        $faq = new \App\Models\Faqs();
        if ($faq->delete($id)) {
            return redirect()->to(env('app.superAdminURL') . '/faq')->with('success', 'FAQ deleted successfully');
        }
        return redirect()->to(env('app.superAdminURL') . '/faq')->with('error', 'FAQ not deleted');
    }
}

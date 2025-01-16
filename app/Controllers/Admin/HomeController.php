<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';

class HomeController extends BaseController {
    public function __construct() {
        $this->pager = \Config\Services::pager();
        $this->encryption = \Config\Services::encrypter();
        $this->user = new \App\Models\Users();
        $this->package = new \App\Models\Packages();
        $this->upgradePackage = new \App\Models\UpgradePackages();
        $this->order = new \App\Models\Orders();
        $this->coreHome = new \App\Controllers\Core\HomeController();
        $this->app = new \App\Controllers\AppController();
        $this->referral = new \App\Models\Commission();
        $this->payout = new \App\Models\Payouts();
        $this->walletLog = new \App\Models\WalletLog();
        $this->kyc = new \App\Models\Kyc();
        $this->email = \Config\Services::email();
        $this->course = new \App\Models\Courses();
        $this->courseLink = new \App\Models\CourseLinks();
        $this->contactForm = new \App\Models\ContactForm();
        $this->testimonial = new \App\Models\Testimonials();
        $this->instructor = new \App\Models\Instructors();
        $this->training = new \App\Models\Trainings();
        $this->webinar = new \App\Models\Webinars();
        $this->offer = new \App\Models\LiveOffers();
        $this->banner = new \App\Models\Banners();
        $this->legalCertificate = new \App\Models\LegalCertificates();
        $this->communityLink = new \App\Models\CommunityLinks();
        $this->autoUpgrade = new \App\Models\AutoUpgrade();
        $this->vipMembers = new \App\Models\VipMembers();
    }

    private function countOrders()
    {
        return $this->order->countAllResults() ?? 0;
    }

    private function countUsers()
    {
        return $this->user->countAllResults() ?? 0;
    }

    private function countPendingPayout()
    {
        return $this->payout->where('status', 'pending')->countAllResults() ?? 0;
    }

    private function sumPaidPayout()
    {
        $result = $this->payout->where('status', 'paid')->selectSum('amount')->first();
        return $result['amount'] ?? 0;
    }

    private function sumPendingPayout()
    {
        $result = $this->payout->where('status', 'pending')->selectSum('amount')->first();
        return $result['amount'] ?? 0;
    }

    private function commissionsPaid()
    {
        $result = (new \App\Models\Commission())->where('status', 'paid')->selectSum('amount')->first();
        return $result['amount'] ?? 0;
    }

    private function totalRevenue()
    {
        $result = $this->order->where('status', 'paid')->selectSum('amount')->first();
        return $result['amount'] ?? 0;
    }

    private function unpaidBalance()
    {
        $result = $this->user->selectSum('wallet')->first();
        return $result['wallet'] ?? 0;
    }

    // @ioncube.dk dynamicHash("085zar34RtSCZmpy", "3iJQNQkaZYpruan2") -> "7d3e5f9849f2f89ec822c9840bec81a2dd88c9170d159e55f33a82de8efdf919"
    public function dashboard() {
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'adminData' => $this->adminData,
            'isNewVersion' => $this->coreHome->checkVersion(),
            'countOrders' => $this->countOrders(),
            'countUsers' => $this->countUsers(),
            'countPendingPayout' => $this->countPendingPayout(),
            'sumPaidPayout' => $this->sumPaidPayout(),
            'sumPendingPayout' => $this->sumPendingPayout(),
            'commissionsPaid' => $this->commissionsPaid(),
            'totalRevenue' => $this->totalRevenue(),
            'unpaidBalance' => $this->unpaidBalance(),
            'agencyToken' => (new \App\Controllers\HomeController())->agencyToken(),
            'newVersion' => $this->coreHome->newVersionData()
        ]);
    }

    // @ioncube.dk dynamicHash("lDjtgxadys3xEMXU", "A6snkVgvqupp7Na2") -> "99668de99a7dd56425fbdf95ea2e763763faa7eefa0d584d1a977fad6baf02a1"
    public function addPackage() {
        $data = $this->request->getPost();
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/packages', $newName);
            $data['image'] = $newName;
        }
        if ($this->package->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/packages')->with('success', 'Package added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/packages')->with('error', 'Failed to add Package');
    }

    // @ioncube.dk dynamicHash("OentFAtBp8QwTpjP", "bVA4lk12zGY4yTqn") -> "5b6dcab168cf0ff1dd6c5832f931ff62adc92144f640bdfac6680be7630111cc"
    public function getPackages()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->package->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('name', $search);
        }
        $total = $query->countAllResults(false);
        $packages = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/packages', [
            'title' => 'Packages',
            'adminData' => $this->adminData,
            'data' => $packages ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("5FrGqIjh6dWrPRxs", "LwsNWTjZ02nCA013") -> "910b94617d6ccc1c5c16d9ace85909f20eab8106544a63d069c6ffa8a883e376"
    public function getPackage($id = null) {
        if ($this->request->getMethod() == 'POST') {
            return $this->updatePackage($id);
        }
        return view('admin/package', [
            'title' => 'Package',
            'adminData' => $this->adminData,
            'package' => $this->package->find($id),
        ]);
    }

    // @ioncube.dk dynamicHash("TD61WSR54Gdh6tFn", "OHyjKzm9q2oGwFgX") -> "2ffce9a548526f836f4cb13957bc521670ababc13436915246ae1e317e201e7e"
    public function updatePackage($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . 'packages')->with('error', 'Package not found');
        }
        $data = request()->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'name' => 'required|string',
            'price' => 'required|integer',
            'ref_discount' => 'required|integer',
            'direct_commission' => 'required|integer',
            'mlm_commission' => 'required|integer',
            'status' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            log_message('error', json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('error', 'Please fill all the required fields');
        }
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $existingImage = $this->package->find($id)['image'];
            if ($existingImage) {
                if (file_exists(ROOTPATH . 'public/uploads/packages/' . $existingImage)) {
                    unlink(ROOTPATH . 'public/uploads/packages/' . $existingImage);
                }
            }
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/packages', $newName);
            $data['image'] = $newName;
        }
        $this->package->update($id, $data);
        return redirect()->to(env('app.adminURL') . '/packages')->with('success', 'Package updated successfully');
    }

    // @ioncube.dk dynamicHash("u1GjcBz9z1EFveoQ", "TJpfMN1tqFGPxuEY") -> "44dd7126c9ae826ea3c0beb7aac664105701b48fc9378059be457e2afee7e7a8"
    public function addUpgradePackage() {
        $data = $this->request->getPost();
        $rules = [
            'upgrade_from' => 'required|string',
            'upgrade_to' => 'required|integer',
            'price' => 'required|integer',
            'direct_commission' => 'required|integer',
            'mlm_commission' => 'required|integer',
            'status' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        if ($this->upgradePackage->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/upgrade-packages')->with('success', 'Upgrade Package added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/upgrade-packages')->with('error', 'Failed to add Upgrade Package');
    }

    // @ioncube.dk dynamicHash("nGJ2YYxVOEx3CXK3", "oDSU1GKuaFuSdV2d") -> "3328ada7b79b763add32197054b07c05b7beaf5c1b40e6d82393bf3c463dd397"
    public function getUpgradePackages()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->upgradePackage->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('upgrade_from', $search)->orLike('upgrade_to', $search);
        }
        $total = $query->countAllResults(false);
        $upgradepackages = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $packageData = [];
        foreach ($upgradepackages as $upgradepackage) {
            $packageData[$upgradepackage['upgrade_from']] = $this->package->find($upgradepackage['upgrade_from']) ?? [];
            $packageData[$upgradepackage['upgrade_to']] = $this->package->find($upgradepackage['upgrade_to']) ?? [];
        }
        $packages = $this->package->findAll();
        return view('admin/upgradePackages', [
            'title' => 'Upgrade Packages',
            'adminData' => $this->adminData,
            'data' => $upgradepackages ?? [],
            'packageData' => $packageData ?? [],
            'packages' => $packages ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }


    // @ioncube.dk dynamicHash("HShbXdoI5iV1RUFn", "XHFSc6ApvgpXXoOx") -> "df310be3dd21d8ef0a3518af407ac56f5494a45285de49e4cad230c4686da1f7"
    public function getUpgradePackage($id = null) {
        if ($this->request->getMethod() == 'POST') {
            return $this->updateUpgradePackage($id);
        }
        return view('admin/upgradePackage', [
            'title' => 'Upgrade Package',
            'adminData' => $this->adminData,
            'upgradePackage' => $this->upgradePackage->find($id),
            'packages' => $this->package->findAll(),
        ]);
    }

    // @ioncube.dk dynamicHash("RvAqdt89n1U3TfwW", "BEclgrwOimHUXppX") -> "01b20739a0d14d13fb2c73fd69230da592bf8159d87c97ead8273af7f645ea46"
    public function updateUpgradePackage($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . 'upgrade-packages')->with('error', 'Upgrade Package not found');
        }
        $data = request()->getPost();
        $rules = [
            'upgrade_from' => 'required|string',
            'upgrade_to' => 'required|integer',
            'price' => 'required|integer',
            'direct_commission' => 'required|integer',
            'mlm_commission' => 'required|integer',
            'status' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $this->upgradePackage->update($id, $data);
        return redirect()->to(env('app.adminURL') . '/upgrade-packages')->with('success', 'Upgrade Package updated successfully');
    }

    // @ioncube.dk dynamicHash("17AWevUpLSNcz73P", "7mlSoqA2RWtHBufL") -> "f6578f85fdee7275d63ebf2c5ffa8ee6a8bac056b7ed406baf3e47b7fe691b08"
    public function getUsers()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->user->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->where('name', $search)->orWhere('phone', $search)->orWhere('email', $search)->orWhere('ref_code', $search);
        }
        $total = $query->countAllResults(false);
        $users = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/users', [
            'title' => 'Users',
            'adminData' => $this->adminData,
            'data' => $users ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("2s2NNKH65KsajPG2", "HI7yF0qVsbKDAQHs") -> "a8e220a7aa35f6e69b7845be054dc826d82eaf15bf86f5def2ea39ebdb714073"
    public function getUser($id) {
        if ($this->request->getMethod() == 'POST') {
            return $this->updateUser($id);
        }
        
        // Fetch user data
        $userData = $this->user->find($id);
        if (!$userData) {
            return redirect()->back()->with('error', 'User not found');
        }
    
        // Pagination settings
        $perPage = 10;
    
        // Using paginate() for built-in pagination support
        $purchaseHistory = $this->order
            ->where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'purchaseGroup'); // Group name is optional but useful for multiple paginations
    
        $commissionHistory = $this->referral
            ->where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'commissionGroup');
    
        $walletHistory = $this->walletLog
            ->where('uid', $id)
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'walletGroup');
    
        // Get pagers
        $purchasePager = $this->order->pager;
        $commissionPager = $this->referral->pager;
        $walletPager = $this->walletLog->pager;
    
        // Return view
        return view('admin/user', [
            'title' => 'User',
            'adminData' => $this->adminData,
            'user' => $userData,
            'sponsorData' => $this->user->where('ref_code', $userData['ref_by_code'])->first() ?? [
                'name' => '', 'ref_code' => ''
            ],
            'packages' => $this->package->findAll(),
            'kycData' => $this->kyc->where('user_id', $id)->first() ?? [
                'bank_name' => '', 'holder_name' => '', 'account_number' => '', 'ifsc_code' => '', 'upi_id' => '', 'status' => ''
            ],
            'purchaseHistory' => $purchaseHistory,
            'commissionHistory' => $commissionHistory,
            'walletHistory' => $walletHistory,
            'addonStatus' => $this->app->checkAddon([
                'lead_management',
                'landing_page'
            ]),
            'purchasePager' => $purchasePager,
            'commissionPager' => $commissionPager,
            'walletPager' => $walletPager
        ]);
    }
    

    // @ioncube.dk dynamicHash("LwW685GffuqktG9p", "hsHviHNhxysRO1AG") -> "915c9d2120a405116a0a409355f867d00aead82cdab31e98e9a18758c9a233b4"
    public function updateUser($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . 'users')->with('error', 'User not found');
        }
        $data = request()->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|valid_email',
            'sponsor' => 'permit_empty|string',
            'plan_id' => 'required|integer',
            'plan_status' => 'required|string',
            'lb_status' => 'required|string',
            'dashboard' => 'required|string',
            'lead_access' => 'required|string',
            'landing_page' => 'required|string',
            'referral_access' => 'required|string',
            'mlm_access' => 'required|string',
            'withdraw_access' => 'required|string',
            'status' => 'required|string',
            'password' => 'permit_empty|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $existingImage = $this->user->find($id)['image'];
            if ($existingImage) {
                if (file_exists(ROOTPATH . 'public/uploads/profiles/' . $existingImage)) {
                    unlink(ROOTPATH . 'public/uploads/profiles/' . $existingImage);
                }
            }
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/profiles', $newName);
            $data['image'] = $newName;
        }
        if ($data['ref_by_code'] != $this->user->find($id)['ref_by_code']) {
            $data['parent_id'] = $this->user->where('ref_code', $data['ref_by_code'])->first()['id'];
        }
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (!$this->user->update($id, $data)) {
            return redirect()->to(env('app.adminURL') . '/user/' . $id)->with('error', 'An error occurred while updating the user.');
        }
        return redirect()->to(env('app.adminURL') . '/user/' . $id)->with('success', 'User updated successfully');
    }

    // @ioncube.dk dynamicHash("w9PX7xXFQQGqZVvC", "iyc0qRBX7zUKdkBN") -> "8f74287cd274e374169c37a73ca0fbbb7d6a994c41e225aaae08bceef69d8241"
    public function updateUserWallet($uid = null)
    {
        $data = request()->getPost();
        $rules = [
            'amount' => 'required|integer',
            'type' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $existingWallet = $this->user->find($uid)['wallet'];
    
        if ($data['type'] == 'credit') {
            if ($this->user->update($uid, [
                'wallet' => $data['amount'] + $existingWallet,
            ])) {
                $this->logWalletTransaction($uid, 'credit', $existingWallet, $data['amount'], $data['amount'] + $existingWallet, 'Wallet credit by admin');
                return redirect()->to(env('app.adminURL') . '/user/' . $uid)->with('success', 'Wallet updated successfully');
            }
        }
    
        if ($data['type'] == 'debit') {
            if ($existingWallet < $data['amount']) {
                return redirect()->back()->withInput()->with('error', 'Insufficient wallet balance for debit operation.');
            }
            if ($this->user->update($uid, [
                'wallet' => $existingWallet - $data['amount'],
            ])) {
                $this->logWalletTransaction($uid, 'debit', $existingWallet, $data['amount'], $existingWallet - $data['amount'], 'Wallet debit by admin');
                return redirect()->to(env('app.adminURL') . '/user/' . $uid)->with('success', 'Wallet updated successfully');
            }
        }
        return redirect()->to(env('app.adminURL') . '/users')->with('error', 'An error occurred while updating the wallet.');
    }
    
    // @ioncube.dk dynamicHash("x1FmuOfYGTMHEbQX", "Xuh6Ft8mfU097gtt") -> "f3eef0653165d2667a05c99f08ecd4fd023a84d3415bcc0334c70502fbf58a51"
    private function logWalletTransaction($uid, $type, $amount, $updated_amount, $balance, $description)
    {
        return $this->walletLog->insert([
            'uid' => $uid,
            'type' => $type,
            'amount' => $amount,
            'updated_amount' => $updated_amount,
            'balance' => $balance,
            'description' => $description,
        ]);
    }

    // @ioncube.dk dynamicHash("YpWuE9ne5gtTfeZV", "lLMmOKMZZdYxFbSH") -> "9f9dbe072b2c3c874a11275f859c3e1d4067e72eca387833b4dc9e5c6dc30b8b"
    public function updateUserKyc($uid = null)
    {
        $data = request()->getPost();
        $rules = [
            'bank_name' => 'required|string',
            'holder_name' => 'required|string',
            'account_number' => 'required|string',
            'ifsc_code' => 'required|string',
            'status' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        if ($this->kyc->where('user_id', $uid)->first()) {
            if ($this->kyc->where('user_id', $uid)->set($data)->update()) {
                return redirect()->to(env('app.adminURL') . '/user/' . $uid)->with('success', 'KYC updated successfully');
            }  
        } else {
            $data['user_id'] = $uid;
            if ($this->kyc->insert($data)) {
                return redirect()->to(env('app.adminURL') . '/user/' . $uid)->with('success', 'KYC updated successfully');
            }
        }
        return redirect()->to(env('app.adminURL') . '/users')->with('error', 'An error occurred while updating KYC.');
    }

    // @ioncube.dk dynamicHash("WPCB76c9E9Atovon", "vUCGWzihnFAQSc8f") -> "394c15a669384e8c97e96a4644b1ac59d3689e5cce8b0568f60f98f7c889b693"
    public function updateUserEarning()
    {
        $data = request()->getPost();
        $logMsg = 'SG Amount Add';
        $uid = $this->user->where('ref_code', $data['ref_code'])->first()['id'];
        $referralInsert = $this->referral->insert([
            'user_id' => $uid,
            'from_uid' => $data['user_id'],
            'amount' => $data['amount'],
            'type' => $data['active_passive'],
            'status' => 'verified'
        ]);
        if (!$referralInsert) {
            return redirect()->to(env('app.adminURL') . '/user/' . $data['user_id'])->with('error', 'An error occurred while updating Earning.');
        }
        $existingWallet = $this->user->find($uid)['wallet'];
        if ($data['type'] == 'credit') {
            if ($data['method'] == 'unpaid') {
                $updateUserWallet = $this->user->update($uid, ['wallet' => $existingWallet + $data['amount']]);
                $logMsg = 'SG Amount Add';
                if (!$updateUserWallet) {
                    return redirect()->to(env('app.adminURL') . '/user/' . $data['user_id'])->with('error', 'An error occurred while updating Earning.');
                }
            }
        }
        if ($data['type'] == 'debit') {
            if ($data['method'] == 'unpaid') {
                $updateUserWallet = $this->user->update($uid, ['wallet' => $existingWallet - $data['amount']]);
                $logMsg = 'SG Amount Debit';
                if (!$updateUserWallet) {
                    return redirect()->to(env('app.adminURL') . '/user/' . $data['user_id'])->with('error', 'An error occurred while updating Earning.');
                }
            }
        }
        $walletLogInsert = $this->walletLog->insert([
            'uid' => $uid,
            'type' => $data['type'],
            'amount' => $existingWallet,
            'updated_amount' => $data['amount'],
            'balance' => $this->user->find($uid)['wallet'],
            'description' => $logMsg,
        ]);
        if (!$walletLogInsert) {
            return redirect()->to(env('app.adminURL') . '/users')->with('error', 'An error occurred while updating Earning.');
        }
        return redirect()->to(env('app.adminURL') . '/users')->with('success', 'Earning updated successfully');
    }

    // @ioncube.dk dynamicHash("sykvD6jbS8UMvt6O", "uxBUOhhDVxu435px") -> "5e8b9222db0d7dca9e11aa6954247812c40a8f8146c45983c59fa50ecdb77c2d"
    public function orders()
    {
        $status = request()->getGet('status') ?? 'paid';
        $perPage = 15;
        $page = (int)(request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->order->where('status', $status)->orderBy('created_at', 'DESC');
    
        if (!empty($search)) {
            if ($status === 'pending') {
                $allOrders = $query->findAll();
                $filteredOrderIds = [];
    
                foreach ($allOrders as $order) {
                    if (!empty($order['temp_token'])) {
                        $base64 = base64_decode($order['temp_token']);
                        $decrypted = $this->encryption->decrypt($base64);
                        $decodedToken = json_decode($decrypted, true);
                        if (isset($decodedToken['email']) && stripos($decodedToken['email'], $search) !== false) {
                            $filteredOrderIds[] = $order['id'];
                        }
                    }
                }
                
                if (!empty($filteredOrderIds)) {
                    $query->whereIn('id', $filteredOrderIds);
                } else {
                    $query->where('id', 0);
                }
            } else {
                $query->groupStart()
                    ->like('txn_id', $search)
                    ->orLike('gateway', $search)
                    ->orLike('payment_ref', $search)
                    ->groupEnd();
            }
        }
    
        $total = $query->countAllResults(false);
        $orders = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        
        if ($status === 'pending') {
            foreach ($orders as &$order) {
                if (!empty($order['temp_token'])) {
                    $base64 = base64_decode($order['temp_token']);
                    $decrypted = $this->encryption->decrypt($base64);
                    $order['decoded_token'] = json_decode($decrypted, true);
                    unset($order['temp_token']);
                } else {
                    $order['decoded_token'] = [
                        'name' => '',
                        'email' => '',
                        'phone' => '',
                        'ref_by_code' => '',
                        'password' => '',
                        'txn_id' => ''
                    ];
                }
            }
            unset($order);
        }
    
        $data['orders'] = $orders;
    
        return view('admin/orders', [
            'title' => 'Orders',
            'data' => $data,
            'adminData' => $this->adminData,
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total,
            'status' => $status
        ]);
    }

    
    // @ioncube.dk dynamicHash("dUk3cWkRHlZIpiyL", "IlFg3YvfTqKQrlrK") -> "53b3579e7960d90049ba5813641cc77b94bfa9205fcb3d31ee8393ffb3094957"
    public function updateOrder($txn_id = null) {
        if ($txn_id == null) {
            return redirect()->to(env('app.adminURL') . 'orders?status=pending')->with('error', 'Order not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'approved') {
            $orderController = new \App\Controllers\OrderController();
            $orderResult = $orderController->verifyOrder($txn_id);
            if ($orderResult['status'] == 'success') {
                return redirect()->to(env('app.adminURL') . '/orders?status=pending')->with('success', 'Order updated successfully');
            } else {
                return redirect()->to(env('app.adminURL') . '/orders?status=pending')->with('error', $orderResult['message']);
            }
        }
        return redirect()->to(env('app.adminURL') . '/orders?status=pending')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("r0lLXuwGoP4cNYeS", "HgLeOLaT4573Rkgy") -> "b6d21135878cd147c0ff1d9295aafebdc34dace8038be8aa8ab342c65efb22be"
    public function kycRequest()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->kyc->where('status', 'pending')->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('account_number', $search)->orLike('holder_name', $search);
        }
        $total = $query->countAllResults(false);
        $kycs = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $users = [];
        foreach ($kycs as $kyc) {
            $users[$kyc['user_id']] = $this->user->find($kyc['user_id']) ?? [];
        }
        return view('admin/kycRequest', [
            'title' => 'KYC Requests',
            'adminData' => $this->adminData,
            'data' => $kycs ?? [],
            'users' => $users ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    public function kycUpdate()
    {
        $data = $this->request->getPost();
        if (isset($data['status'])) {
            $updateKyc = $this->kyc->update($data['id'], ['status' => $data['status']]);
            if ($updateKyc) {
                return redirect()->to(env('app.adminURL') . '/kyc-request')->with('success', 'KYC updated successfully');
            }  
        }
        return redirect()->to(env('app.adminURL') . '/kyc-request')->with('error', 'KYC not found');
    }

    public function payoutRequest()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->payout->where('status', 'pending')->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('user_id', $search)->orLike('amount', $search);
        }
        $total = $query->countAllResults(false);
        $payouts = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $users = [];
        $kycs = [];
        foreach ($payouts as $payout) {
            $users[$payout['user_id']] = $this->user->find($payout['user_id']) ?? [];
            $kycs[$payout['user_id']] = $this->kyc->where('user_id', $payout['user_id'])->first() ?? [];
        }
        return view('admin/payoutRequest', [
            'title' => 'Payouts',
            'adminData' => $this->adminData,
            'data' => $payouts ?? [],
            'users' => $users ?? [],
            'kycs' => $kycs ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    public function payouts()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->payout->where('status', 'paid')->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('user_id', $search)->orLike('amount', $search);
        }
        $total = $query->countAllResults(false);
        $payouts = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $users = [];
        $kycs = [];
        foreach ($payouts as $payout) {
            $users[$payout['user_id']] = $this->user->find($payout['user_id']) ?? [];
            $kycs[$payout['user_id']] = $this->kyc->find($payout['user_id']) ?? [];
        }
        return view('admin/payouts', [
            'title' => 'Payouts',
            'adminData' => $this->adminData,
            'data' => $payouts ?? [],
            'users' => $users ?? [],
            'kycs' => $kycs ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("mwDHzUGhlNuPiib9", "tilzRRpFRrac7yYz") -> "a0843c4ac888b9a47f08f45e24f08b2f856bf1722a322949302c5652e46be7ef"
    public function updatePayout($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . 'payout-request')->with('error', 'Payout not found');
        }
        $data = $this->request->getPost();
        
        if (isset($data['status']) && $data['status'] == 'approved') {
            $payoutData = $this->payout->find($id);
            if ($this->payout->update($id, ['status' => 'paid'])) {
                if ($this->user->update($payoutData['user_id'], ['paid' => $this->user->find($payoutData['user_id'])['paid'] + $payoutData['amount']])) {
                    $payoutEmailData = [
                        'userData' => $this->user->find($payoutData['user_id']),
                        'amount' => $payoutData['amount']
                    ];
                    $subject = 'Payout Processed | ' . env('app.name');
                    $template = 'emails/payout';
                    $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
                    $this->email->setTo($this->user->find($payoutData['user_id'])['email']);
                    $this->email->setSubject($subject);
                    $this->email->setMessage(view($template, $payoutEmailData));
                    $this->email->send();
                    return redirect()->to(env('app.adminURL') . '/payout-request')->with('success', 'Payout approved successfully');
                }
            }
        }
        if (isset($data['status']) && $data['status'] == 'rejected') {
            $payoutData = $this->payout->find($id);
            $userData = $this->user->find($payoutData['user_id']);
            if ($this->user->update($payoutData['user_id'], ['wallet' => $userData['wallet'] + $payoutData['amount']])) {
                if ($this->walletLog->insert([
                    'uid' => $payoutData['user_id'],
                    'type' => 'credit',
                    'amount' => $userData['wallet'],
                    'updated_amount' => $payoutData['amount'],
                    'balance' => $userData['wallet'] + $payoutData['amount'],
                    'description' => 'Payout Rejected'
                ])) {
                    if ($this->payout->delete($id)) {
                        $payoutEmailData = [
                            'username' => $this->user->find($payoutData['user_id'])['name'],
                            'amount' => $payoutData['amount'],
                            'rejectionReason' => 'Reason Not Provided! Please contact support.'
                        ];
                        $subject = 'Payout Rejected | ' . env('app.name');
                        $template = 'emails/payoutReject';
                        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
                        $this->email->setTo($this->user->find($payoutData['user_id'])['email']);
                        $this->email->setSubject($subject);
                        $this->email->setMessage(view($template, $payoutEmailData));
                        $this->email->send();
                        return redirect()->to(env('app.adminURL') . '/payout-request')->with('success', 'Payout rejected successfully');
                    }
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/payout-request')->with('error', 'Payout not found');
    }

    // @ioncube.dk dynamicHash("kIXPBZBk3xmvJNAZ", "mxZiili5mJviATEJ") -> "c062fbf1d53f4dd7469399be6cd349754780202667cc5bffe6fd7a9b62c7ccc3"
    public function referrals()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->referral->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->where('linked_order', $search);
        }
        $total = $query->countAllResults(false);
        $referrals = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $users = [];
        foreach ($referrals as $referral) {
            $users[$referral['user_id']] = $this->user->find($referral['user_id']) ?? [];
            $users[$referral['from_uid']] = $this->user->find($referral['from_uid']) ?? ['name' => 'N/A', 'ref_code' => 'N/A'];
        }
        return view('admin/referrals', [
            'title' => 'Referrals',
            'adminData' => $this->adminData,
            'data' => $referrals ?? [],
            'users' => $users ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("wGrBgHek0ZwLiBel", "1sTiVw1mte2l8ook") -> "2d11aaa1897c263acb806bab3ca11463e993a18a17d35015fdb6ca61f8e9e146"
    public function walletLog()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->walletLog->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->where('uid', $search);
        }
        $total = $query->countAllResults(false);
        $walletLogs = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $users = [];
        foreach ($walletLogs as $walletLog) {
            $users[$walletLog['uid']] = $this->user->find($walletLog['uid']) ?? [];
        }
        return view('admin/walletLog', [
            'title' => 'Wallet Log',
            'adminData' => $this->adminData,
            'data' => $walletLogs ?? [],
            'users' => $users ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("0PJuRprz2slP9Avn", "53xGi9BuaRK1KhBH") -> "ecd4cdfd8363bcf3dccd010d26b02db4606066bb631897972301b7cd6468b41a"
    public function getCourses()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->course->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('name', $search);
        }
        $total = $query->countAllResults(false);
        $courses = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $packageData = [];
        foreach ($courses as $course) {
            $packageData[$course['package_id']] = $this->package->find($course['package_id']) ?? [];
        }
        $packages = $this->package->findAll();
        return view('admin/courses', [
            'title' => 'Courses',
            'adminData' => $this->adminData,
            'data' => $courses ?? [],
            'packageData' => $packageData ?? [],
            'packages' => $packages ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("5lXYMrQj4bJiEeTS", "4MQaPhayf5NkMJIQ") -> "6c619719bca155ccc6401d352d6b36c66693eb339f6db14c6c2b2c5f0faa62dd"
    public function addCourse() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'name' => 'required|string',
            'package_id' => 'required|integer',
            'featured' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/courses', $newName);
            $data['image'] = $newName;
        }
        if ($this->course->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/courses')->with('success', 'Course added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/courses')->with('error', 'Failed to add course');
    }

    // @ioncube.dk dynamicHash("9EpTXvMVYg1tSlb1", "IDRIzeVk617zSW34") -> "c82a7856481e7a5b0e39cc9e62a97b79e25b2d0615ab6377b54af8972ad484fd"
    public function updateCourse($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/courses')->with('error', 'Course not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $courseData = $this->course->find($id);
            if ($courseData) {
                if (file_exists(ROOTPATH . 'public/uploads/courses/' . $courseData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/courses/' . $courseData['image']);
                }
                if ($this->course->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/courses')->with('success', 'Course deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/courses')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("mzmNXHuEL1p6GbYS", "mmnhOjadT32joX5W") -> "953d35a2f03e6ef0c075a2bf545b56d6305f7a95df36d52cdd956680dc3fd1ee"
    public function getCoursesLinks()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->courseLink->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('name', $search);
        }
        $total = $query->countAllResults(false);
        $coursesLinks = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $courseData = [];
        foreach ($coursesLinks as $courseLink) {
            $courseData[$courseLink['course_id']] = $this->course->find($courseLink['course_id']) ?? [];
        }
        $courses = $this->course->findAll();
        return view('admin/courseLinks', [
            'title' => 'Course Links',
            'adminData' => $this->adminData,
            'data' => $coursesLinks ?? [],
            'courseData' => $courseData ?? [],
            'courses' => $courses ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("B41lME6kt4Lhs2x5", "wn04psevWLmf2GAv") -> "2442559f70d0a22cd6cdb3328348dd1dff76dabb15206fddbdff243270d95561"
    public function addCourseLink() {
        $data = $this->request->getPost();
        if ($this->courseLink->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/course-links')->with('success', 'Course link added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/course-links')->with('error', 'Failed to add course link');
    }

    // @ioncube.dk dynamicHash("3eXZ3CPy8htc4NwM", "NAhlRtOOyuyXjjrT") -> "f03543a5df9e8bd58b91b2b888d0a34a32d174cd057d5e97420c254fbee51793"
    public function updateCourseLink($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/course-links')->with('error', 'Course link not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $courseLinkData = $this->courseLink->find($id);
            if ($courseLinkData) {
                if ($this->courseLink->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/course-links')->with('success', 'Course link deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/course-links')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("Tx9qVQ57uz0yCHdN", "guD0SAsAGXwNk270") -> "779d6607ef4caac82c3fffbd97d7c7f44d35af8a3abfdde17e50fb00258e298e"
    public function getContactForm()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->contactForm->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('name', $search);
        }
        $total = $query->countAllResults(false);
        $contactForms = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/contactForm', [
            'title' => 'Contact Form',
            'adminData' => $this->adminData,
            'data' => $contactForms ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("ttbHlBRU10jl47p4", "bT5twiw6VjY7HWRC") -> "6f51dd43c814a2b3057ad7e3333d39043b0acbdb01dcbe1c6f49e41ade3e3b82"
    public function updateContactForm($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/contact-form')->with('error', 'Contact form not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $contactFormData = $this->contactForm->find($id);
            if ($contactFormData) {
                if ($this->contactForm->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/contact-form')->with('success', 'Contact form deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/contact-form')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("rmtBtJnucL0MWPAw", "SKYxdVYBLgjvZa6s") -> "8c029e88d3a5d848dcd4b7bbf34c0ee7196f38ea4112027182c29db1a9e29368"
    public function getTestimonials()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $search = request()->getGet('search');
        $query = $this->testimonial->orderBy('id', 'DESC');
        if (!empty($search)) {
            $query = $query->like('name', $search);
        }
        $total = $query->countAllResults(false);
        $testimonials = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/testimonials', [
            'title' => 'Testimonials',
            'adminData' => $this->adminData,
            'data' => $testimonials ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("asMiHJAh2uVsn3zT", "Z3wXv4vB1MFamp04") -> "1da2aefa4da51fbba95fb5e79c09c026610278f24e9cca704b5f964f5b2a82ff"
    public function addTestimonial() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'name' => 'required|string',
            'content' => 'required|string',
            'tag' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->testimonial->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/testimonials')->with('success', 'Testimonial added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/testimonials')->with('error', 'Failed to add testimonial');
    }

    // @ioncube.dk dynamicHash("AahupwBSsKGQ81dX", "DUuHM8nFYYPdCjCQ") -> "19bfba3f37bc60fb34b96f7d30740bda314be6829c90176357c8330a4935ec1f"
    public function updateTestimonial($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/testimonials')->with('error', 'Testimonial not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $testimonialData = $this->testimonial->find($id);
            if ($testimonialData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $testimonialData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $testimonialData['image']);
                }
                if ($this->testimonial->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/testimonials')->with('success', 'Testimonial deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/testimonials')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("A9oq43r35xHlCpAd", "RkzrlHbAvklHRWB3") -> "bad670d13c8f04472144cd3d16ba1cb0a3b424aaf9c0451646a9b42acf16861f"
    public function getBanners()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->banner->orderBy('id', 'DESC');
        $total = $query->countAllResults(false);
        $banners = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/banners', [
            'title' => 'Banners',
            'adminData' => $this->adminData,
            'data' => $banners ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("L5jbKOafCOMwWBMq", "3wpZzJZXXFjv4msp") -> "29598c8c6c259fad17daa74d9af9b7c0bbdac46b7b2954afbfdc942b5161d602"
    public function addBanner() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->banner->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/banners')->with('success', 'Banner added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/banners')->with('error', 'Failed to add banner');
    }

    // @ioncube.dk dynamicHash("OC3YRpKxr0PKmFVJ", "f8FGiMf5CP1OgJFi") -> "6768ef4d842f9d02e58a9718b59e9dafab6f3b48a6228003b5fab2c240c75383"
    public function updateBanner($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/banners')->with('error', 'Banner not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $bannerData = $this->banner->find($id);
            if ($bannerData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $bannerData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $bannerData['image']);
                }
                if ($this->banner->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/banners')->with('success', 'Banner deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/banners')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("FiXgEkEblUf4BrnH", "4ZMYoMNJclIn8cyP") -> "09f43a46e52193e602051135dc0f95e7d090c3300a39bcff6f8fc8360a65786c"
    public function getWebinars()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->webinar;
        $total = $query->countAllResults(false);
        $webinars = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/webinars', [
            'title' => 'Webinars',
            'adminData' => $this->adminData,
            'data' => $webinars ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("IbiTRQOSbS8eOl0s", "gkaKVrWTVSGcGhy0") -> "4ee6671b200111fadacb0e255055479b68a162f090ab7c4b5560a37731c20fdd"
    public function addWebinar() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'title' => 'required|string',
            'description' => 'required|string',
            'link' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->webinar->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/webinars')->with('success', 'Webinar added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/webinars')->with('error', 'Failed to add webinar');
    }

    // @ioncube.dk dynamicHash("cpHGH9Dd2RexVJ3E", "bFtYzZ7xnRAy0V1n") -> "a76bdd30d8de0f601c97640abf0c364b2f5de32fdebca163a528ff962b0749f8"
    public function updateWebinar($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/webinars')->with('error', 'Webinar not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $webinarData = $this->webinar->find($id);
            if ($webinarData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $webinarData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $webinarData['image']);
                }
                if ($this->webinar->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/webinars')->with('success', 'Webinar deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/webinars')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("xR9pNCljPIM2XLcA", "jl7cL0lIQB9OOjMQ") -> "cc69f759fb8d2cea8a00fb6548428b99e0ae7624633455ec83aa2694b62cc4ba"
    public function getOffers()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->offer;
        $total = $query->countAllResults(false);
        $offers = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/liveOffers', [
            'title' => 'Offers',
            'adminData' => $this->adminData,
            'data' => $offers ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("zWIcb6sLKT1V2f6J", "ObpuoB0h5uBVaopv") -> "56677656e5b87964a9b6d7d3b42111e3c15e97d63b4bcbfa97e0feaa47e2bac1"
    public function addOffer() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'title' => 'required|string',
            'description' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->offer->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/offers')->with('success', 'Offer added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/offers')->with('error', 'Failed to add offer');
    }

    // @ioncube.dk dynamicHash("L9mnV8JfWk43rAWi", "AGF5U2aQMjjtWBYu") -> "fc4edb9cb14d02adc206ea132410abdca0d9fbe10c60d7372225c2e7ad37a396"
    public function updateOffer($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/offers')->with('error', 'Offer not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $offerData = $this->offer->find($id);
            if ($offerData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $offerData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $offerData['image']);
                }
                if ($this->offer->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/offers')->with('success', 'Offer deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/offers')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("kdFCwG7OJfrJdtwm", "1ZvJBldOGWHUy5tT") -> "c391f9766a24065c3d1b5028941be59e6ffcdd420e086ac09fdcc2dbc6808953"
    public function getTrainings()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->training;
        $total = $query->countAllResults(false);
        $trainings = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/trainings', [
            'title' => 'Trainings',
            'adminData' => $this->adminData,
            'data' => $trainings ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("EguKhX6urxTotns7", "s23HSR6Xi8PIDrTJ") -> "ad0bcefad252987de7e35c310c9a2f3a29f719e8f80201a23df9a3c4b53e64e8"
    public function addTraining() {
        $data = $this->request->getPost();
        $rules = [
            'title' => 'required|string',
            'video_url' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        if ($this->training->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/trainings')->with('success', 'Training added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/trainings')->with('error', 'Failed to add training');
    }

    // @ioncube.dk dynamicHash("EbMyAnGbIgwiPthx", "i1G5MuG9fquhbmEq") -> "8a7caa1f4bb2003e762052fc3b3f4d698038433e6fb68dd11aec65deb96df519"
    public function updateTraining($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/trainings')->with('error', 'Training not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $trainingData = $this->training->find($id);
            if ($trainingData) {
                if ($this->training->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/trainings')->with('success', 'Training deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/trainings')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("JYnd8PZJMYYSg9qE", "zSBYuA5xk19MkP78") -> "de5975be8596abfd0fa59194da3e8a34ea84b12d6afdf79ed801a057ae5ae5d8"
    public function getLegalCertificates()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->legalCertificate;
        $total = $query->countAllResults(false);
        $legalCertificates = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/legalCertificates', [
            'title' => 'Legal Certificates',
            'adminData' => $this->adminData,
            'data' => $legalCertificates ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("Sxc2JxSQrT9ygznU", "rliuymoC5HSbVrNE") -> "8f3a4bfc29621d2a95b353cf31ff45f68a65bff854829f70a2f51e096842b606"
    public function addLegalCertificate() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'max_size[image,5120]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image/webp,image]'
                ],
            ],
            'file' => [
                'label' => 'File',
                'rules' => [
                    'uploaded[file]',
                    'max_size[file,15360]',
                    'mime_in[file,application/pdf]'
                ],
            ],
            'title' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $file = $this->request->getFile('file');
        $image = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['file'] = $newName;
        }
        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->legalCertificate->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/legal-certificates')->with('success', 'Legal certificate added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/legal-certificates')->with('error', 'Failed to add legal certificate');
    }

    // @ioncube.dk dynamicHash("bOGbAxC93C1xBYVp", "h34ZVrAbcnn9w0g5") -> "1ca3bba38759cd297a74dc3667464f77b66a0c479a1fc4be4f9dc815f9cd6690"
    public function updateLegalCertificate($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/legal-certificates')->with('error', 'Legal certificate not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $legalCertificateData = $this->legalCertificate->find($id);
            if ($legalCertificateData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $legalCertificateData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $legalCertificateData['image']);
                }
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $legalCertificateData['file'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $legalCertificateData['file']);
                }
                if ($this->legalCertificate->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/legal-certificates')->with('success', 'Legal certificate deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/legal-certificates')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("zLMc7pLYvo7xquoi", "p7RAQLyyDw8VZPmf") -> "4cb3aecdd169b63d4556b57c61b9fb3e72da74d237e67c017a31ce4a7cc8ea89"
    public function getInstructors()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->instructor;
        $total = $query->countAllResults(false);
        $instructors = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/instructors', [
            'title' => 'Instructors',
            'adminData' => $this->adminData,
            'data' => $instructors ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("kLADhQMzKCQptInE", "NfwnHfeue9RKq7HU") -> "e47eb643858b5460def2c155d132e4f27789db6b31a82a134a284ac72ca49774"
    public function addInstructor() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'permit_empty',
                    'uploaded[image]',
                    'max_size[image,5120]',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'name' => 'required|string',
            'role' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->instructor->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/instructors')->with('success', 'Instructor added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/instructors')->with('error', 'Failed to add instructor');
    }

    // @ioncube.dk dynamicHash("zAkWOemKcyE59WtD", "wJTfuMS9OQ53zg1Y") -> "2f363277dc6cf0f70771bce2463225c1c50c9b3af33e183924648dd6eeaf96d2"
    public function updateInstructor($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/instructors')->with('error', 'Instructor not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $instructorData = $this->instructor->find($id);
            if ($instructorData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $instructorData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $instructorData['image']);
                }
                if ($this->instructor->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/instructors')->with('success', 'Instructor deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/instructors')->with('error', 'Something went wrong');
    }

    public function getVipMembers()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->vipMembers;
        $total = $query->countAllResults(false);
        $vipMembers = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/vipMembers', [
            'title' => 'VIP Members',
            'adminData' => $this->adminData,
            'data' => $vipMembers ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    public function addVipMember() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'permit_empty',
                    'uploaded[image]',
                    'max_size[image,5120]',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'name' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->vipMembers->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/vip-members')->with('success', 'VIP Member added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/vip-members')->with('error', 'Failed to add VIP Member');
    }

    public function updateVipMember($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/vip-members')->with('error', 'VIP Member not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $vipMemberData = $this->vipMembers->find($id);
            if ($vipMemberData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $vipMemberData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $vipMemberData['image']);
                }
                if ($this->vipMembers->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/vip-members')->with('success', 'VIP Member deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/vip-members')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("8fs6YycPDifBGEge", "GB5SCj9rHoHVcVjU") -> "240ca607eb58beadc31724d97b7ad5b663bf34a36c5a7bb269ae69fc7ef153fa"
    public function getCommunityLinks()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->communityLink;
        $total = $query->countAllResults(false);
        $communityLinks = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        return view('admin/communityLinks', [
            'title' => 'Community Links',
            'adminData' => $this->adminData,
            'data' => $communityLinks ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total
        ]);
    }

    // @ioncube.dk dynamicHash("gfHHwDL3kWD2aNQx", "iRBlNEyRmOfUmhse") -> "254aac5d3db8e1aee0967974901f945a560c67c350f9e5fe6cb49324d953776a"
    public function addCommunityLink() {
        $data = $this->request->getPost();
        $rules = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'permit_empty',
                    'uploaded[image]',
                    'max_size[image,5120]',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png,image/heic,image]'
                ],
            ],
            'title' => 'required|string',
            'link' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['image'] = $newName;
        }
        if ($this->communityLink->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/community-links')->with('success', 'Community link added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/community-links')->with('error', 'Failed to add community link');
    }

    // @ioncube.dk dynamicHash("9YQk2P3ouoP4fZK6", "1iMipPhA7LNKSOqM") -> "b141846008d55e5aab2804837a6487d42b0b889c8ad44a4268b043f5884eff18"
    public function updateCommunityLink($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/community-links')->with('error', 'Community link not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            $communityLinkData = $this->communityLink->find($id);
            if ($communityLinkData) {
                if (file_exists(ROOTPATH . 'public/uploads/others/' . $communityLinkData['image'])) {
                    unlink(ROOTPATH . 'public/uploads/others/' . $communityLinkData['image']);
                }
                if ($this->communityLink->delete($id)) {
                    return redirect()->to(env('app.adminURL') . '/community-links')->with('success', 'Community link deleted successfully');
                }
            }
        }
        return redirect()->to(env('app.adminURL') . '/community-links')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("Wqdu3dirjYxe4xwc", "p80TYnH37NfXSg7Z") -> "636cb84ae596951b700c96f08255dde535244b2d6bde53e9de646a935147ad1d"
    public function getAutoUpgrade()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = $this->autoUpgrade;
        $total = $query->countAllResults(false);
        $autoUpgrades = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $packageData = [];
        foreach ($autoUpgrades as $key => $autoUpgrade) {
            $packageData[$autoUpgrade['package_id']] = $this->package->find($autoUpgrade['package_id']) ?? [];
            $packageData[$autoUpgrade['upgrade_to']] = $this->package->find($autoUpgrade['upgrade_to']) ?? [];
        }
        $packages = $this->package->findAll();
        return view('admin/autoUpgrade', [
            'title' => 'Auto Upgrade',
            'adminData' => $this->adminData,
            'data' => $autoUpgrades ?? [],
            'packages' => $packages ?? [],
            'packageData' => $packageData ?? [],
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total,
            'addonStatus' => $this->app->checkAddon([
                'auto_upgrade'
            ])
        ]);
    }

    // @ioncube.dk dynamicHash("gYSkNRYwZY5b9Lhe", "4yWJfetxvMMvnNPD") -> "0aa4424a832d075c442610250168129b0dde7f6973eca86a5af9fd96a1f8e153"
    public function addAutoUpgrade() {
        $data = $this->request->getPost();
        $rules = [
            'package_id' => 'required|integer',
            'upgrade_to' => 'required|integer',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        if ($this->autoUpgrade->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/auto-upgrade')->with('success', 'Auto upgrade package added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/auto-upgrade')->with('error', 'Failed to add auto upgrade package');
    }

    // @ioncube.dk dynamicHash("CNo3LXp2wPaxbF8W", "9E5fBtLxav5GJCqP") -> "e7c00f642661471ab4ccff527250c5b6a116185bfa30da670d6fcad49f129b6f"
    public function updateAutoUpgrade($id = null) {
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/auto-upgrade')->with('error', 'Auto upgrade package not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            if ($this->autoUpgrade->delete($id)) {
                return redirect()->to(env('app.adminURL') . '/auto-upgrade')->with('success', 'Auto upgrade package deleted successfully');
            }
        }
        return redirect()->to(env('app.adminURL') . '/auto-upgrade')->with('error', 'Something went wrong');
    }

    public function getCosmoLink()
    {
        $perPage = 20;
        $page = (int) (request()->getGet('page') ?? 1);
        $query = new \App\Models\CosmoLinkPay();
        $total = $query->countAllResults(false);
        $cosmoLinks = $query->limit($perPage, ($page - 1) * $perPage)->findAll();
        $packageData = [];
        foreach ($cosmoLinks as $key => $cosmoLink) {
            $packageData[$cosmoLink['package_id']] = $this->package->find($cosmoLink['package_id']) ?? [];
        }
        return view('admin/cosmoLinks', [
            'title' => 'Cosmo Links',
            'adminData' => $this->adminData,
            'data' => $cosmoLinks ?? [],
            'packageData' => $packageData ?? [],
            'packages' => $this->package->findAll(),
            'pager' => $this->pager->makeLinks($page, $perPage, $total, 'default_full'),
            'total' => $total,
            'addonStatus' => $this->app->checkAddon([
                'cosmofeed_gateway'
            ])
        ]);
    }

    public function cosmoLinkAdd()
    {
        $cosmoLink = new \App\Models\CosmoLinkPay();
        $data = $this->request->getPost();
        $rules = [
            'package_id' => 'required|integer',
            'link' => 'required|string',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        if ($cosmoLink->insert($data)) {
            return redirect()->to(env('app.adminURL') . '/cosmo-link')->with('success', 'Cosmo link added successfully');
        }
        return redirect()->to(env('app.adminURL') . '/cosmo-link')->with('error', 'Failed to add cosmo link');
    }

    public function cosmoLinkUpdate($id = null)
    {
        $cosmoLink = new \App\Models\CosmoLinkPay();
        if ($id == null) {
            return redirect()->to(env('app.adminURL') . '/cosmo-link')->with('error', 'Cosmo link not found');
        }
        $data = $this->request->getPost();
        if (isset($data['status']) && $data['status'] == 'delete') {
            if ($cosmoLink->delete($id)) {
                return redirect()->to(env('app.adminURL') . '/cosmo-link')->with('success', 'Cosmo link deleted successfully');
            }
        }
        return redirect()->to(env('app.adminURL') . '/cosmo-link')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("McbpJPCsDD68dQ35", "uzFcdwF4Ub6hwxEF") -> "007b6d227e227908fc187146a1170de38f21e4e10fd8a573e48e0c0127adba8d"
    public function setting() {
        $filePath = WRITEPATH . 'static/admin.json';
        if (file_exists($filePath)) {
            $settingData = json_decode(file_get_contents($filePath), true);
            if (!is_array($settingData)) {
                $settingData = [];
            }
        } else {
            $settingData = [];
        }
        $settingData = array_merge([
            'maintenance_mode' => 'inactive',
            'maintenance_message' => '',
            'payout_status' => 'inactive',
            'payout_status_message' => '',
            'phonepe' => 'inactive',
            'razorpay' => 'inactive',
            'cosmofeed' => 'inactive',
            'wallet' => 'inactive',
            'upi_qr' => 'inactive',
            'upi_id' => '',
            'today_lb' => 'inactive',
            'seven_days_lb' => 'inactive',
            'thirty_days_lb' => 'inactive',
            'all_time_lb' => 'inactive',
            'auto_upgrade' => 'inactive',
            'direct_kyc' => 'inactive',
            'referal_code_compulsory' => 'inactive',
            'payout_mail_on_wallet' => 'inactive',
            'home_banner' => 'inactive',
            'referral_offer' => 'inactive',
            'sales_offer' => 'inactive',
            'facebook' => '',
            'instagram' => '',
            'youtube' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
            'dashboard_guide' => '',
            'min_payout' => 0,
        ], $settingData);
        return view('admin/setting', [
            'title' => 'Setting',
            'adminData' => $this->adminData,
            'settingData' => $settingData,
            'addonStatus' => $this->app->checkAddon([
                'wallet_gateway',
                'cosmofeed_gateway',
                'sales_offer',
                'referral_offer',
                'auto_upgrade'
            ])
        ]);
    }

    // @ioncube.dk dynamicHash("iwIgHYWecLvSZLBx", "ORsVlkPYvbQxDbii") -> "be13ebb3706973c7b5c610a90bb6e21dd3a0d9c3c2c47091c27913dee3bff533"
    public function updateSetting() {
        $data = $this->request->getPost();
        $rules = [
            'maintenance_mode' => 'required',
            'payout_status' => 'required',
            'phonepe' => 'required',
            'razorpay' => 'required',
            'cosmofeed' => 'required',
            'wallet' => 'required',
            'upi_qr' => 'required',
            'today_lb' => 'required',
            'seven_days_lb' => 'required',
            'thirty_days_lb' => 'required',
            'all_time_lb' => 'required',
            'min_payout' => 'required',
            'referral_offer' => 'required',
            'sales_offer' => 'required',
            'auto_upgrade' => 'required',
            'direct_kyc' => 'required',
            'referal_code_compulsory' => 'required',
            'payout_mail_on_wallet' => 'required',
            'home_banner' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        if (isset($data['csrf_token'])) {
            unset($data['csrf_token']);
        }
        $filePath = WRITEPATH . 'static/admin.json';
        if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
            return redirect()->to(env('app.adminURL') . '/setting')->with('success', 'Setting updated successfully');
        }
        return redirect()->to(env('app.adminURL') . '/setting')->with('error', 'Failed to update setting');
    }
}

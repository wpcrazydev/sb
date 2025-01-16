<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
include_once APPPATH. 'Controllers/CommonController.php';
class OrderController extends BaseController
{
    public function __construct()
    {
        $this->encryption = \Config\Services::encrypter();
        $this->email = \Config\Services::email();
        $this->package = new \App\Models\Packages();
        $this->upgradePackage = new \App\Models\UpgradePackages();
        $this->user = new \App\Models\Users();
        $this->order = new \App\Models\Orders();
        $this->commission = new \App\Models\Commission();
        $this->walletLog = new \App\Models\WalletLog();
        $this->app = new \App\Controllers\AppController();
        $this->db = \Config\Database::connect();
        $this->home = new \App\Controllers\HomeController();
        helper('text');
    }

    // @ioncube.dk dynamicHash("SCao1nOpCqZ0QoDU", "UMKzGLGG8ak5bWxH") -> "aad906820c9f58b212fdc6d088e75cf2f2c2f0a014f9c7f6b207878295ef8403"
    public function checkout()
    {
        $this->app->checkLicense();
        if ($this->request->getMethod() == 'GET') {
            $data['siteAdminToken'] = $this->home->siteAdminToken();
            $data['watermark'] = $this->home->watermark();
            return view('site/checkout', [
                'title' => 'Checkout',
                'pkgParam' => $pkg_id = $this->request->getGet('pkg'),
                'refByParam' => $ref_by = $this->request->getGet('ref'),
                'packages' => $this->package->findAll(),
                'siteAdminToken' => $data['siteAdminToken'],
                'watermark' => $data['watermark']
            ]);
        }

        $data = $this->request->getPost();
        $rules = [
            'package_id' => 'required',
            'name' => 'required|string',
            'phone' => 'required|min_length[10]|max_length[10]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'gateway' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $checkUser = $this->user->where('email', $data['email'])->orWhere('phone', $data['phone'])->first();
        if ($checkUser) {
            return redirect()->back()->withInput()->with('errors', ['email' => 'Email or Phone already exists']);
        }
        if (!empty($data['ref_by'])) {
            $sponsor = $this->user->where('ref_code', $data['ref_by'])->first();
        }
        if (!$sponsor) {
            return redirect()->back()->withInput()->with('errors', ['ref_by' => 'Invalid Referral Code']);
        }
        $txn_id = 'TXN-' . time() . random_string('alnum', 6);
        $packageDetails = $this->package->find($data['package_id']);
        $orderData = [
            'txn_id' => $txn_id,
            'package_id' => $data['package_id'],
            'amount' => $packageDetails['price'],
            'gateway' => $data['gateway'],
            'status' => 'pending',
        ];
        $insertOrder = $this->order->insert($orderData);
        $lastOrderId = $this->order->getInsertID();
        if (!$insertOrder) {
            return redirect()->back()->withInput()->with('errors', ['order' => 'Failed to place order']);
        }
        $refByCode = $data['ref_by'] ? $data['ref_by'] : null;
        $orderData['name'] = $data['name'];
        $orderData['phone'] = $data['phone'];
        $orderData['email'] = $data['email'];
        $orderData['ref_by_code'] = $refByCode;
        $orderData['password'] = $data['password'];
        $registerEmailData = [
            'username' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ];
        $subject = 'Welcome to ' . env('app.name');
        $template = 'emails/register';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($data['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $registerEmailData));
        $this->email->send();
        $token = $this->encryption->encrypt(json_encode($orderData));
        $this->order->update($lastOrderId, ['temp_token' => base64_encode($token)]);
        return redirect()->to('/payment?token=' . base64_encode($token));
    }
    

    // @ioncube.dk dynamicHash("BAGSPfZwZDjGNLa2", "dsfMwjIXUyWvZTDn") -> "db016f7f62c00fba704e44939d70de1b9e8a406b8906680796e26a958da1b067"
    public function verifyOrder($txn_id)
    {
        $this->app->checkLicense();
        $orderData = $this->order->where('txn_id', $txn_id)->first();
        if (!$orderData || $orderData['temp_token'] == null) {
            return ['status' => 'failed', 'message' => 'Invalid order or token not found'];
        }
        $base64DecodedToken = base64_decode($orderData['temp_token']);
        $decodedData = json_decode($this->encryption->decrypt($base64DecodedToken), true);
        $purchaseType = 'normal';
        if (isset($decodedData['purchase_type']) && $decodedData['purchase_type'] == 'upgrade') {
            return $this->verifyUpgradeOrder($txn_id, $decodedData, $orderData);
        }
        $sponsorData = '';
        if ($decodedData['ref_by_code'] != null) {
            $sponsorData = $this->user->where('ref_code', $decodedData['ref_by_code'])->first();
        }
        $subSponsorData = '';
        if ($sponsorData['ref_by_code'] != null) {
            $subSponsorData = $this->user->where('ref_code', $sponsorData['ref_by_code'])->first();
        }
        $planIdForUser = $orderData['package_id'];
        $addonStatus = $this->app->checkAddon(['auto_upgrade']);
        if ($addonStatus['auto_upgrade'] == 'Active') {
            if ($this->home->siteAdminToken()['auto_upgrade'] == 'active') {
                $planIdForUser = (new \App\Models\AutoUpgrade())->where('package_id', $planIdForUser)->first()['upgrade_to'];
            }
        }
        if (is_array($sponsorData)) {
            $parent_id = $sponsorData['id'];
        } else {
            $parent_id = 0;
        }
        if (is_array($subSponsorData)) {
            $subparent_id = $subSponsorData['id'];
        } else {
            $subparent_id = 0;
        }
        //
        $this->user->insert([
            'name' => $decodedData['name'],
            'phone' => $decodedData['phone'],
            'email' => $decodedData['email'],
            'ref_by_code' => $decodedData['ref_by_code'],
            'parent_id' => $parent_id,
            'plan_id' => $planIdForUser,
            'plan_status' => 'active',
            'password' => password_hash($decodedData['password'], PASSWORD_DEFAULT),
        ]);
        $lastUserId = $this->user->getInsertID();
        $refCode = env('REFCODE_PREFIX') . $lastUserId;
        $updateUser = $this->user->where('id', $lastUserId)->set(['ref_code' => $refCode])->update();
        if (!$updateUser) {
            return ['status' => 'failed', 'message' => 'Failed to create user'];
        }
        if ($parent_id > 0) {
            if ($sponsorData['referral_access'] === 'active') {
                $directCommission = $this->insertDirectCommission($sponsorData, $orderData, $lastUserId, $parent_id, $txn_id, $decodedData);
                if (!$directCommission) {
                    return ['status' => 'failed', 'message' => 'Failed to insert active commission'];
                }
                if ($subparent_id > 0 && $subSponsorData['mlm_access'] === 'active') {
                    $mlmCommission = $this->insertMlmCommission($subSponsorData, $orderData, $parent_id, $txn_id, $decodedData);
                    if (!$mlmCommission) {
                        return ['status' => 'failed', 'message' => 'Failed to insert passive commission'];
                    }
                }
            }
        }
        $updateOrder = $this->order->where('txn_id', $txn_id)->set([
            'user_id' => $lastUserId,
            'parent_id' => $parent_id,
            'status' => 'paid',
            'temp_token' => null
        ])->update();
        if (!$updateOrder) {
            return ['status' => 'failed', 'message' => 'Failed to update order'];
        }
        $purchaseEmailData = [
            'productName' => get_dynamic_data('packages', 'name', ['id' => $orderData['package_id']]),
            'paymentMethod' => $orderData['gateway'],
            'price' => $orderData['amount']
        ];
        $subject = 'Purchase Confirmation | ' . env('app.name');
        $template = 'emails/purchase';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($decodedData['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $purchaseEmailData));
        $this->email->send();
        return ['status' => 'success', 'message' => 'Order updated successfully'];
    }

    private function insertDirectCommission($sponsorData, $orderData, $lastUserId, $parent_id, $txn_id, $decodedData)
    {
        $packageDetails = $this->package->findAll();
        $packageDetails = array_column($packageDetails, null, 'id');
        $sponsorData['pkg_price'] = $packageDetails[$sponsorData['plan_id']]['price'];
        if ($sponsorData['pkg_price'] >= $orderData['amount']) {
            $packageID = $orderData['package_id'];
        } else {
            $packageID = $sponsorData['plan_id'];
        }
        $directCommissionAmount = $packageDetails[$packageID]['direct_commission'];
        $directCommission = $this->commission->insert([
            'user_id' => $parent_id,
            'from_uid' => $lastUserId,
            'amount' => $directCommissionAmount,
            'type' => 'direct',
            'linked_order' => $txn_id,
            'status' => 'verified',
        ]);
        $amountToUpdate = $sponsorData['wallet'] + $directCommissionAmount;
        $this->user->where('id', $parent_id)->set('wallet', $amountToUpdate)->update();
        $this->walletLog->insert([
            'uid' => $parent_id,
            'type' => 'credit',
            'amount' => $sponsorData['wallet'],
            'updated_amount' => $directCommissionAmount,
            'balance' => $amountToUpdate,
            'description' => 'Active Commission Add - ' . $txn_id,
        ]);
        $activeEmailData = [
            'username' => $sponsorData['name'],
            'referralName' => $decodedData['name'],
            'amount' => $directCommissionAmount
        ];
        $subject = 'Active Referral | ' . env('app.name');
        $template = 'emails/referral';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($sponsorData['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $activeEmailData));
        $this->email->send();
        return true;
    }

    private function insertMlmCommission($subSponsorData, $orderData, $parent_id, $txn_id, $decodedData)
    {
        $packageDetails = $this->package->findAll();
        $packageDetails = array_column($packageDetails, null, 'id');
        $subSponsorData['pkg_price'] = $packageDetails[$subSponsorData['plan_id']]['price'];
        if ($subSponsorData['pkg_price'] >= $orderData['amount']) {
            $packageID = $orderData['package_id'];
        } else {
            $packageID = $subSponsorData['plan_id'];
        }
        $mlmCommissionAmount = $packageDetails[$packageID]['mlm_commission'];
        $mlmCommission = $this->commission->insert([
            'user_id' => $subSponsorData['id'],
            'from_uid' => $parent_id,
            'amount' => $mlmCommissionAmount,
            'type' => 'mlm',
            'linked_order' => $txn_id,
            'status' => 'verified',
        ]);
        $amountToUpdate = $subSponsorData['wallet'] + $mlmCommissionAmount;
        $this->user->where('id', $subSponsorData['id'])->set('wallet', $amountToUpdate)->update();
        $this->walletLog->insert([
            'uid' => $subSponsorData['id'],
            'type' => 'credit',
            'amount' => $subSponsorData['wallet'],
            'updated_amount' => $mlmCommissionAmount,
            'balance' => $amountToUpdate,
            'description' => 'Passive Commission Add - ' . $txn_id,
        ]);
        $passiveEmailData = [
            'username' => $subSponsorData['name'],
            'referralName' => $decodedData['name'],
            'amount' => $mlmCommissionAmount
        ];
        $subject = 'Passive Referral | ' . env('app.name');
        $template = 'emails/referral';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($subSponsorData['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $passiveEmailData));
        $this->email->send();
        return true;
    }

    public function upgrade()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $txn_id = 'TXN-' . time() . random_string('alnum', 4);
        $packageDetails = $this->upgradePackage->find($data['package_id']);
        $insertOrder = $this->order->insert([
            'txn_id' => $txn_id,
            'user_id' => session()->get('uid'),
            'parent_id' => $this->userData['parent_id'],
            'package_id' => $packageDetails['upgrade_to'],
            'amount' => $packageDetails['price'],
            'gateway' => $data['gateway'],
            'status' => 'pending',
        ]);
        if (!$insertOrder) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later.',
            ]);
        }
        $tokenData = [
            'txn_id' => $txn_id,
            'name' => $this->userData['name'],
            'email' => $this->userData['email'],
            'phone' => $this->userData['phone'],
            'ref_by_code' => $this->userData['ref_by_code'],
            'purchase_type' => 'upgrade',
            'upgrade_from' => $this->userData['plan_id'],
            'upgrade_to' => $packageDetails['upgrade_to'],
        ];
        $token = $this->encryption->encrypt(json_encode($tokenData));
        $this->order->where('txn_id', $txn_id)->set('temp_token', base64_encode($token))->update();
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)->setJSON([
            'status' => 'success',
            'url' => base_url('/payment?token=' . base64_encode($token)),
        ]);
    }


    private function verifyUpgradeOrder($txn_id, $decodedData, $orderData) 
    {
        $sponsorData = '';
        if ($decodedData['ref_by_code'] != null) {
            $sponsorData = $this->user->where('ref_code', $decodedData['ref_by_code'])->first();
        }
        $subSponsorData = '';
        if ($sponsorData['ref_by_code'] != null) {
            $subSponsorData = $this->user->where('ref_code', $sponsorData['ref_by_code'])->first();
        }
        $planIdForUser = $orderData['package_id'];
        $addonStatus = $this->app->checkAddon(['auto_upgrade']);
        if ($addonStatus['auto_upgrade'] == 'Active') {
            if ($this->home->siteAdminToken()['auto_upgrade'] == 'active') {
                $planIdForUser = (new \App\Models\AutoUpgrade())->where('package_id', $planIdForUser)->first()['upgrade_to'];
            }
        }
        if (is_array($sponsorData)) {
            $parent_id = $sponsorData['id'];
        } else {
            $parent_id = 0;
        }
        if (is_array($subSponsorData)) {
            $subparent_id = $subSponsorData['id'];
        } else {
            $subparent_id = 0;
        }
        $upgradeUser = $this->user->where('id', $orderData['user_id'])->set(['plan_id' => $planIdForUser])->update();
        if (!$upgradeUser) {
            return ['status' => 'failed', 'message' => 'Failed to upgrade user'];
        }
        if ($parent_id > 0) {
            if ($sponsorData['referral_access'] === 'active') {
                $directCommission = $this->insertUpgradeDirectCommission($sponsorData, $orderData, $orderData['user_id'], $parent_id, $txn_id, $decodedData);
                if (!$directCommission) {
                    return ['status' => 'failed', 'message' => 'Failed to insert active commission'];
                }
                if ($subparent_id > 0 && $subSponsorData['mlm_access'] === 'active') {
                    $mlmCommission = $this->insertUpgradeMlmCommission($subSponsorData, $orderData, $parent_id, $txn_id, $decodedData);
                    if (!$mlmCommission) {
                        return ['status' => 'failed', 'message' => 'Failed to insert passive commission'];
                    }
                }
            }
        }
        $updateOrder = $this->order->where('txn_id', $txn_id)->set([
            'status' => 'paid',
            'temp_token' => null
        ])->update();
        if (!$updateOrder) {
            return ['status' => 'failed', 'message' => 'Failed to update upgrade order'];
        }
        $purchaseEmailData = [
            'productName' => get_dynamic_data('packages', 'name', ['id' => $orderData['package_id']]),
            'paymentMethod' => $orderData['gateway'],
            'price' => $orderData['amount']
        ];
        $subject = 'Purchase Confirmation | ' . env('app.name');
        $template = 'emails/purchase';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($decodedData['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $purchaseEmailData));
        $this->email->send();
        return ['status' => 'success', 'message' => 'Order updated successfully'];
    }

    private function insertUpgradeDirectCommission($sponsorData, $orderData, $upgradeUserId, $parent_id, $txn_id, $decodedData)
    {
        $packageDetails = $this->package->findAll();
        $packageDetails = array_column($packageDetails, null, 'id');
        $sponsorData['pkg_price'] = $packageDetails[$sponsorData['plan_id']]['price'];
        if ($sponsorData['pkg_price'] >= $orderData['amount']) {
            $upgradeRelation = $this->upgradePackage->where('upgrade_from', $decodedData['upgrade_from'])->where('upgrade_to', $decodedData['upgrade_to'])->first();
            $directCommissionAmount = $upgradeRelation['direct_commission'];
        } else {
            $directCommissionAmount = $packageDetails[$sponsorData['plan_id']]['direct_commission'];
        }
        $directCommission = $this->commission->insert([
            'user_id' => $parent_id,
            'from_uid' => $upgradeUserId,
            'amount' => $directCommissionAmount,
            'type' => 'direct',
            'linked_order' => $txn_id,
            'status' => 'verified',
        ]);
        $amountToUpdate = $sponsorData['wallet'] + $directCommissionAmount;
        $this->user->where('id', $parent_id)->set('wallet', $amountToUpdate)->update();
        $this->walletLog->insert([
            'uid' => $parent_id,
            'type' => 'credit',
            'amount' => $sponsorData['wallet'],
            'updated_amount' => $directCommissionAmount,
            'balance' => $amountToUpdate,
            'description' => 'Active Commission Add - ' . $txn_id,
        ]);
        $activeEmailData = [
            'username' => $sponsorData['name'],
            'referralName' => $decodedData['name'],
            'amount' => $directCommissionAmount
        ];
        $subject = 'Active Referral | ' . env('app.name');
        $template = 'emails/referral';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($sponsorData['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $activeEmailData));
        $this->email->send();
        return true;
    }

    private function insertUpgradeMlmCommission($subSponsorData, $orderData, $parent_id, $txn_id, $decodedData)
    {
        $packageDetails = $this->package->findAll();
        $packageDetails = array_column($packageDetails, null, 'id');
        $subSponsorData['pkg_price'] = $packageDetails[$subSponsorData['plan_id']]['price'];
        if ($subSponsorData['pkg_price'] >= $orderData['amount']) {
            $upgradeRelation = $this->upgradePackage->where('upgrade_from', $decodedData['upgrade_from'])->where('upgrade_to', $decodedData['upgrade_to'])->first();
            $mlmCommissionAmount = $upgradeRelation['mlm_commission'];
        } else {
            $mlmCommissionAmount = $packageDetails[$subSponsorData['plan_id']]['mlm_commission'];
        }
        $mlmCommission = $this->commission->insert([
            'user_id' => $subSponsorData['id'],
            'from_uid' => $parent_id,
            'amount' => $mlmCommissionAmount,
            'type' => 'mlm',
            'linked_order' => $txn_id,
            'status' => 'verified',
        ]);
        $amountToUpdate = $subSponsorData['wallet'] + $mlmCommissionAmount;
        $this->user->where('id', $subSponsorData['id'])->set('wallet', $amountToUpdate)->update();
        $this->walletLog->insert([
            'uid' => $subSponsorData['id'],
            'type' => 'credit',
            'amount' => $subSponsorData['wallet'],
            'updated_amount' => $mlmCommissionAmount,
            'balance' => $amountToUpdate,
            'description' => 'Passive Commission Add - ' . $txn_id,
        ]);
        $passiveEmailData = [
            'username' => $subSponsorData['name'],
            'referralName' => $decodedData['name'],
            'amount' => $mlmCommissionAmount
        ];
        $subject = 'Passive Referral | ' . env('app.name');
        $template = 'emails/referral';
        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($subSponsorData['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $passiveEmailData));
        $this->email->send();
        return true;
    }

}

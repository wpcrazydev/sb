<?php

namespace App\Controllers\Admin;
include_once APPPATH. 'Controllers/CommonController.php';
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\Admins;

class AuthController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admins();
        $this->encryption = Services::encrypter();
        $this->email = Services::email();
        $this->app = new \App\Controllers\AppController();
    }

    // @ioncube.dk dynamicHash("3ea1Mo8rlcFWZ9t0", "iUpZDGCfZNVpqi5z") -> "44f5c2c009d174a517cbf63ec9d67b22a4b1602c986c2d81ae877d2915f9aacf"
    public function login()
    {
        $this->app->checkLicense();
        if ($this->request->getMethod(true) === 'GET') {
            return view('admin/loginPage', [
                'title' => 'Admin Login'
            ]);
        }
        $data = $this->request->getPost();
        $failedAttempts = session()->get('failed_attempts') ?? 0;
        $lockTime = session()->get('lock_time') ?? null;
        if ($failedAttempts >= 3 && time() < $lockTime) {
            return redirect()->to(env('app.adminURL') . '/login')->with('error', 'Account locked for 10 minutes');
        }
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        $admin = $this->adminModel->where('email', $data['email'])->first();
        if (!$admin) {
            session()->set([
                'failed_attempts' => $failedAttempts + 1,
                'lock_time' => $lockTime ?? time() + (10 * 60)
            ]);
            return redirect()->back()->with('error', 'Account not found');
        }
        if (!password_verify($data['password'], $admin['password'])) {
            session()->set([
                'failed_attempts' => $failedAttempts + 1,
                'lock_time' => $lockTime ?? time() + (10 * 60)
            ]);
            return redirect()->back()->with('error', 'Invalid password');
        }
        session()->set([
            'uid' => $admin['id'],
            'role' => 'admin',
            'isLoggedIn' => true,
            'failed_attempts' => 0,
            'lock_time' => null
        ]);
        return redirect()->to(env('app.adminURL') . '/dashboard')->with('success', 'Login successful');
    }

    // @ioncube.dk dynamicHash("h6WLhCdDLqvH5e8W", "5YoZS9JuhscV3v2w") -> "4fa046974beb414218f56dac263b96bbcc1f62892983a47bef26f467cf62d470"
    public function forgotPassword()
    {
        $this->app->checkLicense();
        if ($this->request->getMethod(true) === 'GET') {
            return view('admin/forgotPassword', [
                'title' => 'Admin Forgot Password'
            ]);
        }
        $data = $this->request->getPost();
        $rules = [
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return redirect()->to(env('app.adminURL') . '/forgot-password')->with('error', $this->validator->getErrors());
        }
        $admin = $this->adminModel->where('email', $data['email'])->first();
        if (!$admin) {
            return redirect()->to(env('app.adminURL') . '/forgot-password')->with('error', 'Account not found');
        }
        $tokenData = [
            'id' => $admin['id'],
            'expiry' => time() + (15 * 60)
        ];
        $token = $this->encryption->encrypt(json_encode($tokenData));
        $emailData = [
            'username' => $admin['name'],
            'token' => base64_encode($token),
            'path' => env('app.adminURL') . '/'
        ];
        $subject = 'Forgot Password | ' . env('app.name');
        $template = 'emails/forgotPassword';

        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($admin['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $emailData));
        if (!$this->email->send()) {
            return redirect()->to(env('app.adminURL') . '/forgot-password')->with('error', 'Failed to send email');
        }
        return redirect()->to(env('app.adminURL') . '/forgot-password')->with('success', 'Email sent');
    }

    // @ioncube.dk dynamicHash("Gh1aXTb65St1RSmV", "6WEtFL8qTi4RmySG") -> "73878ffc70214ce6b9b26e01455a5c7da32a65706de055c2b81a96fa88376c16"
    public function resetPassword($token = null)
    {
        if ($this->request->getMethod(true) === 'GET') {
            return view('admin/resetPassword', [
                'title' => 'Admin Reset Password',
                'token' => $token ?? $this->request->getVar('token')
            ]);
        }
        $data = $this->request->getPost();
        $rules = [
            'password' => 'required',
            'token' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        $tokenData = json_decode($this->encryption->decrypt(base64_decode($data['token'])), true);
        if (!$tokenData || time() > $tokenData['expiry']) {
            return redirect()->to(env('app.adminURL') . '/login')->with('error', 'Invalid token');
        }
        $admin = $this->adminModel->find($tokenData['id']);
        if (!$admin) {
            return redirect()->to(env('app.adminURL') . '/login')->with('error', 'Invalid token');
        }
        $this->adminModel->update($admin['id'], [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        return redirect()->to(env('app.adminURL') . '/login')->with('success', 'Password reset successful');
    }

    // @ioncube.dk dynamicHash("inAHYB7eYhutCAf1", "xTbnxLqSq1RlmGU0") -> "2182375ec455a6cd7ebb17661b2221f6dcdaaa82857a829114c7d3f344ef63ce"
    public function changePassword()
    {
        $data = $this->request->getPost();
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        $admin = $this->adminModel->find(session()->get('uid'));
        if ($admin['password'] !== password_hash($data['current_password'], PASSWORD_DEFAULT)) {
            return redirect()->back()->with('error', 'Invalid current password');
        }
        $this->adminModel->update(session()->get('uid'), [
            'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
        ]);
        return redirect()->to(env('app.adminURL') . '/profile')->with('success', 'Password changed successfully');
    }

    
    public function profile()
    {
        return view('admin/profile', [
            'title' => 'Admin Profile',
            'adminData' => $this->adminData
        ]);
    }

    // @ioncube.dk dynamicHash("tngfQ6mtXMYxgJiq", "Kz9BvSGO8pJhCCzU") -> "461cc49d810f5597dcc9fcaacdd3e690ba964206b2375fe79f5c3448bf7cd74c"
    public function updateProfile()
    {
        $data = $this->request->getPost();
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'phone' => 'required|numeric|min_length[10]|max_length[10]',
            'email' => 'required|valid_email',
            'password' => 'permit_empty|min_length[8]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if (isset($data['status'])) {
            unset($data['status']);
        }
        if ($this->adminModel->update(session()->get('uid'), $data)) {
            return redirect()->to(env('app.adminURL') . '/profile')->with('success', 'Profile updated successfully');
        }
        return redirect()->to(env('app.adminURL') . '/profile')->with('error', 'Failed to update profile');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(env('app.adminURL') . '/login');
    }

    // @ioncube.dk dynamicHash("11M4EPQLiNBGUwez", "KaQtPR1fcCubHoQC") -> "16a9f4bf8f8da6053b81675eeccc837fdfedc8f08da7d16bad8b1d48959e5d5a"
    public function loginAsSuperAdmin()
    {
        if (session()->has('superAdminSessionData') && session()->get('superAdminSessionData')['role'] === 'super_admin') {
            session()->remove(['uid', 'role']);
            session()->set([
                'uid' => session()->get('superAdminSessionData')['uid'],
                'role' => 'super_admin',
                'isLoggedIn' => true
            ]);
            $superAdminName = (new \App\Models\SuperAdmins())->find(session()->get('uid'))['name'];
            return redirect()->to(env('app.superAdminURL') . '/dashboard')->with('success', 'You are now logged in as super admin - ' . $superAdminName);
        }
        session()->destroy();
        return redirect()->to(base_url());
    }

    // @ioncube.dk dynamicHash("Z83L1j5OIsFLzyds", "g01nwUNWAPjjDZzK") -> "7f7dee2e8d1b4dfcc9d9cdcad74272b7136c27abff74e94594d43855ed26ffc5"
    public function loginAsUser()
    {
        $uid = $this->request->getGet('uid');
        if (!$uid) {
            return redirect()->to(env('app.adminURL') . '/users')->with('error', 'Invalid user ID');
        }
        $user = (new \App\Models\Users())->find($uid);
        if (!$user) {
            return redirect()->to(env('app.adminURL') . '/users')->with('error', 'User not found');
        }
        $adminSessionData = [
            'uid' => session()->get('uid'),
            'role' => session()->get('role'),
            'isLoggedIn' => session()->get('isLoggedIn')
        ];
        if ($adminSessionData['role'] === 'admin') {
            session()->set([
                'adminSessionData' => $adminSessionData,
                'uid' => $uid,
                'role' => 'user',
                'isLoggedIn' => true
            ]);
            return redirect()->to('user/dashboard')->with('success', 'You are now logged in as user - ' . $user['name']);
        }
        return redirect()->to(env('app.adminURL') . '/users')->with('error', 'You are not authorized to do this action');
    }
}
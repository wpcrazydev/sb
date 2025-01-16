<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SuperAdmins;
use Config\Services;
include_once APPPATH. 'Controllers/CommonController.php';
class AuthController extends BaseController
{
    protected $superAdminModel;

    public function __construct()
    {
        $this->superAdminModel = new SuperAdmins();
        $this->encryption = Services::encrypter();
        $this->email = Services::email();
        $this->app = new \App\Controllers\AppController();
    }

    // @ioncube.dk dynamicHash("AikYp1FwnbNFrrAv", "3gTUuTlckladWNet") -> "259e22bea98ae0533e7d4a5e83b05e94d77ff9f4e95907b24f52383c69d85282"
    public function login()
    {
        $this->app->checkLicense();
        if ($this->request->getMethod(true) === 'GET') {
            return view('superAdmin/login', [
                'title' => 'Super Admin Login'
            ]);
        }
        $data = $this->request->getPost();
        $failedAttempts = session()->get('failed_attempts') ?? 0;
        $lockTime = session()->get('lock_time') ?? null;
        if ($failedAttempts >= 3 && time() < $lockTime) {
            return redirect()->to(env('app.superAdminURL') . '/login')->with('error', 'Account locked for 10 minutes');
        }
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        $superAdmin = $this->superAdminModel->where('email', $data['email'])->first();
        if (!$superAdmin) {
            session()->set([
                'failed_attempts' => $failedAttempts + 1,
                'lock_time' => $lockTime ?? time() + (10 * 60)
            ]);
            return redirect()->back()->with('error', 'Account not found');
        }
        if (!password_verify($data['password'], $superAdmin['password'])) {
            session()->set([
                'failed_attempts' => $failedAttempts + 1,
                'lock_time' => $lockTime ?? time() + (10 * 60)
            ]);
            return redirect()->back()->with('error', 'Invalid password');
        }
        session()->set([
            'uid' => $superAdmin['id'],
            'role' => 'super_admin',
            'isLoggedIn' => true,
            'failed_attempts' => 0,
            'lock_time' => null
        ]);
        return redirect()->to(env('app.superAdminURL') . '/dashboard')->with('success', 'Login successful');
    }

    // @ioncube.dk dynamicHash("bQ6Dy5GQexZDRxaO", "hSkdgGl5o2XmNWOl") -> "79a1b886885a6d38ba1f267d8005812dcb0686f26b7a2631a48ad03f5fcaac14"
    public function forgotPassword()
    {
        $this->app->checkLicense();
        if ($this->request->getMethod(true) === 'GET') {
            return view('superAdmin/forgotPassword', [
                'title' => 'Super Admin Forgot Password'
            ]);
        }
        $data = $this->request->getPost();
        $rules = [
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return redirect()->to(env('app.superAdminURL') . '/forgot-password')->with('error', $this->validator->getErrors());
        }
        $superAdmin = $this->superAdminModel->where('email', $data['email'])->first();
        if (!$superAdmin) {
            return redirect()->to(env('app.superAdminURL') . '/forgot-password')->with('error', 'Account not found');
        }
        $tokenData = [
            'id' => $superAdmin['id'],
            'expiry' => time() + (15 * 60)
        ];
        $token = $this->encryption->encrypt(json_encode($tokenData));
        $emailData = [
            'username' => $superAdmin['name'],
            'token' => $token,
            'path' => env('app.superAdminURL') . '/'
        ];
        $subject = 'Forgot Password | ' . env('app.name');
        $template = 'emails/forgotPassword';

        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($superAdmin['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $emailData));
        if (!$this->email->send()) {
            return redirect()->to(env('app.superAdminURL') . '/forgot-password')->with('error', 'Failed to send email');
        }
        return redirect()->to(env('app.superAdminURL') . '/forgot-password')->with('success', 'Email sent');
    }

    // @ioncube.dk dynamicHash("H4DSJJfVoOiZdGHJ", "KeeDdprXXxC3jns6") -> "b82d7c7de26f8e381781a7834eb59072d30e63b81e8fe43324d3255c8c120f03"
    public function resetPassword($token = null)
    {
        if ($this->request->getMethod(true) === 'GET') {
            return view('superAdmin/resetPassword', [
                'title' => 'Super Admin Reset Password',
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
        $tokenData = json_decode($this->encryption->decrypt($data['token']), true);
        if (!$tokenData || time() > $tokenData['expiry']) {
            return redirect()->to(env('app.superAdminURL') . '/login')->with('error', 'Invalid token');
        }
        $superAdmin = $this->superAdminModel->find($tokenData['id']);
        if (!$superAdmin) {
            return redirect()->to(env('app.superAdminURL') . '/login')->with('error', 'Invalid token');
        }
        $this->superAdminModel->update($superAdmin['id'], [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        return redirect()->to(env('app.superAdminURL') . '/login')->with('success', 'Password reset successful');
    }

    // @ioncube.dk dynamicHash("zOEnDlp5xbcL5Egj", "JiP5iqjJXwp6ESyv") -> "4a3664b1d2cea8c6201beb39397999797ee474c9c8df22567eabd0455b9ea1f1"
    public function updateProfile()
    {
        $data = $this->request->getPost();
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required'
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
        $this->superAdminModel->update(session()->get('uid'), $data);
        return redirect()->to(env('app.superAdminURL') . '/profile')->with('success', 'Profile updated successfully');
    }

    // @ioncube.dk dynamicHash("fZVkri2EsoZRenDJ", "4gDpJv53ZXLeX2Ky") -> "967a1c4ce2a1a3b74dfc48dd5ff498054a217e8236f153d470ffa49d0521aa11"
    public function profile()
    {
        if ($this->request->getMethod() === 'GET') {
            return view('superAdmin/profile', [
                'title' => 'Profile',
                'superAdminData' => $this->superAdminData
            ]);
        }

        if ($this->request->getMethod() === 'POST') {
            return $this->updateProfile();
        }
    }

    // @ioncube.dk dynamicHash("4dNLsRqMtuGhYXPV", "7f6KuA8fYmFwoB7u") -> "e847711588de04cdb5d2f2c876d1a7b47e0e54bef7e0ab9bfe0ef901af7ace32"
    public function logout()
    {
        session()->destroy();
        return redirect()->to(env('app.superAdminURL') . '/login');
    }

    // @ioncube.dk dynamicHash("RkCrw3BqXvULSfe1", "vvhYFC9HHQ3QoxDi") -> "56e88ef6ed320718ce5ce59bc5d3f4a551f50825fb218c4d12bccd228f155f53"
    public function adminBan()
    {
        $uid = $this->request->getGet('uid');
        $admin = new \App\Models\Admins();
        $admin->update($uid, [
            'status' => 'inactive'
        ]);
        return redirect()->to(env('app.superAdminURL') . '/admins')->with('success', 'Admin banned successfully');
    }

    // @ioncube.dk dynamicHash("1IAek0Ncx4P8KX4E", "lmeR5agEAWnmXidW") -> "165ffe28461b780f6ebd99bb2a3622ae90f4fd532f0ef5c82085d7900da82771"
    public function adminUnban()
    {
        $uid = $this->request->getGet('uid');
        $admin = new \App\Models\Admins();
        $admin->update($uid, [
            'status' => 'active'
        ]);
        return redirect()->to(env('app.superAdminURL') . '/admins')->with('success', 'Admin unbanned successfully');
    }

    // @ioncube.dk dynamicHash("8R8XhMHG8uqtbA4s", "jeSGznXwlEQlnp9M") -> "eb8d8f967141d5304411ce55ff324dd0d6b2e4b3e84dc4c6a3ff60b2fb39512d"
    public function adminDelete()
    {
        $uid = $this->request->getGet('uid');
        $admin = new \App\Models\Admins();
        $admin->delete($uid);
        return redirect()->to(env('app.superAdminURL') . '/admins')->with('success', 'Admin deleted successfully');
    }

    // @ioncube.dk dynamicHash("FMpBfHoLCd3NPRUZ", "9mgIn9rBWhoXT55k") -> "ae567bb257c2093cf02f34610281fdd750ce3c421ab320357d9c1b74c0047fdc"
    public function loginAsAdmin()
    {
        $uid = $this->request->getGet('uid');
        if (!$uid) {
            return redirect()->to(env('app.superAdminURL') . '/admins')->with('error', 'Invalid user ID');
        }
        $admin = (new \App\Models\Admins())->find($uid);
        if (!$admin) {
            return redirect()->to(env('app.superAdminURL') . '/admins')->with('error', 'Admin not found');
        }
        $superAdminSessionData = [
            'uid' => session()->get('uid'),
            'role' => session()->get('role'),
            'isLoggedIn' => session()->get('isLoggedIn')
        ];
        if ($superAdminSessionData['role'] === 'super_admin') {
            session()->set([
                'superAdminSessionData' => $superAdminSessionData,
                'uid' => $uid,
                'role' => 'admin',
                'isLoggedIn' => true
            ]);
            return redirect()->to(env('app.adminURL') . '/dashboard')->with('success', 'You are now logged in as admin - ' . $admin['name']);
        }
        return redirect()->to(env('app.superAdminURL') . '/admins')->with('error', 'You are not authorized to do this action');
    }
}

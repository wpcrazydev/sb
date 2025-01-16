<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Users;
use Config\Services;
use CodeIgniter\Cookie\Cookie;

include_once APPPATH. 'Controllers/CommonController.php';

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new Users();
        $this->encryption = Services::encrypter();
        $this->email = Services::email();
        helper('text');
    }

    // @ioncube.dk dynamicHash("6Zl8qEeQyzeGx9dD", "dDLy3wLgWzUgOASK") -> "ed46798a1def08f3b612fb724bc49715b0c6cf2d11940549a6f4926f4ccdbbe0"
    public function login()
    {
        $successRedirecTo = 'dashboard';
        if ($this->request->getMethod() == 'GET') {
            if (session()->has('isLoggedIn') && session()->has('role') && session()->get('role') == 'user') {
                return redirect()->to('/user/' . $successRedirecTo);
            }
            $siteAdminToken = (new \App\Controllers\HomeController)->siteAdminToken();
            $watermark = (new \App\Controllers\HomeController)->watermark();
            $packages = (new \App\Models\Packages)->findAll();
            return view('site/loginPage', ['title' => 'Login', 'siteAdminToken' => $siteAdminToken, 'watermark' => $watermark, 'packages' => $packages]);
        }
        $data = $this->request->getPost();
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        $user = $this->userModel->where('email', $data['email'])->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Account not found');
        }
        if (!password_verify($data['password'], $user['password'])) {
            return redirect()->back()->with('error', 'Invalid password');
        }
        session()->set([
            'uid' => $user['id'],
            'role' => 'user',
            'isLoggedIn' => true,
            'failed_attempts' => 0,
            'lock_time' => null
        ]);
        return redirect()->to('/user/' . $successRedirecTo)->with('success', 'Login successful');
    }

    // @ioncube.dk dynamicHash("kZ6ohXKnFYX32MzG", "F1GktwKdZ2hIO0JG") -> "8e673ee728b3407ad4c3e9153e20dd483b1bf957762ad35e4379f130afed883d"
    public function forgotPassword()
    {
        if ($this->request->getMethod() == 'GET') {
            return view('site/forgotPassword', [
                'title' => 'Forgot Password',
                'siteAdminToken' => (new \App\Controllers\HomeController)->siteAdminToken(),
                'packages' => (new \App\Models\Packages)->findAll(),
                'watermark' => (new \App\Controllers\HomeController)->watermark()
            ]);
        }
        $data = $this->request->getPost();
        $rules = [
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->getErrors());
        }
        $user = $this->userModel->where('email', $data['email'])->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Account not found');
        }
        $tokenData = [
            'id' => $user['id'],
            'expiry' => time() + (15 * 60)
        ];
        $token = $this->encryption->encrypt(json_encode($tokenData));
        $emailData = [
            'username' => $user['name'],
            'token' => base64_encode($token),
            'path' => ''
        ];
        $subject = 'Forgot Password | ' . env('app.name');
        $template = 'emails/forgotPassword';

        $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->email->setTo($user['email']);
        $this->email->setSubject($subject);
        $this->email->setMessage(view($template, $emailData));
        $mailResult = $this->email->send();
        log_message('info', 'Mail Log Data' . $mailResult);
        if (!$mailResult) {
            return redirect()->to('/forgot-password')->with('error', 'Failed to send email');
        }
        return redirect()->to('/forgot-password')->with('success', 'Password reset link has been sent to your email! Please check your inbox.');
    }

    // @ioncube.dk dynamicHash("hcj9zWh2oBBbZnU0", "9bnj4yfVuB6nBEAV") -> "39bcbf9449496911cef338ae3ae116911a2ca9dd11f3ca6ca2d2534889427264"
    public function resetPassword($token = null)
    {
        if ($this->request->getMethod() == 'GET') {
            return view('site/resetPassword', [
                'title' => 'Reset Password',
                'siteAdminToken' => (new \App\Controllers\HomeController)->siteAdminToken(),
                'packages' => (new \App\Models\Packages)->findAll(),
                'watermark' => (new \App\Controllers\HomeController)->watermark(),
                'token' => $token
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
        $base64Decoded = base64_decode($data['token']);
        $token = $this->encryption->decrypt($base64Decoded);
        $tokenData = json_decode($token, true);
        if (!$tokenData || time() > $tokenData['expiry']) {
            return redirect()->to('/login')->with('error', 'Invalid token');
        }
        $user = $this->userModel->find($tokenData['id']);
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Invalid token');
        }
        $this->userModel->update($user['id'], [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/login')->with('success', 'Password reset successful');
    }

    public function profile()
    {
        return $this->userModel->find(session()->get('uid'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

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
        $user = $this->userModel->find(session()->get('uid'));
        if (!password_verify($data['current_password'], $user['password'])) {
            return redirect()->back()->with('error', 'Invalid current password');
        }
        $this->userModel->update($user['id'], [
            'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
        ]);
        return redirect()->back()->with('success', 'Password changed successfully');
    }

    // @ioncube.dk dynamicHash("LAg5njgq3l6EFt8e", "oCpNIdSNXj8mTN4j") -> "07a5033a149e305db26b7a32fd88ed5985e22808e051f4e6c20429ca3f15dc92"
    public function loginAsAdmin()
    {
        if (session()->has('adminSessionData') && session()->get('adminSessionData')['role'] === 'admin') {
            session()->remove(['uid', 'role']);
            session()->set([
                'uid' => session()->get('adminSessionData')['uid'],
                'role' => 'admin',
                'isLoggedIn' => true
            ]);
            $adminName = (new \App\Models\Admins())->find(session()->get('uid'))['name'];
            return redirect()->to(env('app.adminURL') . '/dashboard')->with('success', 'You are now logged in as admin - ' . $adminName);
        }
        session()->destroy();
        return redirect()->to(base_url());
    }
}

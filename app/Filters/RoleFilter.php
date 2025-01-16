<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $role = $session->get('role');
        $uri = $request->getPath();

        if ($session->get('isLoggedIn') && strpos($uri, 'login') !== false) {
            switch ($role) {
                case 'super_admin':
                    return redirect()->to('/' . env('app.superAdminURL') . '/dashboard');
                case 'admin':
                    return redirect()->to('/' . env('app.adminURL') . '/dashboard');
                case 'user':
                    return redirect()->to('/user/dashboard');
            }
        }

        if (strpos($uri, 'login') !== false || 
            strpos($uri, 'forgot-password') !== false ||
            strpos($uri, 'forgotPassword') !== false ||
            strpos($uri, 'reset-password') !== false ||
            strpos($uri, 'resetPassword') !== false ||
            strpos($uri, 'license-error') !== false) {
            return;
        }

        if (!$session->has('isLoggedIn') || !$session->get('isLoggedIn')) {
            if (strpos($uri, env('app.superAdminURL') . '/') === 0) {
                return redirect()->to(env('app.superAdminURL') . '/login');
            }
            if (strpos($uri, env('app.adminURL') . '/') === 0) {
                return redirect()->to(env('app.adminURL') . '/login');
            }
            return redirect()->to('/login');
        }

        if ($session->get('isLoggedIn')) {
            if (strpos($uri, env('app.superAdminURL') . '/login') === 0 && $role === 'super_admin') {
                return redirect()->to('/' . env('app.superAdminURL') . '/dashboard');
            }
            if (strpos($uri, env('app.adminURL') . '/login') === 0 && $role === 'admin') {
                return redirect()->to('/' . env('app.adminURL') . '/dashboard');
            }
            if (strpos($uri, 'login') === 0 && $role === 'user') {
                return redirect()->to('/user/dashboard');
            }
        }

        if ($role === 'super_admin' && strpos($uri, env('app.adminURL') . '/') === 0) {
            return redirect()->to('/' . env('app.superAdminURL') . '/dashboard');
        }
        if ($role === 'super_admin' && strpos($uri, 'user/') === 0) {
            return redirect()->to('/' . env('app.superAdminURL') . '/dashboard');
        }
        if ($role === 'admin' && strpos($uri, env('app.superAdminURL') . '/') === 0) {
            return redirect()->to('/' . env('app.adminURL') . '/dashboard');
        }
        if ($role === 'user' && (strpos($uri, env('app.superAdminURL') . '/') === 0 || strpos($uri, env('app.adminURL') . '/') === 0)) {
            return redirect()->to('/user/dashboard');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}

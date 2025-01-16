<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\SuperAdmins;
use App\Models\Admins;
use App\Models\Users;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    protected $userData = null;
    protected $adminData = null;
    protected $superAdminData = null;
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->loadUserData();
        $this->loadAdminData();
        $this->loadSuperAdminData();
    }

    /**
     * Load user data if user is logged in
     */
    private function loadUserData()
    {
        if (session()->has('uid') && session()->get('role') === 'user') {
            $userModel = new Users();
            $this->userData = $userModel->find(session()->get('uid'));
        }
    }

    /**
     * Load admin data if admin is logged in
     */
    private function loadAdminData()
    {
        if (session()->has('uid') && session()->get('role') === 'admin') {
            $adminModel = new Admins();
            $this->adminData = $adminModel->find(session()->get('uid'));
        }
    }

    /**
     * Load super admin data if super admin is logged in
     */
    private function loadSuperAdminData()
    {
        if (session()->has('uid') && session()->get('role') === 'super_admin') {
            $superAdminModel = new SuperAdmins();
            $this->superAdminData = $superAdminModel->find(session()->get('uid'));
        }
    }

}
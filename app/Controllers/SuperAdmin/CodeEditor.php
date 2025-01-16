<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class CodeEditor extends BaseController 
{
    // @ioncube.dk dynamicHash("A7QW7jEsba8wDUfF", "obTMSShm2VcicJu3") -> "5fb706d03665c276629b5719258e0b445f31cc5488b4979863f977171b62108c"
    public function codeEditor($page = null)
    {
        $page = $page ?? $this->request->getVar('page');
        if ($page == 'forgotPassword') {
            $filePath = APPPATH . 'Views/emails/forgotPassword.php';
        }
        if ($page == 'home') {
            $filePath = APPPATH . 'Views/site/homePage.php';
        }
        if ($page == 'about') {
            $filePath = APPPATH . 'Views/site/aboutPage.php';
        }
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
            return view('superAdmin/codeEditor', [
                'content' => $fileContent,
                'page' => $page
            ]);
        }
        return view('superAdmin/codeEditor', [
            'content' => '',
            'page' => $page,
            'error' => 'File not found'
        ]);
    }

    // @ioncube.dk dynamicHash("MJF9NMQMq8jacmxZ", "Y2qhca7wsiT7cnAv") -> "aaad91e6a20dcdb9871006b1438ff3e96de6c6f973f0c75350c757184a8e12b5"
    public function saveCode()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON(true);
            $page = $json['page'] ?? '';
            $content = $json['content'] ?? '';
            if ($page === 'forgotPassword') {
                $filePath = APPPATH . 'Views/emails/forgotPassword.php';
            }
            if ($page === 'home') {
                $filePath = APPPATH . 'Views/site/homePage.php';
            }
            if ($page === 'about') {
                $filePath = APPPATH . 'Views/site/aboutPage.php';
            }
            if (file_put_contents($filePath, $content) !== false) {
                return $this->response->setJSON(['success' => true]);
            }
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to save file']);
        }
        return $this->response->setJSON(['success' => false, 'error' => 'Invalid request']);
    }

    // @ioncube.dk dynamicHash("s7NWAAKshHlhckUP", "lzxGsQi2oSATgwqm") -> "2924a047ca5bc02b27dee45bcfbf69bc6ffb5e732bb3b168403941301247d33d"
    public function loadCss()
    {
        if ($this->request->isAJAX()) {
            $filePath = FCPATH . 'public/assets/custom.css';
            log_message('debug', $filePath);
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                return $this->response->setJSON([
                    'success' => true,
                    'content' => $content
                ]);
            }
            return $this->response->setJSON([
                'success' => false,
                'error' => 'CSS file not found'
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'error' => 'Invalid request'
        ]);
    }

    // @ioncube.dk dynamicHash("9tenB1rUhf7PNOft", "XWM14mFwhojZQ8ZE") -> "760af85cb2b325444fe484e1213994bf080b2b18dde70d7c04365fe056250943"
    public function loadJs()
    {
        if ($this->request->isAJAX()) {
            $filePath = FCPATH . 'public/assets/custom.js';
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                return $this->response->setJSON([
                    'success' => true,
                    'content' => $content
                ]);
            }
            return $this->response->setJSON([
                'success' => false,
                'error' => 'JavaScript file not found'
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'error' => 'Invalid request'
        ]);
    }

    // @ioncube.dk dynamicHash("k6yJQj01FUlFCANn", "aHYosJreVgbQw0Is") -> "23896a66629a0966ef50340e7399edce71bebcfdea9fd315e5e99092e36afb35"
    public function saveCss()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON(true);
            $content = $json['content'] ?? '';
            $filePath = FCPATH . 'public/assets/custom.css';
            if (file_put_contents($filePath, $content) !== false) {
                return $this->response->setJSON(['success' => true]);
            }
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Failed to save CSS file'
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'error' => 'Invalid request'
        ]);
    }

    // @ioncube.dk dynamicHash("9GbHYUIOQUQDjGdK", "2ewfrY3qgvymi0NO") -> "e6a452560964bcbeae4bb276b54d93d958471472573c510db0b361edf017825a"
    public function saveJs()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON(true);
            $content = $json['content'] ?? '';
            $filePath = FCPATH . 'public/assets/custom.js';
            if (file_put_contents($filePath, $content) !== false) {
                return $this->response->setJSON(['success' => true]);
            }
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Failed to save JavaScript file'
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'error' => 'Invalid request'
        ]);
    }
}

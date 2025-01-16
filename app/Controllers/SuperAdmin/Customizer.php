<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Customizer extends BaseController
{
    public function index($type = null)
    {
        if ($type === 'user') {
            $filePath = json_decode(file_get_contents(WRITEPATH . 'static/userTheme.json'), true);
            return $filePath;
        }
        if ($type === 'front') {
            $filePath = json_decode(file_get_contents(WRITEPATH . 'static/frontTheme.json'), true);
            return $filePath;
        }
    }


    public function updateThemeColours()
    {
        if ($this->request->getMethod() === 'POST') {
            $configFile = WRITEPATH . 'static/style.php';
            if (file_exists($configFile)) {
                $themeConfig = require $configFile;
            } else {
                return redirect()->to(env('app.superAdminURL') . '/customizer')->with('error', 'Theme config file not found!');
            }
            foreach ($themeConfig as $section => &$colors) {
                foreach ($colors as $key => &$color) {
                    $colorKey = str_replace('_', '-', $key);
                    if ($this->request->getPost("{$section}[{$colorKey}]") !== null) {
                        $color = $this->request->getPost("{$section}[{$colorKey}]");
                    }
                }
            }
            if ($this->updatePHPFile($configFile, $themeConfig)) {
                return redirect()->to(env('app.superAdminURL') . '/customizer')->with('success', 'Theme colours updated successfully!');
            } else {
                return redirect()->to(env('app.superAdminURL') . '/customizer')->with('error', 'Failed to update theme colors.');
            }
        }
    }
      

    private function updatePHPFile($filePath, $data)
    {
        $phpContent = "<?php\n\nreturn [\n";
        foreach ($data as $key => $value) {
            $phpContent .= $this->convertArrayToString($key, $value);
        }
        $phpContent .= "];\n";
        return file_put_contents($filePath, $phpContent);  // Returns true if success
    }
    
    
    private function convertArrayToString($key, $value, $indent = '    ') {
        $output = $indent . "'" . $key . "' => ";
        if (is_array($value)) {
            $output .= "[\n";
            foreach ($value as $subKey => $subValue) {
                $output .= $this->convertArrayToString($subKey, $subValue, $indent . '    ');
            }
            $output .= $indent . "],\n";
        } else {
            $output .= "'" . $value . "',\n";
        }
        return $output;
    }
    

}

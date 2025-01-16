<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class HomeController extends BaseController
{
    protected $userAuthController;

    public function __construct()
    {
        $this->app = new \App\Controllers\AppController();
        $this->packages = new \App\Models\Packages();
        $this->encryption = \Config\Services::encrypter();
        $this->vipMembers = new \App\Models\VipMembers();
    }

    // @ioncube.dk dynamicHash("WpHesALhuOUzF1Er", "8nKbPb4ERPscYGXF") -> "3e24747c60cdde658716bb69258f8bd0fea0f26204b87b97218094487b1d97bc"
    public function siteAdminToken()
    {
        $filePath = WRITEPATH . 'static/admin.json';
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
            return json_decode($fileContent, true);
        }
        return false;
    }

    // @ioncube.dk dynamicHash("hBmshuR7yJ23sIkq", "1Su1IF05Sxl3Q1I9") -> "1e15f919352e74d804351b77eb6f6c141236261fa620d3195490c572314420fb"
    public function agencyToken()
    {
        $filePath = WRITEPATH . 'static/agency.json';
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
            $decoded = json_decode($fileContent, true);
            if (is_array($decoded)) {
                if (isset($decoded['agency_label']) && isset($decoded['agency_url']) && isset($decoded['help_url']) && isset($decoded['cart_url'])) {
                    $decoded['agency_label'] = $this->encryption->decrypt($decoded['agency_label']);
                    $decoded['agency_url'] = $this->encryption->decrypt($decoded['agency_url']);
                    $decoded['help_url'] = $this->encryption->decrypt($decoded['help_url']);
                    $decoded['cart_url'] = $this->encryption->decrypt($decoded['cart_url']);
                    return $decoded;
                }
            }
        }
        $data = [
            'agency_label' => 'Bizfunnel',
            'agency_url' => 'https://bizfunnel.in/affiliate-marketing-website',
            'help_url' => 'https://bizfunnel.in/help',
            'cart_url' => 'https://bizfunnel.in/cart'
        ];
        return $data;
    }

    // @ioncube.dk dynamicHash("M1UGCHiTZJXP0y5w", "mWTFksOkQ8bM2WWb") -> "7e26a3b2c7f9b6992b75b31afd588595eef829251e75e57e2b7f191da55b86a3"
    public function watermark()
    {
        $data = $this->agencyToken();
        $randomClass = random_string('alnum', 10) . '-' . random_string('alnum', 10) . '-' . random_string('alnum', 10) . '-' . random_string('alnum', 10);
        $watermark = '<style>
            .' . $randomClass . ' {
                font-size: 16px !important;
                pointer-events: auto;
            }
            @media only screen and (max-width: 767px) {
                .' . $randomClass . ' {
                    font-size: 13px !important;
                    margin-top: 5px !important;
                    text-align: center !important;
                }
            }
        </style>
        <div class="' . $randomClass . '" style="display: block !important; text-align: right;"> Designed By <a href="' . $data['agency_url'] . '" target="_blank" class="text-white">' . $data['agency_label'] . '</a></div>
        <script>
            const watermarkElement = document.querySelector(".' . $randomClass . '");
            const observer = new MutationObserver(() => {
                watermarkElement.style.cssText = "";
                watermarkElement.className = "" + watermarkElement.className;
            });
            observer.observe(watermarkElement, { attributes: true, childList: true, subtree: true });
            const parentElement = watermarkElement.parentElement;
            const parentObserver = new MutationObserver(() => {
                parentElement.style.display = "";
                parentElement.style.visibility = ""; 
                parentElement.style.opacity = "1";
                parentElement.className = parentElement.className;
            });
            parentObserver.observe(parentElement, { attributes: true });
            const classObserver = new MutationObserver(() => {
                const originalClass = parentElement.className;
                parentElement.className = originalClass;
            });
            classObserver.observe(parentElement, { attributes: true });
        </script>';

        $footerFilePath = APPPATH . 'Views/site/footer.php';
        $footerContent = file_get_contents($footerFilePath);
        if (strpos($footerContent, '$watermark') === false) {
            die('Something happened to your website. Please contact website developer and share this error code: CONTENTERROR-404');
        }
        return $watermark;
    }



    // @ioncube.dk dynamicHash("T2tHoaXaMluQaKnr", "NkWq1YFWAhp8m0EE") -> "2785cdc417d5c6aef969c589a2c600f68cdbaa1b6511752f36608a67a4ea7d9a"
    public function index()
    {
        $this->app->checkLicense();
        $packages = $this->packages->where('status', 'active')->findAll();
        $banners = (new \App\Models\Banners())->findAll();
        $siteAdminToken = $this->siteAdminToken();
        $featuredCourses = (new \App\Models\Courses())->where('featured', 'yes')->findAll();
        $feedbacks = (new \App\Models\Testimonials())->findAll();
        $instructors = (new \App\Models\Instructors())->findAll();
        $faqs = (new \App\Models\Faqs())->findAll();
        $legalCertificates = (new \App\Models\LegalCertificates())->findAll();
        return view('site/homePage', [
            'title' => 'Home',
            'packages' => $packages,
            'banners' => $banners,
            'siteAdminToken' => $siteAdminToken,
            'featuredCourses' => $featuredCourses,
            'feedbacks' => $feedbacks,
            'instructors' => $instructors,
            'vipMembers' => $this->vipMembers->findAll(),
            'faqs' => $faqs,
            'legalCertificates' => $legalCertificates,
            'watermark' => $this->watermark()
        ]);
    }

    public function about()
    {
        $this->app->checkLicense();
        $packages = $this->packages->findAll();
        $siteAdminToken = $this->siteAdminToken();
        return view('site/aboutPage', [
            'title' => 'About',
            'packages' => $packages,
            'siteAdminToken' => $siteAdminToken,
            'watermark' => $this->watermark()
        ]);
    }

    public function contact()
    {
        if ($this->request->getMethod() == 'post') {
            return $this->contactFormProcess();
        }
        $siteAdminToken = $this->siteAdminToken();
        $packages = $this->packages->findAll();
        return view('site/contactPage', [
            'title' => 'Contact',
            'siteAdminToken' => $siteAdminToken,
            'packages' => $packages,
            'watermark' => $this->watermark()
        ]);
    }

    // @ioncube.dk dynamicHash("ucGGOMC3yhVgOSnk", "Na8IigBp2Sy8e3wW") -> "6fcedd9160c060dc06cb6f11e04c32fe1c5a3124684e078d63caf3e37e04b2a0"
    public function contactFormProcess()
    {
        $this->app->checkLicense();
        $data = $this->request->getPost();
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|valid_email',
            'message' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please fill all the required fields');
        }
        (new \App\Models\Contacts())->insert($data);
        return redirect()->to('/thank-you');
    }

    private function getPolicies($name)
    {
        $filePath = WRITEPATH . 'static/policies.json';
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
            $decoded = json_decode($fileContent, true);
            if (is_array($decoded)) {
                if (isset($decoded['policies'])) {
                    foreach ($decoded['policies'] as $policy) {
                        if ($policy['policy'] == $name) {
                            return $policy['data'];
                        }
                    }
                }
            }
        }
        return false;
    }

    public function terms()
    {
        $this->app->checkLicense();
        return view('site/termsPage', [
            'title' => 'Terms',
            'packages' => $this->packages->findAll(),
            'siteAdminToken' => $this->siteAdminToken(),
            'watermark' => $this->watermark(),
            'content' => $this->getPolicies('terms_and_conditions')
        ]);
    }

    public function privacy()
    {
        $this->app->checkLicense();
        return view('site/privacyPage', [
            'title' => 'Privacy',
            'packages' => $this->packages->findAll(),
            'siteAdminToken' => $this->siteAdminToken(),
            'watermark' => $this->watermark(),
            'content' => $this->getPolicies('privacy_policy')
        ]);
    }

    public function disclaimer()
    {
        $this->app->checkLicense();
        return view('site/disclaimerPage', [
            'title' => 'Disclaimer',
            'packages' => $this->packages->findAll(),
            'siteAdminToken' => $this->siteAdminToken(),
            'watermark' => $this->watermark(),
            'content' => $this->getPolicies('disclaimer')
        ]);
    }

    public function refund()
    {
        $this->app->checkLicense();
        return view('site/refundPage', [
            'title' => 'Refund',
            'packages' => $this->packages->findAll(),
            'siteAdminToken' => $this->siteAdminToken(),
            'watermark' => $this->watermark(),
            'content' => $this->getPolicies('refund_policy')
        ]);
    }

}
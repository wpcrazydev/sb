<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
include_once APPPATH. 'Controllers/CommonController.php';
class HomeController extends BaseController
{
    public function __construct()
    {
        $this->userModel = new \App\Models\Users();
        $this->commission = new \App\Models\Commission();
        $this->package = new \App\Models\Packages();
        $this->upgradePackage = new \App\Models\UpgradePackages();
        $this->kyc = new \App\Models\Kyc();
        $this->payouts = new \App\Models\Payouts();
        $this->home = new \App\Controllers\HomeController();
        $this->walletLog = new \App\Models\WalletLog();
    }

    public function getUserPackage() {
        $packageName = $this->package->find($this->userData['plan_id'])['name'] ?? env('app.name');
        return $packageName ?? env('app.name');
    }

    public function changeDashboard()
    {
        $data = json_decode($this->request->getBody(), true);
        if (isset($data['dashboard'])) {
            $this->userModel->update($this->userData['id'], ['dashboard' => $data['dashboard']]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Dashboard changed successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function overview() 
    {
        return view('user/overview', [
            'title' => 'Overview',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage()
        ]);
    }

    // @ioncube.dk dynamicHash("8TSUnj5XLF2KQJoE", "FayOiMxlpVkRG9bR") -> "8feab3a85fd00b455d736a34582dc6e440151c0c2f7b3e1d09e4d4166240002f"
    public function dashboard() {
        return view('user/dashboard', [
            'title' => 'Dashboard',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'todayEarnings' => $this->sumTodayEarnings(),
            'sevenDaysEarnings' => $this->sum7DaysEarnings(),
            'thirtyDaysEarnings' => $this->sum30DaysEarnings(),
            'allEarnings' => $this->sumAllEarnings()
        ]);
    }

    // @ioncube.dk dynamicHash("9nCJHKvB45RpInd4", "dEelm7FnYLCWbPnL") -> "d8f1dea0d6cce42197a3898b7cbd92f9b6bcc2e45223e56644a4416f58c034d2"
    public function sumTodayEarnings() {
        $today = date('Y-m-d');
        $commissions = $this->commission->where('DATE(updated_at)', $today)->where('status', 'verified')->where('user_id', session()->get('uid'))->findAll();
        return array_sum(array_column($commissions, 'amount'));
    }

    // @ioncube.dk dynamicHash("uAa9kOeZu0ew1brT", "wUsVLSOD7CKH3ucr") -> "72ab4de9cc10023beb6e0907e83dad1f86c6ad6092211facc307ef36b4847656"
    public function sum7DaysEarnings() {
        $startDate = date('Y-m-d', strtotime('-7 days'));
        $commissions = $this->commission->where('updated_at >=', $startDate . ' 00:00:00')->where('updated_at <=', date('Y-m-d H:i:s'))->where('status', 'verified')->where('user_id', session()->get('uid'))->findAll();
        return array_sum(array_column($commissions, 'amount'));
    }

    // @ioncube.dk dynamicHash("jbQ5EiqiVzG1y4xP", "JNPFm7t3TU5Hi0Yx") -> "ba6b153d5c4bc1a5c3ef6a21345f10fe60ff44ced6188235000c33c2d0c5aad0"
    public function sum30DaysEarnings() {
        $startDate = date('Y-m-d', strtotime('-30 days'));
        $commissions = $this->commission->where('updated_at >=', $startDate . ' 00:00:00')->where('updated_at <=', date('Y-m-d H:i:s'))->where('status', 'verified')->where('user_id', session()->get('uid'))->findAll();
        return array_sum(array_column($commissions, 'amount'));
    }

    // @ioncube.dk dynamicHash("3aPB4LqT1XYxT7Ev", "zmKDE1Dg47Lg66HK") -> "608b86d72d4acd5932e0f21edb32f06b3f78a72fb3936f68d61dab03fcb7d684"
    public function sumAllEarnings() {
        $commissions = $this->commission->where('status', 'verified')->where('user_id', session()->get('uid'))->findAll();
        return array_sum(array_column($commissions, 'amount'));
    }

    // @ioncube.dk dynamicHash("xTivoCvbZX78tZZM", "zGv9CkYAz3wwT9P0") -> "8217e69666d1dac71a05bfa0427a6eb369fb4b83a424c7c4dbbadfaf7be17a4e"
    public function refLinks() {
        return view('user/refLinks', [
            'title' => 'Referral Links',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'packages' => $this->package->findAll()
        ]);
    }

    // @ioncube.dk dynamicHash("2O8aiAvsu8bQBpzm", "CIeYR5mVEXfi456g") -> "fa3301f2b5286ffee525c64377abd801af011bbe08e9ad26836ab09ff2aa440f"
    public function profile() {
        if ($this->request->getMethod() == 'POST') {
            return $this->updateProfile($this->userData['id']);
        }
        return view('user/profile', [
            'title' => 'Profile',
            'userData' => $this->userData,
            'tab' => $this->request->getGet('tab') ?? 'overview',
            'packageName' => $this->getUserPackage(),
            'userPkgInfo' => $this->package->find($this->userData['plan_id']),
            'kycStatus' => $this->kyc->where('user_id', $this->userData['id'])->first()['status'] ?? 'Not Submitted',
            'sponsorName' => $this->userModel->find($this->userData['parent_id'])['name'] ?? 'N/A',
            'pendingWithdrawal' => $this->payouts->where('user_id', $this->userData['id'])->where('status', 'pending')->first()['amount'] ?? 0,
            'minPayout' => $this->home->siteAdminToken()['min_payout']
        ]);
    }

    // @ioncube.dk dynamicHash("ycFSrPQ5MLKaB5Q8", "9SmzgWmGJH6bH3P3") -> "1b7c0f06b1dfd61cbc3f50bedd586a9235d6d5b8445846c11bd96e0f185332bf"
    public function updateProfile($id = null) {
        $data = $this->request->getPost();
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
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('user/profile')->with('error', $this->validator->getErrors());
        }
        if (!empty($this->request->getFile('image')->getName())) {
            $existingImage = $this->userModel->find($id)['image'];
            if ($existingImage) {
                if (file_exists(ROOTPATH . 'public/uploads/profiles/' . $existingImage)) {
                    unlink(ROOTPATH . 'public/uploads/profiles/' . $existingImage);
                }
            }
            $file = $this->request->getFile('image');
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/profiles/', $newName);
                $data['image'] = $newName;
            }
        }
        if (isset($data['email'])) {
            unset($data['email']);
        }
        if ($this->userModel->update($id, $data)) {
            return redirect()->to('user/profile')->with('success', 'Profile updated successfully');
        }
        return redirect()->to('user/profile')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("Wc4uMtq3bFfX69UJ", "NjMatF295WcOVsJW") -> "fa36d672f3712fcab9db679f3bf5269da7a1f9b6f2f58c8aeab9689863f388bf"
    public function updateKyc() {
        $data = $this->request->getPost();
        if (isset($data['status'])) {
            unset($data['status']);
        }
        $data['user_id'] = $this->userData['id'];
        if ($this->home->siteAdminToken()['direct_kyc'] === 'active') {
            $data['status'] = 'approved';
        } else {
            $data['status'] = 'pending';
        }
        if ($kycData = $this->kyc->where('user_id', $this->userData['id'])->first()) {
            if ($this->kyc->update($kycData['id'], $data)) {
                return redirect()->to('user/profile')->with('success', 'KYC updated successfully');
            }
        } else {
            if ($this->kyc->insert($data)) {
                return redirect()->to('user/profile')->with('success', 'KYC submitted successfully');
            }
        }
        return redirect()->to('user/profile')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("HXabEuEIx4e2Nndz", "P3btPtUPgHtUaYhe") -> "5d9a02fd497fcb74e5795275f7136287a71dfe5d0549225b5ed96a53f4cd8f74"
    public function withdraw() {
        $data = $this->request->getPost();
        if ($kycData = $this->kyc->where('user_id', $this->userData['id'])->first()) {
            if (!$kycData) {
                return redirect()->to('user/profile')->with('error', 'Please submit your KYC first');
            }
            if ($kycData['status'] == 'rejected') {
                return redirect()->to('user/profile')->with('error', 'Your KYC has been rejected. Please resubmit your KYC');
            }
            if ($kycData['status'] != 'approved') {
                return redirect()->to('user/profile')->with('error', 'Please wait for KYC approval');
            }
        }
        if  ($data['amount'] < $this->home->siteAdminToken()['min_payout']) {
            return redirect()->to('user/profile')->with('error', 'Minimum withdrawal amount is ' . $this->home->siteAdminToken()['min_payout']);
        }
        if  ($data['amount'] > $this->userModel->find($this->userData['id'])['wallet']) {
            return redirect()->to('user/profile')->with('error', 'Insufficient wallet balance');
        }
        $data['user_id'] = $this->userData['id'];
        $data['status'] = 'pending';
        if ($this->payouts->where('user_id', $this->userData['id'])->where('status', 'pending')->first()) {
            return redirect()->to('user/profile')->with('error', 'You already have a pending withdrawal request');
        }
        if ($this->payouts->insert($data)) {
            if ($this->userModel->update($this->userData['id'], ['wallet' => $this->userData['wallet'] - $data['amount']])) {
                $this->walletLog->insert([
                    'uid' => $this->userData['id'],
                    'amount' => $this->userData['wallet'],
                    'updated_amount' => $data['amount'],
                    'balance' => $this->userData['wallet'] - $data['amount'],
                    'type' => 'debit',
                    'description' => 'Withdrawal request submitted'
                ]);
                return redirect()->to('user/profile')->with('success', 'Withdrawal request submitted successfully');
            }
        }
        return redirect()->to('user/profile')->with('error', 'Something went wrong');
    }

    public function affiliateLink() {
        return view('user/refLinks', [
            'title' => 'Affiliate Link',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'packages' => $this->package->findAll()
        ]);
    }

    // @ioncube.dk dynamicHash("I7VI2ehoiq9DCFq2", "yfF73Tudz1Nlgbz7") -> "35c44a500b9cc147e2cde8678a62469a07558a3cff0beedbe590f219d7ab2d82"
    public function team() {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalRows = count($this->userModel->where('parent_id', $this->userData['id'])->findAll());
        $totalPages = ceil($totalRows / $perPage);
        $teamMembers = $this->userModel->where('parent_id', $this->userData['id'])->findAll($perPage, $offset);
        $packages = [];
        foreach ($teamMembers as $team) {
            $packages[$team['plan_id']] = $this->package->find($team['plan_id'])['name'] ?? 'N/A';
        }
        return view('user/team', [
            'title' => 'My Team',
            'userData' => $this->userData,
            'teamMembers' => $teamMembers,
            'packages' => $packages,
            'packageName' => $this->getUserPackage(),
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // @ioncube.dk dynamicHash("Z8k2aIkOqscFfcgQ", "0rY30mSJUrmPqB1M") -> "4e98a3579ec4b822b49067712dd0e59722941c25517f5ad06e83400b26beed30"
    public function referrals() {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalRows = count($this->commission->where('user_id', $this->userData['id'])->findAll());
        $totalPages = ceil($totalRows / $perPage);
        $referrals = $this->commission->where('user_id', $this->userData['id'])->orderBy('created_at', 'DESC')->findAll($perPage, $offset);
        $users = [];
        foreach ($referrals as $referral) {
            $users[$referral['from_uid']] = $this->userModel->find($referral['from_uid'])['name'] ?? 'N/A';
        }
        return view('user/referrals', [
            'title' => 'My Referrals',
            'userData' => $this->userData,
            'referrals' => $referrals,
            'packageName' => $this->getUserPackage(),
            'users' => $users,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // @ioncube.dk dynamicHash("0cWAomCWSeqz40nm", "EaxkH6o9gcyWz8O9") -> "ca40a5e29b48d125851017a43d2719e614da86efc3aae1ac69be8a5b4f0320d4"
    public function payouts() {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalRows = count($this->payouts->where('user_id', $this->userData['id'])->findAll());
        $totalPages = ceil($totalRows / $perPage);
        $payouts = $this->payouts->where('user_id', $this->userData['id'])->findAll($perPage, $offset);
        return view('user/payouts', [
            'title' => 'My Payouts',
            'userData' => $this->userData,
            'payouts' => $payouts,
            'packageName' => $this->getUserPackage(),
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // @ioncube.dk dynamicHash("ja7xRRgvJQL11N1l", "skB0f3BIBA81vz8O") -> "82aeebcc74dfb12fac70ecdf22fce584b761bf032e4a2250fc614c85d3014632"
    public function walletHistory() {
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalRows = count($this->walletLog->where('uid', $this->userData['id'])->findAll());
        $totalPages = ceil($totalRows / $perPage);
        $walletHistory = $this->walletLog->where('uid', $this->userData['id'])->findAll($perPage, $offset);
        return view('user/walletHistory', [
            'title' => 'My Wallet History',
            'userData' => $this->userData,
            'walletHistory' => $walletHistory,
            'packageName' => $this->getUserPackage(),
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function trainings() {
        $trainings = new \App\Models\Trainings();
        return view('user/trainings', [
            'title' => 'Trainings',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'trainings' => $trainings->findAll()
        ]);
    }

    public function webinars() {
        $webinars = new \App\Models\Webinars();
        return view('user/webinars', [
            'title' => 'Webinars',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'webinars' => $webinars->findAll()
        ]);
    }

    public function offers() {
        $offers = new \App\Models\LiveOffers();
        return view('user/offers', [
            'title' => 'Live Offers',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'offers' => $offers->findAll()
        ]);
    }

    public function community() {
        $community = new \App\Models\CommunityLinks();
        return view('user/community', [
            'title' => 'Community',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'community' => $community->findAll()
        ]);
    }

    // @ioncube.dk dynamicHash("z1zjdg52ldWNXedm", "KNmWdHunnI6VQHxL") -> "3422fd0ac1b841134c7ff8b859ab1c072f15c151d5ed9df664b56fd48b6e22f4"
    public function courses() {
        $courseModel = new \App\Models\Courses();
        $packageModel = new \App\Models\Packages();
        $userPackageData = $packageModel->find($this->userData['plan_id']);
        $packages = $packageModel->findAll();
        $allCourses = [];
    
        foreach ($packages as $package) {
            if ($package['price'] <= $userPackageData['price']) {
                // Merge all courses into a flat array
                $allCourses = array_merge($allCourses, $courseModel->where('package_id', $package['id'])->findAll());
            }
        }
    
        return view('user/courses', [
            'title' => 'Courses',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'courses' => $allCourses, // Flat array of courses
            'packages' => $packages,
            'userPackageData' => $userPackageData
        ]);
    }    
     

    // @ioncube.dk dynamicHash("oWuvYPIylmeq53FJ", "6RS69qNbo3kdxlul") -> "1a0a903fdd749d74a4fb42c846925d735f672174b99ea6fd56a88b72e1fba832"
    public function courseView() {
        $courses = new \App\Models\Courses();
        $courseLinks = new \App\Models\CourseLinks();
        $watchedCourses = new \App\Models\WatchedCourses();
        $courseId = $courses->find($this->request->getGet('course'));
        $videoId = $this->request->getGet('video');
        if ($videoId) {
            $selectedVideoLink = $courseLinks->find($videoId);
        }
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 2;
        $offset = ($page - 1) * $perPage;
        $totalRows = count($courseLinks->where('course_id', $courseId['id'])->findAll());
        $totalPages = ceil($totalRows / $perPage);
        $videoLinks = $courseLinks->where('course_id', $courseId['id'])->findAll($perPage, $offset);
        $watchedCourse = $watchedCourses->where('user_id', $this->userData['id'])->where('course_id', $courseId['id'])->first();
        return view('user/courseView', [
            'title' => $courseId['name'],
            'userData' => $this->userData,
            'course' => $courseId,
            'videoLinks' => $videoLinks,
            'selectedVideoLink' => $selectedVideoLink ?? $videoLinks[0],
            'watchedCourse' => $watchedCourse,
            'packageName' => $this->getUserPackage(),
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

    // @ioncube.dk dynamicHash("zlaSqH2RhcgvWO3u", "dnqGHHqRVwWg60Iw") -> "706dc147b65d012a193571a67b6f09f0a55c337e48e94d0f79038a7e69d98f52"
    public function markCourseComplete() {
        $data = $this->request->getPost();
        $watchedCoursesModel = new \App\Models\WatchedCourses();
        $data['user_id'] = $this->userData['id'];
        if ($watchedCoursesModel->insert($data)) {
            return redirect()->to('user/certificates')->with('success', 'Course ' . $data['course_name'] . ' marked as complete');
        }
        return redirect()->to('user/courses')->with('error', 'Something went wrong');
    }

    // @ioncube.dk dynamicHash("o81UKcqyIsvMc2be", "6xoCoYFCd5ExRPAX") -> "3e1a410d885674d4303420ef2835d3da4ca2def771b895d83e3f87cd29d4edb2"
    public function certificates() {
        $courses = new \App\Models\Courses();
        $watchedCourses = new \App\Models\WatchedCourses();
        return view('user/certificates', [
            'title' => 'Certificates',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'courses' => $courses->where('package_id', $this->userData['plan_id'])->findAll(),
            'watchedCourseIds' => $watchedCourses->where('user_id', $this->userData['id'])->findColumn('course_id') ?? []
        ]);
    }
    

    public function todayLeaderboard() {
        $commissions = new \App\Models\Commission();
        $builder = $commissions->builder();
        $builder->select('commission.id, user_id, SUM(amount) as amount, u.name, u.image')->where('commission.status', 'verified');
        $builder->where('DATE(biz_commission.updated_at)', date('Y-m-d'));
        $builder->groupBy('user_id');
        $builder->orderBy('amount', 'desc');
        $builder->join('users u', 'u.id = commission.user_id', 'left');
        $builder->where('u.lb_status', 'active');
        $query = $builder->get();
        $users = $query->getResult();
        $leaderboardData = [];
        foreach ($users as $user) {
            $leaderboardData[] = [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'amount' => $user->amount,
                'name' => $user->name ?? 'N/A',
                'image' => $user->image ?? 'N/A',
            ];
        }
        $leaderboardData = array_slice($leaderboardData, 0, 10);
        
        return [
            'leaderboard' => $leaderboardData,
        ];
    }   
    
    public function weeklyLeaderboard() {
        $commissions = new \App\Models\Commission();
        $builder = $commissions->builder();
        $builder->select('commission.id, user_id, SUM(amount) as amount, u.name, u.image')->where('commission.status', 'verified');
        $builder->where('DATE(biz_commission.updated_at) >=', date('Y-m-d', strtotime('-7 days')));
        $builder->groupBy('user_id');
        $builder->orderBy('amount', 'desc');
        $builder->join('users u', 'u.id = commission.user_id', 'left');
        $builder->where('u.lb_status', 'active');
        $query = $builder->get();
        $users = $query->getResult();
        $leaderboardData = [];
        foreach ($users as $user) {
            $leaderboardData[] = [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'amount' => $user->amount,
                'name' => $user->name ?? 'N/A',
                'image' => $user->image ?? 'N/A',
            ];
        }
        $leaderboardData = array_slice($leaderboardData, 0, 10);
        
        return [
            'leaderboard' => $leaderboardData,
        ];
    }  
     
    public function monthlyLeaderboard() {
        $commissions = new \App\Models\Commission();
        $builder = $commissions->builder();
        $builder->select('commission.id, user_id, SUM(amount) as amount, u.name, u.image')->where('commission.status', 'verified');
        $builder->where('DATE(biz_commission.updated_at) >=', date('Y-m-d', strtotime('-30 days')));
        $builder->groupBy('user_id');
        $builder->orderBy('amount', 'desc');
        $builder->join('users u', 'u.id = commission.user_id', 'left');
        $builder->where('u.lb_status', 'active');
        $query = $builder->get();
        $users = $query->getResult();
        $leaderboardData = [];
        foreach ($users as $user) {
            $leaderboardData[] = [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'amount' => $user->amount,
                'name' => $user->name ?? 'N/A',
                'image' => $user->image ?? 'N/A',
            ];
        }
        $leaderboardData = array_slice($leaderboardData, 0, 10);
        
        return [
            'leaderboard' => $leaderboardData,
        ];
    }  
     
    public function allTimeLeaderboard() {
        $commissions = new \App\Models\Commission();
        $builder = $commissions->builder();
        $builder->select('commission.id, user_id, SUM(amount) as amount, u.name, u.image')->where('commission.status', 'verified');
        $builder->groupBy('user_id');
        $builder->orderBy('amount', 'desc');
        $builder->join('users u', 'u.id = commission.user_id', 'left');
        $builder->where('u.lb_status', 'active');
        $query = $builder->get();
        $users = $query->getResult();
        $leaderboardData = [];
        foreach ($users as $user) {
            $leaderboardData[] = [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'amount' => $user->amount,
                'name' => $user->name ?? 'N/A',
                'image' => $user->image ?? 'N/A',
            ];
        }
        $leaderboardData = array_slice($leaderboardData, 0, 10);
        
        return [
            'leaderboard' => $leaderboardData,
        ];
    }   


    // @ioncube.dk dynamicHash("j4oL5cIQkjSNzBp0", "Zx6YZOeh0Ts5gHdf") -> "e7e6d3abc5472a7286df11fd6b6975ffa41ef4fef287c96231909bd3c31f9713"
    public function leaderboard() {
        return view('user/leaderboard', [
            'title' => 'Leaderboard',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'siteAdminToken' => $this->home->siteAdminToken(),
            'todayLeaderboard' => $this->todayLeaderboard(),
            'weeklyLeaderboard' => $this->weeklyLeaderboard(),
            'monthlyLeaderboard' => $this->monthlyLeaderboard(),
            'allTimeLeaderboard' => $this->allTimeLeaderboard()
        ]);
    }

    public function upgrade() {
        return view('user/upgrade', [
            'title' => 'Upgrade',
            'userData' => $this->userData,
            'packageName' => $this->getUserPackage(),
            'siteAdminToken' => $this->home->siteAdminToken(),
            'packages' => $this->upgradePackage->where('status', 'active')->where('upgrade_from', $this->userData['plan_id'])->findAll()
        ]);
    }

    public function getLast7DaysSalesData()
    {
        $response = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $earnings = $this->commission->where('user_id', $this->userData['id'])->where('DATE(created_at)', $date)->where('status', 'verified')->selectSum('amount')->first();
            $response[] = [
                'date' => date('M d', strtotime($date)),
                'amount' => $earnings['amount'] ?? 0
            ];
        }
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $response
        ]);
    }
}

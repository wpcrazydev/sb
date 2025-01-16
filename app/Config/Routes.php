<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('test', function() {
    phpinfo();
});
$routes->group('installer', function($routes) {
    $routes->get('/', 'Installer::index');
    $routes->post('requirements', 'Installer::checkRequirements');
    $routes->post('verifyKey', 'Installer::verifyKey');
    $routes->post('verifyDatabase', 'Installer::checkDatabase');
    $routes->post('verifyAdmin', 'Installer::checkAdmin');
    $routes->post('websiteDetails', 'Installer::websiteDetails');
    $routes->post('finalize', 'Installer::finalize');
});

// Cron Routes
$routes->get('cron/check-version', 'Core\UpdateController::checkVersion');

// Core Routes
$routes->get('core/license-error', 'Core\HomeController::licenseError');

// Home Get Route
$routes->get('/', 'HomeController::index');
$routes->get('home', 'HomeController::index');
$routes->get('about', 'HomeController::about');
$routes->match(['GET', 'POST'], 'contact', 'HomeController::contact');
$routes->get('disclaimer', 'HomeController::disclaimer');
$routes->get('privacy-policy', 'HomeController::privacy');
$routes->get('refund-policy', 'HomeController::refund');
$routes->get('terms', 'HomeController::terms');

// User Auth Get & Post Routes
$routes->match(['GET', 'POST'], 'login', 'User\AuthController::login');
$routes->match(['GET', 'POST'], 'register', 'User\AuthController::register');
$routes->match(['GET', 'POST'], 'forgot-password', 'User\AuthController::forgotPassword');
$routes->match(['GET', 'POST'], 'reset-password/(:any)', 'User\AuthController::resetPassword/$1');

// User Checkout Post Route
$routes->match(['GET', 'POST'], 'checkout', 'OrderController::checkout');
$routes->get('payment', 'PaymentController::payment');
$routes->get('order-failed', 'PaymentController::orderFailed');
$routes->get('order-success', 'PaymentController::orderSuccess');
$routes->post('verify/wallet', 'PaymentController::walletVerify');
$routes->post('callback/wallet', 'PaymentController::walletCallback');
$routes->post('callback/phonepe', 'PaymentController::phonepeCallback');
$routes->post('callback/upi', 'PaymentController::upiCallback');
$routes->post('callback/cosmo', 'PaymentController::cosmoCallback');
$routes->post('callback/receipt', 'PaymentController::receiptCallback');
$routes->post('callback/razorpay', 'PaymentController::razorpayCallback');

// Regular User Get & Post Routes
$routes->group('user', ['filter' => 'roleFilter'], function($routes) {
    $routes->get('logout', 'User\AuthController::logout');
    $routes->get('goToAdmin', 'User\AuthController::loginAsAdmin');
    $routes->match(['GET', 'POST'], 'dashboard', 'User\HomeController::dashboard');
    $routes->post('changeDashboard', 'User\HomeController::changeDashboard');
    $routes->get('getLast7DaysSalesData', 'User\HomeController::getLast7DaysSalesData');
    $routes->match(['GET', 'POST'], 'profile', 'User\HomeController::profile');
    $routes->post('changePassword', 'User\AuthController::changePassword');
    $routes->post('kyc', 'User\HomeController::updateKyc');
    $routes->post('withdraw', 'User\HomeController::withdraw');
    $routes->get('affiliate-links', 'User\HomeController::affiliateLink');
    $routes->get('my-team', 'User\HomeController::team');
    $routes->get('referrals', 'User\HomeController::referrals');
    $routes->get('payouts', 'User\HomeController::payouts');
    $routes->get('wallet-history', 'User\HomeController::walletHistory');
    $routes->get('trainings', 'User\HomeController::trainings');
    $routes->get('webinars', 'User\HomeController::webinars');
    $routes->get('offers', 'User\HomeController::offers');
    $routes->get('community', 'User\HomeController::community');
    $routes->get('courses', 'User\HomeController::courses');
    $routes->get('course-view', 'User\HomeController::courseView');
    $routes->post('mark-course-complete', 'User\HomeController::markCourseComplete');
    $routes->get('certificates', 'User\HomeController::certificates');
    $routes->get('leaderboard', 'User\HomeController::leaderboard');
    $routes->get('upgrade', 'User\HomeController::upgrade');
    $routes->post('processUpgrade', 'OrderController::upgrade');
});

// Regular Admin Get & Post Routes
$routes->group(env('app.adminURL'), ['filter' => 'roleFilter', 'name' => 'admin'], function($routes) {
    
    $routes->post('core/upgrade-version', 'Core\UpdateController::getNewVersion');

    $routes->match(['GET', 'POST'], 'login', 'Admin\AuthController::login');
    $routes->match(['GET', 'POST'], 'forgot-password', 'Admin\AuthController::forgotPassword');
    $routes->match(['GET', 'POST'], 'reset-password/(:any)', 'Admin\AuthController::resetPassword/$1');
    $routes->get('logout', 'Admin\AuthController::logout');
    $routes->get('goToUser', 'Admin\AuthController::loginAsUser');
    $routes->get('goToSuperAdmin', 'Admin\AuthController::loginAsSuperAdmin');
    $routes->get('setting', 'Admin\HomeController::setting');
    $routes->post('setting', 'Admin\HomeController::updateSetting');
    $routes->get('profile', 'Admin\AuthController::profile');
    $routes->post('profile', 'Admin\AuthController::updateProfile');
    $routes->match(['GET', 'POST'], 'dashboard', 'Admin\HomeController::dashboard');
    $routes->get('users', 'Admin\HomeController::getUsers');
    $routes->match(['GET', 'POST'], 'user/(:any)', 'Admin\HomeController::getUser/$1');
    $routes->post('update-user-wallet/(:any)', 'Admin\HomeController::updateUserWallet/$1');
    $routes->post('update-user-kyc/(:any)', 'Admin\HomeController::updateUserKyc/$1');
    $routes->post('update-user-earning', 'Admin\HomeController::updateUserEarning');
    $routes->get('packages', 'Admin\HomeController::getPackages');
    $routes->post('new-package', 'Admin\HomeController::addPackage');
    $routes->match(['GET', 'POST'], 'package/(:any)', 'Admin\HomeController::getPackage/$1');
    $routes->get('upgrade-packages', 'Admin\HomeController::getUpgradePackages');
    $routes->post('new-upgrade-package', 'Admin\HomeController::addUpgradePackage');
    $routes->match(['GET', 'POST'], 'upgrade-package/(:any)', 'Admin\HomeController::getUpgradePackage/$1');
    $routes->get('referrals', 'Admin\HomeController::referrals');
    $routes->get('wallet-log', 'Admin\HomeController::walletLog');
    $routes->get('kyc-request', 'Admin\HomeController::kycRequest');
    $routes->post('kyc-update', 'Admin\HomeController::kycUpdate');
    $routes->get('payout-request', 'Admin\HomeController::payoutRequest');
    $routes->get('payouts', 'Admin\HomeController::payouts');
    $routes->post('update-payout/(:any)', 'Admin\HomeController::updatePayout/$1');
    $routes->get('orders', 'Admin\HomeController::orders');
    $routes->post('update-order/(:any)', 'Admin\HomeController::updateOrder/$1');
    $routes->get('courses', 'Admin\HomeController::getCourses');
    $routes->post('new-course', 'Admin\HomeController::addCourse');
    $routes->post('course-update/(:any)', 'Admin\HomeController::updateCourse/$1');
    $routes->get('course-links', 'Admin\HomeController::getCoursesLinks');
    $routes->post('new-course-link', 'Admin\HomeController::addCourseLink');
    $routes->post('course-link-update/(:any)', 'Admin\HomeController::updateCourseLink/$1');
    $routes->get('contact-form', 'Admin\HomeController::getContactForm');
    $routes->post('contact-form-update/(:any)', 'Admin\HomeController::updateContactForm/$1');
    $routes->get('testimonials', 'Admin\HomeController::getTestimonials');
    $routes->post('new-testimonial', 'Admin\HomeController::addTestimonial');
    $routes->post('testimonial-update/(:any)', 'Admin\HomeController::updateTestimonial/$1');
    $routes->get('banners', 'Admin\HomeController::getBanners');
    $routes->post('new-banner', 'Admin\HomeController::addBanner');
    $routes->post('banner-update/(:any)', 'Admin\HomeController::updateBanner/$1');
    $routes->get('webinars', 'Admin\HomeController::getWebinars');
    $routes->post('new-webinar', 'Admin\HomeController::addWebinar');
    $routes->post('webinar-update/(:any)', 'Admin\HomeController::updateWebinar/$1');
    $routes->get('offers', 'Admin\HomeController::getOffers');
    $routes->post('new-offer', 'Admin\HomeController::addOffer');
    $routes->post('offer-update/(:any)', 'Admin\HomeController::updateOffer/$1');
    $routes->get('trainings', 'Admin\HomeController::getTrainings');
    $routes->post('new-training', 'Admin\HomeController::addTraining');
    $routes->post('training-update/(:any)', 'Admin\HomeController::updateTraining/$1');
    $routes->get('legal-certificates', 'Admin\HomeController::getLegalCertificates');
    $routes->post('new-legal-certificate', 'Admin\HomeController::addLegalCertificate');
    $routes->post('legal-certificate-update/(:any)', 'Admin\HomeController::updateLegalCertificate/$1');
    $routes->get('instructors', 'Admin\HomeController::getInstructors');
    $routes->post('new-instructor', 'Admin\HomeController::addInstructor');
    $routes->post('instructor-update/(:any)', 'Admin\HomeController::updateInstructor/$1');
    $routes->get('community-links', 'Admin\HomeController::getCommunityLinks');
    $routes->post('new-community-link', 'Admin\HomeController::addCommunityLink');
    $routes->post('community-link-update/(:any)', 'Admin\HomeController::updateCommunityLink/$1');
    $routes->get('auto-upgrade', 'Admin\HomeController::getAutoUpgrade');
    $routes->post('new-auto-upgrade', 'Admin\HomeController::addAutoUpgrade');
    $routes->post('auto-upgrade-update/(:any)', 'Admin\HomeController::updateAutoUpgrade/$1');
    $routes->get('cosmo-link', 'Admin\HomeController::getCosmoLink');
    $routes->post('new-cosmo-link', 'Admin\HomeController::cosmoLinkAdd');
    $routes->post('cosmo-link-update/(:any)', 'Admin\HomeController::cosmoLinkUpdate/$1');
    $routes->get('vip-members', 'Admin\HomeController::getVipMembers');
    $routes->post('new-vip-member', 'Admin\HomeController::addVipMember');
    $routes->post('vip-member-update/(:any)', 'Admin\HomeController::updateVipMember/$1');
});


// Super Admin Get Routes
$routes->group(env('app.superAdminURL'), ['filter' => 'roleFilter'], function($routes) {
    // Super Admin Auth Routes
    $routes->match(['GET', 'POST'], 'login', 'SuperAdmin\AuthController::login');
    $routes->match(['GET', 'POST'], 'forgot-password', 'SuperAdmin\AuthController::forgotPassword');
    $routes->match(['GET', 'POST'], 'reset-password/(:any)', 'SuperAdmin\AuthController::resetPassword/$1');
    
    // Super Admin Dashboard Routes
    $routes->get('logout', 'SuperAdmin\AuthController::logout');
    $routes->match(['GET', 'POST'], 'dashboard', 'SuperAdmin\HomeController::dashboard');
    $routes->match(['GET', 'POST'], 'profile', 'SuperAdmin\AuthController::profile');

    // Super Admin Other Routes
    $routes->post('load-css', 'SuperAdmin\CodeEditor::loadCss');
    $routes->post('load-js', 'SuperAdmin\CodeEditor::loadJs');
    $routes->post('save-code', 'SuperAdmin\CodeEditor::saveCode');
    $routes->post('save-css', 'SuperAdmin\CodeEditor::saveCss');
    $routes->post('save-js', 'SuperAdmin\CodeEditor::saveJs');
    $routes->get('code-editor/(:any)', 'SuperAdmin\CodeEditor::codeEditor/$1');

    $routes->get('customizer', 'SuperAdmin\HomeController::customizer');
    $routes->post('customizer', 'SuperAdmin\HomeController::updateTheme');
    $routes->post('update-theme-colours', 'SuperAdmin\Customizer::updateThemeColours');
    $routes->get('agency', 'SuperAdmin\HomeController::agencyArea');
    $routes->post('agency-token-update', 'SuperAdmin\HomeController::agencyTokenUpdate');
    $routes->get('wp-migration', 'SuperAdmin\HomeController::wpMigration');
    $routes->post('wp-migration/import', 'Core\WpMigration::wpMigration');
    $routes->get('download-sample-csv', 'Core\WpMigration::downloadSampleCsv');
    $routes->get('developer', 'SuperAdmin\HomeController::developer');
    $routes->get('setting', 'SuperAdmin\HomeController::gatewaySetting');
    $routes->post('gateway-update', 'SuperAdmin\HomeController::gatewayUpdate');
    $routes->post('branding-update', 'SuperAdmin\HomeController::updateLogo');
    $routes->post('nameUrl-update', 'SuperAdmin\HomeController::updateNameUrl');
    $routes->post('email-update', 'SuperAdmin\HomeController::updateEmailCredentails');

    $routes->match(['GET', 'POST'], 'policies', 'SuperAdmin\HomeController::policies');
    $routes->get('faq', 'SuperAdmin\HomeController::faq');
    $routes->post('add-faq', 'SuperAdmin\HomeController::addFaq');
    $routes->get('faq-delete', 'SuperAdmin\HomeController::faqDelete');
    $routes->get('admins', 'SuperAdmin\HomeController::admins');
    $routes->post('add-admin', 'SuperAdmin\HomeController::addAdmin');
    $routes->get('admin-ban', 'SuperAdmin\AuthController::adminBan');
    $routes->get('admin-unban', 'SuperAdmin\AuthController::adminUnban');
    $routes->get('admin-delete', 'SuperAdmin\AuthController::adminDelete');
    $routes->get('goToAdmin', 'SuperAdmin\AuthController::loginAsAdmin');


    $routes->get('reset-license', 'SuperAdmin\HomeController::licenseRefresh');
    $routes->get('reissue-license', 'SuperAdmin\HomeController::reissueLicense');
    $routes->post('core/upgrade-version', 'Core\UpdateController::getNewVersion');
});
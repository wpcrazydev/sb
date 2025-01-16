<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <form action="<?= base_url(env('app.adminURL') . '/setting') ?>" method="POST">
        <div class="pagenav">
            <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
            <button class="btn btn-outline-primary" type="submit">Save Changes</button>
        </div>
        <hr />
            <div class="row">
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card rounded-4 w-100">
                        <div class="card-body p-0">
                            <div class="p-3 rounded">
                                <div class="row g-3">
                                    <?= csrf_field() ?>
                                    <h5 class="text-decoration-underline">General Settings</h5>
                                    <div class="col-md-12 col-12">
                                        <label class="form-label">Dashboard Guide Video</label>
                                        <input type="text" name="dashboard_guide" class="form-control" value="<?= $settingData['dashboard_guide'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Maintenance Mode</label>
                                        <select class="form-select" aria-label="Default select example" name="maintenance_mode" required>
                                            <option value="active" <?= $settingData['maintenance_mode'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['maintenance_mode'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Maintenance Message</label>
                                        <textarea name="maintenance_message" class="form-control" rows="1"><?= $settingData['maintenance_message'] ?? '' ?></textarea>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Payout Status</label>
                                        <select class="form-select" aria-label="Default select example" name="payout_status" required>
                                            <option value="active" <?= $settingData['payout_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['payout_status'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Payout Status Message</label>
                                        <textarea name="payout_status_message" class="form-control" rows="1"><?= $settingData['payout_status_message'] ?? '' ?></textarea>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Minimum Payout</label>
                                        <input type="number" name="min_payout" class="form-control" value="<?= $settingData['min_payout'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Direct Kyc</label>
                                        <select class="form-select" aria-label="Default select example" name="direct_kyc" required>
                                            <option value="active" <?= $settingData['direct_kyc'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['direct_kyc'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Ref Code Compulsory</label>
                                        <select class="form-select" aria-label="Default select example" name="referal_code_compulsory" required>
                                            <option value="active" <?= $settingData['referal_code_compulsory'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['referal_code_compulsory'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Payout Mail On Wallet <?= $addonStatus['wallet_gateway'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                        <select class="form-select <?= $addonStatus['wallet_gateway'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="payout_mail_on_wallet" required>
                                            <option value="active" <?= $settingData['payout_mail_on_wallet'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['payout_mail_on_wallet'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Home Banner</label>
                                        <select class="form-select" aria-label="Default select example" name="home_banner" required>
                                            <option value="active" <?= $settingData['home_banner'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['home_banner'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>


                                    <h5 class="mt-5 text-decoration-underline">Leaderboard Settings</h5>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Today</label>
                                        <select class="form-select" aria-label="Default select example" name="today_lb" required>
                                            <option value="active" <?= $settingData['today_lb'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['today_lb'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">7 Days</label>
                                        <select class="form-select" aria-label="Default select example" name="seven_days_lb" required>
                                            <option value="active" <?= $settingData['seven_days_lb'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['seven_days_lb'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">30 Days</label>
                                        <select class="form-select" aria-label="Default select example" name="thirty_days_lb" required>
                                            <option value="active" <?= $settingData['thirty_days_lb'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['thirty_days_lb'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">All Time</label>
                                        <select class="form-select" aria-label="Default select example" name="all_time_lb" required>
                                            <option value="active" <?= $settingData['all_time_lb'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['all_time_lb'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>


                                    <h5 class="mt-5 text-decoration-underline">Offers Settings</h5>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Auto Upgrade <?= $addonStatus['auto_upgrade'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                        <select class="form-select <?= $addonStatus['auto_upgrade'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="auto_upgrade" required>
                                            <option value="active" <?= $settingData['auto_upgrade'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['auto_upgrade'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Referral Offer <?= $addonStatus['referral_offer'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                        <select class="form-select <?= $addonStatus['referral_offer'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="referral_offer" required>
                                            <option value="active" <?= $settingData['referral_offer'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['referral_offer'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Sales Offer <?= $addonStatus['sales_offer'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                        <select class="form-select <?= $addonStatus['sales_offer'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="sales_offer" required>
                                            <option value="active" <?= $settingData['sales_offer'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['sales_offer'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <!-- Add more input fields here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card rounded-4 w-100">
                        <div class="card-body p-0">
                            <div class="p-3 rounded">
                                <div class="row g-3">
                                <h5 class="text-decoration-underline">Gateway Settings</h5>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">PhonePe</label>
                                        <select class="form-select" aria-label="Default select example" name="phonepe" required>
                                            <option value="active" <?= $settingData['phonepe'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['phonepe'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Razorpay</label>
                                        <select class="form-select" aria-label="Default select example" name="razorpay" required>
                                            <option value="active" <?= $settingData['razorpay'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['razorpay'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Cosmofeed <?= $addonStatus['cosmofeed_gateway'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                        <select class="form-select <?= $addonStatus['cosmofeed_gateway'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="cosmofeed" required>
                                            <option value="active" <?= $settingData['cosmofeed'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['cosmofeed'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Wallet <?= $addonStatus['wallet_gateway'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                        <select class="form-select <?= $addonStatus['wallet_gateway'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="wallet" required>
                                            <option value="active" <?= $settingData['wallet'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['wallet'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Upi Qr</label>
                                        <select class="form-select" aria-label="Default select example" name="upi_qr" required>
                                            <option value="active" <?= $settingData['upi_qr'] == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $settingData['upi_qr'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Upi Id</label>
                                        <input type="text" name="upi_id" class="form-control" value="<?= $settingData['upi_id'] ?? '' ?>">
                                    </div>


                                    <h5 class="mt-5 text-decoration-underline">Social Media</h5>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" name="facebook" class="form-control" value="<?= $settingData['facebook'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" name="instagram" class="form-control" value="<?= $settingData['instagram'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Youtube</label>
                                        <input type="text" name="youtube" class="form-control" value="<?= $settingData['youtube'] ?? '' ?>">
                                    </div>

                                    <h5 class="mt-5 text-decoration-underline">Contact Details</h5>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" value="<?= $settingData['phone'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="email" class="form-control" value="<?= $settingData['email'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?= $settingData['address'] ?? '' ?>">
                                    </div>
                                    <!-- Add more input fields here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    <!--end row-->

    <!-- here is second row -->
</main>
<?= $this->include('admin/footer') ?>
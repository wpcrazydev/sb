<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<style>
    #avatarModalImage{
        width: 100%;
        border-radius: 10px;
    }
</style>
<main class="page-content">
    <div class="row align-items-start">
        <div class="col-12 col-lg-12 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">User Details <a href="<?= base_url(env('app.adminURL') . '/goToUser?uid=' . $user['id']) ?>" class="btn btn-success"><i class="bi bi-box-arrow-in-right" style="margin-left: 0px"></i></a></h6>
                        <hr>
                        <form action="<?= base_url(env('app.adminURL') . '/user/' . $user['id']) ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-4 col-12">
                                <label for="image" class="form-label">Profile Picture</label>
                                <input type="file" name="image" class="form-control mb-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#avatarModal" data-uname="<?= $user['name'] ?>" data="<?= base_url('public/uploads/profiles/' . $user['image']) ?>"><i class="bi bi-eye-fill"></i> View profile picture</a>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?= $user['name'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="<?= $user['phone'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Email ID</label>
                                <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Referral Code</label>
                                <input type="text" name="ref_code" value="<?= $user['ref_code'] ?>" class="form-control" disabled>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Sponsor - <span style="font-size: 13px;" class="text-primary"><?= $sponsorData['name'] ?> <i class="bi bi-check-circle"></i></span></label>
                                <input type="text" name="ref_by_code" value="<?= $user['ref_by_code'] ?>" class="form-control">
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Package</label>
                                <select class="form-select" aria-label="Default select example" name="plan_id" required>
                                    <option value="0">Select Course</option>
                                    <?php foreach ($packages as $pkg): ?>
                                    <option value="<?= $pkg['id']; ?>" <?= $user['plan_id'] == $pkg['id'] ? 'selected' : '' ?>><?= $pkg['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Package Status</label>
                                <select class="form-select" aria-label="Default select example" name="plan_status" required>
                                    <option value="active" <?= $user['plan_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['plan_status'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Leaderboard</label>
                                <select class="form-select" aria-label="Default select example" name="lb_status" required>
                                    <option value="active" <?= $user['lb_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['lb_status'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Dashboard</label>
                                <select class="form-select" aria-label="Default select example" name="dashboard" required>
                                    <option value="new" <?= $user['dashboard'] == 'new' ? 'selected' : '' ?>>New</option>
                                    <option value="old" <?= $user['dashboard'] == 'old' ? 'selected' : '' ?>>Old</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Lead Access <?= $addonStatus['lead_management'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                <select class="form-select <?= $addonStatus['lead_management'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="lead_access" required>
                                    <option value="active" <?= $user['lead_access'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['lead_access'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Landing Page <?= $addonStatus['landing_page'] != 'Active' ? $addonStatus['badge'] : '' ?></label>
                                <select class="form-select <?= $addonStatus['landing_page'] != 'Active' ? 'biz-disabled' : '' ?>" aria-label="Default select example" name="landing_page" required>
                                    <option value="active" <?= $user['landing_page'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['landing_page'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Referral Access</label>
                                <select class="form-select" aria-label="Default select example" name="referral_access" required>
                                    <option value="active" <?= $user['referral_access'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['referral_access'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">MLM Access</label>
                                <select class="form-select" aria-label="Default select example" name="mlm_access" required>
                                    <option value="active" <?= $user['mlm_access'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['mlm_access'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Withdrawal Access</label>
                                <select class="form-select" aria-label="Default select example" name="withdraw_access" required>
                                    <option value="active" <?= $user['withdraw_access'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['withdraw_access'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">User Status</label>
                                <select class="form-select" aria-label="Default select example" name="status" required>
                                    <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Instagram Link</label>
                                <input type="text" name="instagram" value="<?= $user['instagram'] ?>" class="form-control">
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Change Password</label>
                                <input type="text" name="password" value="" class="form-control">
                            </div>
                            <div class="col-md-1 col-12">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-12 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Kyc Details</h6>
                        <hr>
                        <form action="<?= base_url(env('app.adminURL') . '/update-user-kyc' . '/' . $user['id']) ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" value="<?= $kycData['bank_name'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Holder Name</label>
                                <input type="text" name="holder_name" value="<?= $kycData['holder_name'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Account Number</label>
                                <input type="number" name="account_number" value="<?= $kycData['account_number'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" value="<?= $kycData['ifsc_code'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">UPI Id</label>
                                <input type="text" name="upi_id" value="<?= $kycData['upi_id'] ?>" class="form-control">
                            </div>
                            <div class="col-md-4 col-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" name="status" required>
                                    <option disabled="" selected="">Select Status</option>
                                    <option value="approved" <?= $kycData['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="pending" <?= $kycData['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="rejected" <?= $kycData['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-1 col-12">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Wallet</h6>
                        <hr>
                        <div class="d-flex align-items-center" style="height: 100px;">
                            <div class="col-6">
                                <div class="border-end rounded-3" style="margin:10px; padding:15px;">
                                    <h5 class="text-center text-success">₹<?= $user['wallet'] ?>/-</h5>
                                    <p class="text-center mb-0">Balance</p>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="border-start rounded-3" style="margin:10px; padding:15px;">
                                    <h5 class="text-center text-danger">₹<?= $user['paid'] ?>/-</h5>
                                    <p class="text-center mb-0">Total Paid</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Manage Earning</h6>
                        <hr>
                        <form action="<?= base_url(env('app.adminURL') . '/update-user-earning') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <div class="col-md-6 col-12">
                                <label class="form-label">Refer Id</label>
                                <input type="text" name="ref_code" class="form-control" placeholder="Enter refer id" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Amount</label>
                                <input type="text" name="amount" class="form-control" placeholder="Enter amount" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Type</label>
                                <select class="form-select" aria-label="Default select example" name="type" required>
                                    <option disabled="" selected="">Select Type</option>
                                    <option value="credit">Credit</option>
                                    <option value="debit">Debit</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Active/Passive</label>
                                <select class="form-select" aria-label="Default select example" name="active_passive" required>
                                    <option disabled="" selected="">Select Status</option>
                                    <option value="direct">Active</option>
                                    <option value="mlm">Passive</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-12">
                                <label class="form-label">Method</label>
                                <select class="form-select" aria-label="Default select example" name="method" required>
                                    <option disabled="" selected="">Select Method</option>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Update Wallet">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card rounded-4">
                <!-- Tab Navigation -->
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-purchased-tab" data-bs-toggle="tab" data-bs-target="#nav-purchased-content" type="button" role="tab" aria-controls="nav-purchased-content" aria-selected="true">Purchased</button>
                        <button class="nav-link" id="nav-commission-tab" data-bs-toggle="tab" data-bs-target="#nav-commission-content" type="button" role="tab" aria-controls="nav-commission-content" aria-selected="false">Commission</button>
                        <button class="nav-link" id="nav-wallet-history-tab" data-bs-toggle="tab" data-bs-target="#nav-wallet-history-content" type="button" role="tab" aria-controls="nav-wallet-history-content" aria-selected="false">Wallet History</button>
                    </div>
                </nav>
                
                <!-- Tab Content -->
                <div class="tab-content" id="nav-tabContent">
                    <!-- Purchase History Tab -->
                    <div class="tab-pane fade show active" id="nav-purchased-content" role="tabpanel" aria-labelledby="nav-purchased-tab">
                        <div class="card-body">
                            <h6 class="mb-0 text-uppercase">Purchase History</h6>
                            <hr>
                            <?= $this->include('admin/templates/purchase_history') ?>
                        </div>
                    </div>
                    
                    <!-- Commission History Tab -->
                    <div class="tab-pane fade" id="nav-commission-content" role="tabpanel" aria-labelledby="nav-commission-tab">
                        <div class="card-body">
                            <h6 class="mb-0 text-uppercase">Commission History</h6>
                            <hr>
                            <?= $this->include('admin/templates/commission_history') ?>
                        </div>
                    </div>
                    
                    <!-- Wallet History Tab -->
                    <div class="tab-pane fade" id="nav-wallet-history-content" role="tabpanel" aria-labelledby="nav-wallet-history-tab">
                        <div class="card-body">
                            <h6 class="mb-0 text-uppercase">Wallet History</h6>
                            <hr>
                            <?= $this->include('admin/templates/wallet_history') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avatarModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" alt="" id="avatarModalImage">
      </div>
    </div>
  </div>
</div>

<script>
    $(document).on('click', '[data-bs-target="#avatarModal"]', function() {
        let uname = $(this).attr('data-uname');
        let image = $(this).attr('data');
        $('#avatarModalLabel').text(uname + ' Profile Picture');
        $('#avatarModalImage').attr('src', image);
    });


// Remove the existing tab-related JavaScript code
$(document).on('click', '[data-bs-target="#avatarModal"]', function() {
    let uname = $(this).attr('data-uname');
    let image = $(this).attr('data');
    $('#avatarModalLabel').text(uname + ' Profile Picture');
    $('#avatarModalImage').attr('src', image);
});
</script>
<?= $this->include('admin/footer') ?>
<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <div class="col-xxl-4 col-xl-6">
                    <div class="card">
                        <div class="card-body p-0">
                            <div style="background: #0b083d; border-radius: 15px 15px 0 0; padding: 20px 20px 1px 20px;">
                                <div class="mb-3 text-center">
                                    <div class="wd-150 ht-150 mx-auto mb-3 position-relative">
                                        <div class="avatar-image wd-150 ht-150 border border-5 border-gray-3">
                                            <img src="<?= base_url('public/uploads/profiles/' . $userData['image']) ?>" alt="" class="img-fluid">
                                        </div>
                                        <div class="wd-10 ht-10 text-success rounded-circle position-absolute translate-middle"
                                            style="top: 76%; right: 10px">
                                            <i class="bi bi-patch-check-fill"></i>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <a href="javascript:void(0);" class="fs-14 fw-bold d-block text-white"><?= $userData['name'] ?></a>
                                        <a href="javascript:void(0);"
                                            class="fs-12 fw-normal text-muted d-block text-white"><?= $userData['email'] ?></a>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 20px 20px 0 20px;">
                                <ul class="list-unstyled mb-4">
                                    <li class="hstack justify-content-between mb-3">
                                        <span class="text-muted fw-medium hstack gap-3"><i
                                                class="feather-check-circle"></i>SB
                                            Code</span>
                                        <a href="javascript:void(0);" class="float-end"
                                            id="copyRefCode"><?= $userData['ref_code'] ?>&nbsp;&nbsp;<i class="feather-copy"></i></a>
                                    </li>
                                    <li class="hstack justify-content-between mb-3">
                                        <span class="text-muted fw-medium hstack gap-3"><i
                                                class="feather-bookmark"></i>Package</span>
                                        <a href="javascript:void(0);" class="float-end"><?= $userPkgInfo['name'] ?? env('app.name') ?></a>
                                    </li>
                                    <li class="hstack justify-content-between mb-3">
                                        <span class="text-muted fw-medium hstack gap-3"><i class="feather-file-text"></i>Kyc
                                            Status</span>
                                        <a href="javascript:void(0);" class="float-end"><?= $kycStatus ?></a>
                                    </li>
                                    <li class="hstack justify-content-between mb-0">
                                        <span class="text-muted fw-medium hstack gap-3"><i
                                                class="feather-user"></i>Sponsor</span>
                                        <a href="javascript:void(0);" class="float-end"><?= $sponsorName ?? 'N/A' ?></a>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div style="padding: 15px 20px 20px 20px;">
                            <div class="fs-12 fw-normal text-muted text-center d-flex flex-wrap gap-3">
                                <div class="flex-fill py-3 px-4 rounded-4 border border-dashed border-gray-5">
                                    <h6 class="fs-15 fw-bolder"><?= $userData['wallet'] ?></h6>
                                    <p class="fs-12 text-muted mb-0">Wallet Balance</p>
                                </div>
                                <div class="flex-fill py-3 px-4 rounded-4 border border-dashed border-gray-5">
                                    <h6 class="fs-15 fw-bolder"><?= $pendingWithdrawal ?></h6>
                                    <p class="fs-12 text-muted mb-0">Pending Withdrawal</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2 text-center pt-4">
                                <a href="javascript:void(0);" class="w-50 btn ls-btn" data-bs-toggle="modal"
                                    data-bs-target="#withdrawalModel">
                                    <span>Withdraw Amount</span>
                                </a>
                                <a href="<?= base_url('user/payouts') ?>" class="w-50 btn ls-btn">
                                    <span>Payout History</span>
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-8 col-xl-6">
                    <div class="card border-top-0">
                        <div class="card-header p-0">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs flex-wrap w-100 text-center customers-nav-tabs" id="myTab"
                                role="tablist">
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link tab active show" data-bs-toggle="tab"
                                        data-bs-target="#overviewTab" role="tab" aria-selected="true">Profile
                                        Details</a>
                                </li>
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link tab" data-bs-toggle="tab"
                                        data-bs-target="#kycTab" role="tab" aria-selected="false">Kyc Details</a>
                                </li>
                                <li class="nav-item flex-fill border-top" role="presentation">
                                    <a href="javascript:void(0);" class="nav-link tab" data-bs-toggle="tab"
                                        data-bs-target="#changePasswordTab" role="tab" aria-selected="false">Change
                                        Password</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade p-4 active show" id="overviewTab" role="tabpanel">
                                <form action="<?= base_url('user/profile') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                                    <?= csrf_field() ?>
                                    <div class="col-12">
                                        <label for="image" class="form-label">Profile Picture</label>
                                        <input type="file" name="image" class="form-control" aria-describedby="avatarhelp">
                                        <small id="avatarhelp" class="form-text text-muted text-info">Upload profile in
                                            size (1:1) for proper fit.</small>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" value="<?= $userData['name'] ?>" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" value="<?= $userData['phone'] ?>" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Email ID</label>
                                        <input type="email" name="email" value="<?= $userData['email'] ?>" class="form-control"
                                            disabled>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-grid">
                                            <input type="submit" class="btn ls-btn" value="Save Changes">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade p-4" id="kycTab" role="tabpanel">
                                <?php if ($kycStatus == 'approved') { ?>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="feather-check-circle mb-3" style="font-size: 90px; color: #06b006;"></i>
                                    </div>
                                    <h2 class="text-center">Congrats, Kyc Verified!</h2>
                                    <p class="text-center" style="font-size:13px;">Hi <?= $userData['name'] ?> your kyc status is
                                        approved. So now you can
                                        request for withdrawal
                                        anytime also if you want to change your bank details please click the button below.
                                    </p>
                                <?php } else if ($kycStatus == 'pending') { ?>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="feather-clock mb-3" style="font-size: 90px; color: #ff9800;"></i>
                                    </div>
                                    <h2 class="text-center">Kyc Submitted!</h2>
                                    <p class="text-center" style="font-size:13px;">Hi <?= $userData['name'] ?> your kyc status is
                                        pending. Please wait for admin approval.
                                    </p>
                                <?php } else if ($kycStatus == 'rejected') { ?>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="feather-x-circle mb-3" style="font-size: 90px; color: #f44336;"></i>
                                    </div>
                                    <h2 class="text-center">Kyc Rejected!</h2>
                                    <p class="text-center" style="font-size:13px;">Hi <?= $userData['name'] ?> your kyc status is
                                        rejected. Please update your kyc details and submit again.
                                    </p>
                                <?php } ?>
                                <?php if ($kycStatus != 'approved' && $kycStatus != 'pending') { ?>
                                    <form action="<?= base_url('user/kyc') ?>" method="POST" class="row g-3">
                                        <?= csrf_field() ?>
                                        <div class="col-12">
                                            <label class="form-label">Bank Name</label>
                                            <input type="text" name="bank_name" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Holder Name</label>
                                            <input type="text" name="holder_name" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Ac. Number</label>
                                            <input type="number" name="account_number" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">IFSC Code</label>
                                            <input type="text" name="ifsc_code" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">UPI Id</label>
                                            <input type="text" name="upi_id" class="form-control" placeholder="(optional..)">
                                        </div>
                                        <div class="col-2">
                                            <div class="d-grid">
                                                <input type="submit" class="btn ls-btn" value="Save Changes">
                                            </div>
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade p-4" id="changePasswordTab" role="tabpanel">
                                <form action="<?= base_url('user/changePassword') ?>" method="POST" class="row g-3">
                                    <?= csrf_field() ?>
                                    <div class="col-12">
                                        <label class="form-label">Current Password</label>
                                        <input type="text" name="current_password" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">New Password</label>
                                        <input type="text" name="new_password" class="form-control" required>
                                    </div>
                                    <div class="col-3">
                                        <div class="d-grid">
                                            <input type="submit" class="btn ls-btn" value="Change Password">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="withdrawalModel" tabindex="-1" aria-labelledby="withdrawalModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="withdrawalModelLabel" style="font-size:16px;">Request For Withdrawal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Minimum withdrawal: <?= $minPayout ?></p>
                <form action="<?= base_url('user/withdraw') ?>" method="POST" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount" required>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn ls-btn w-100" value="Submit Request">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('copyRefCode').addEventListener('click', function () {
        var tempInput = document.createElement('input');
        tempInput.value = this.textContent;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        swal.fire({
            icon: 'success',
            title: 'Copied!',
            text: 'Referral code copied to clipboard.',
            showConfirmButton: false,
            timer: 1500
        });
    });

</script>
<?= $this->include('user/footer') ?>
<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase">Dashboard</h6>
        <button class="btn btn-outline-dark">v <?= env('app.current_version') ?></button>
    </div>
    <hr />
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Orders</p>
                            <h4 class="mb-0 text-dark"><?= $countOrders ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Users</p>
                            <h4 class="mb-0 text-dark"><?= $countUsers ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Commissions Paid</p>
                            <h4 class="mb-0 text-dark">₹<?= $commissionsPaid ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Revenue</p>
                            <h4 class="mb-0 text-dark">₹<?= $totalRevenue ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Withdrawal Request</p>
                            <h4 class="mb-0 text-dark"><?= $countPendingPayout ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Pending Payout</p>
                            <h4 class="mb-0 text-dark">₹<?= $sumPendingPayout ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Total Paid</p>
                            <h4 class="mb-0 text-dark">₹<?= $sumPaidPayout ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-0 border-start border-tiffany border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <p class="mb-1">Unpaid Balance</p>
                            <h4 class="mb-0 text-dark">₹<?= $unpaidBalance ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="newVersionModal" tabindex="-1" aria-labelledby="newVersionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center">
            <i class="bi bi-check-circle" style="font-size: 90px; color: #06b006;"></i>
        </div>
        <h5 class="text-center">Update Available - v<?= $newVersion['new_version'] ?></h5>
        <p class="text-center mb-0">We added some new features and security patches to the website. Please click below to explore before update.</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="<?= base_url(env('app.adminURL') . 'core/new-update') ?>" class="btn btn-primary">Explore</a>
      </div>
    </div>
  </div>
</div>
<script>
    <?php if ($isNewVersion): ?>
        window.onload = function() {
            $('#newVersionModal').modal('show');
        }
    <?php endif; ?>
</script>
<?= $this->include('admin/footer') ?>
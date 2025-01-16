<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <!-- Search form -->
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by User ID or Amount" value="<?= esc(request()->getGet('search')) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $payout): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($payout['created_at'])) ?></td>
                            <td><?= esc($users[$payout['user_id']]['name']) ?> <strong>=</strong> <?= esc($users[$payout['user_id']]['ref_code']) ?></td>
                            <td><?= esc($payout['amount']) ?></td>
                            <td>
                                <span class="badge bg-<?= $payout['status'] == 'paid' ? 'success' : 'danger' ?>">
                                    <?= esc(ucfirst($payout['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="<?= base_url(env('app.adminURL') . '/update-payout/' . esc($payout['id'])) ?>" method="POST">
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle" style="margin-left: 0px"></i></button>
                                    </form>
                                    <form action="<?= base_url(env('app.adminURL') . '/update-payout/' . esc($payout['id'])) ?>" method="POST">
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle" style="margin-left: 0px"></i></button>
                                    </form>
                                    <button type="button" class="btn btn-primary view-payout-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#payoutViewModal" 
                                            data-payout-id="<?= esc($payout['id']) ?>"
                                            data-created-at="<?= date('Y-m-d', strtotime($payout['created_at'])) ?>"
                                            data-user-name="<?= esc($users[$payout['user_id']]['name']) ?>"
                                            data-user-phone="<?= isset($users[$payout['user_id']]['phone']) ? $users[$payout['user_id']]['phone'] : '' ?>"
                                            data-user-email="<?= isset($users[$payout['user_id']]['email']) ? $users[$payout['user_id']]['email'] : '' ?>"
                                            data-amount="<?= esc($payout['amount']) ?>"
                                            data-bank-name="<?= isset($kycs[$payout['user_id']]['bank_name']) ? $kycs[$payout['user_id']]['bank_name'] : '' ?>"
                                            data-holder-name="<?= isset($kycs[$payout['user_id']]['holder_name']) ? $kycs[$payout['user_id']]['holder_name'] : '' ?>"
                                            data-account-number="<?= isset($kycs[$payout['user_id']]['account_number']) ? $kycs[$payout['user_id']]['account_number'] : '' ?>"
                                            data-ifsc-code="<?= isset($kycs[$payout['user_id']]['ifsc_code']) ? $kycs[$payout['user_id']]['ifsc_code'] : '' ?>"
                                            data-upi-id="<?= isset($kycs[$payout['user_id']]['upi_id']) ? $kycs[$payout['user_id']]['upi_id'] : '' ?>"
                                            data-kyc-status="<?= isset($kycs[$payout['user_id']]['status']) ? $kycs[$payout['user_id']]['status'] : '' ?>"
                                            data-status="<?= esc(ucfirst($payout['status'])) ?>">
                                        <i class="bi bi-eye" style="margin-left: 0px"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination links -->
                <div class="mt-3">
                    <?= $pager ?>
                </div>
                <?php } else { ?>
                    <p>No payout request found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->

<!-- Modal -->
<div class="modal fade" id="payoutViewModal" tabindex="-1" aria-labelledby="payoutViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="payoutViewModalLabel">Payout Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="payoutDetails"></div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const payoutDetailsContainer = document.getElementById('payoutDetails');
    document.querySelectorAll('.view-payout-btn').forEach(button => {
        button.addEventListener('click', function() {
            const payoutId = this.getAttribute('data-payout-id');
            const userName = this.getAttribute('data-user-name');
            const userPhone = this.getAttribute('data-user-phone');
            const userEmail = this.getAttribute('data-user-email');
            const amount = this.getAttribute('data-amount');
            const bankName = this.getAttribute('data-bank-name');
            const holderName = this.getAttribute('data-holder-name');
            const accountNumber = this.getAttribute('data-account-number');
            const ifscCode = this.getAttribute('data-ifsc-code');
            const upiId = this.getAttribute('data-upi-id');
            const kycStatus = this.getAttribute('data-kyc-status');
            const status = this.getAttribute('data-status');
            const createdAt = this.getAttribute('data-created-at');
            payoutDetailsContainer.innerHTML = `
                <p><strong>Date:</strong> ${createdAt}</p>
                <p><strong>User:</strong> ${userName}</p>
                <p><strong>Phone:</strong> ${userPhone}</p>
                <p><strong>Email:</strong> ${userEmail}</p>
                <p><strong>Amount:</strong> ${amount}</p>
                <p><strong>Bank Name:</strong> ${bankName}</p>
                <p><strong>Holder Name:</strong> ${holderName}</p>
                <p><strong>Account Number:</strong> ${accountNumber}</p>
                <p><strong>IFSC Code:</strong> ${ifscCode}</p>
                <p><strong>UPI ID:</strong> ${upiId}</p>
                <p><strong>Kyc Status:</strong> ${kycStatus}</p>
                <p><strong>Payout Status:</strong> ${status}</p>
                <div class="d-flex gap-2">
                    <form action="<?= base_url(env('app.adminURL'))?>/update-payout/${payoutId}" method="POST">
                    <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle" style="margin-left: 0px"></i> Approve Payout</button>
                    </form>
                </div>
            `;
        });
    });
});
</script>
<?= $this->include('admin/footer') ?>
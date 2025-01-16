<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <?php if ($status == 'paid') : ?>
            <a href="<?= base_url(env('app.adminURL') . '/orders?status=pending') ?>" class="btn btn-outline-primary">Pending Orders</a>
        <?php endif; ?>
        <?php if ($status == 'pending') : ?>
            <a href="<?= base_url(env('app.adminURL') . '/orders?status=paid') ?>" class="btn btn-outline-primary">Paid Orders</a>
        <?php endif; ?>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="hidden" name="status" value="<?= $status ?>">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by txn id or gateway" value="<?= esc(request()->getGet('search')) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                    <?php if ($status == 'paid') : ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Txn ID</th>
                                    <th>Ref By</th>
                                    <th>User</th>
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Gateway</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <td><?= date('d-M-Y - h:i', strtotime($order['created_at'])) ?></td>
                                    <td><?= date('d-M-Y - h:i', strtotime($order['updated_at'])) ?></td>
                                    <td><?= esc($order['txn_id']) ?></td>
                                    <td><?= esc(get_dynamic_data('users', 'ref_code', ['id' => $order['parent_id']])) . ' - ' . esc(get_dynamic_data('users', 'name', ['id' => $order['parent_id']])) ?></td>
                                    <td><?= esc(get_dynamic_data('users', 'ref_code', ['id' => $order['user_id']])) . ' - ' . esc(get_dynamic_data('users', 'name', ['id' => $order['user_id']])) ?></td>
                                    <td><?= esc(get_dynamic_data('packages', 'name', ['id' => $order['package_id']])) ?></td>
                                    <td><?= esc($order['amount']) ?></td>
                                    <td><?= esc(ucfirst($order['gateway'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $order['status'] == 'paid' ? 'success' : 'danger' ?>">
                                            <?= esc(ucfirst($order['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if ($order['status'] == 'paid') { ?>
                                            <a href="<?= base_url(env('app.adminURL') . '/user/' . esc($order['user_id'])) ?>" class="btn btn-primary"><i class="bi bi-person-circle" style="margin-left: 0px"></i></a>
                                            <a href="<?= base_url(env('app.adminURL') . '/referrals?search=' . esc($order['txn_id'])) ?>" class="btn btn-outline-success"><i class="bi bi-currency-dollar" style="margin-left: 0px"></i></a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <?php if ($status == 'pending') : ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Created Date</th>
                                    <th>Txn ID</th>
                                    <th>UTR No</th>
                                    <th>Ref By</th>
                                    <th>User</th>
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Gateway</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <td><?= date('d-M-Y - h:i', strtotime($order['created_at'])) ?></td>
                                    <td><?= esc($order['txn_id']) ?></td>
                                    <td><?= esc($order['payment_ref']) ?></td>
                                    <td><?= esc($order['decoded_token']['ref_by_code']) . ' - ' . esc(get_dynamic_data('users', 'name', ['ref_code' => $order['decoded_token']['ref_by_code']])) ?></td>
                                    <td><?= esc($order['decoded_token']['name']) ?></td>
                                    <td><?= esc(get_dynamic_data('packages', 'name', ['id' => $order['package_id']])) ?></td>
                                    <td><?= esc($order['amount']) ?></td>
                                    <td><?= esc(ucfirst($order['gateway'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $order['status'] == 'paid' ? 'success' : 'danger' ?>">
                                            <?= esc(ucfirst($order['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if ($order['status'] == 'pending') { ?>
                                                <form action="<?= base_url(env('app.adminURL') . '/update-order/' . esc($order['txn_id'])) ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle" style="margin-left: 0px"></i></button>
                                                </form>
                                                <form action="<?= base_url(env('app.adminURL') . '/update-order/' . esc($order['txn_id'])) ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="status" value="create_user_manual">
                                                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check-circle" style="margin-left: 0px"></i> Manual</button>
                                                </form>
                                                <button type="button" class="btn btn-primary view-order-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#orderViewModal" 
                                                        data-order-id="<?= esc($order['id']) ?>"
                                                        data-created-at="<?= date('Y-m-d', strtotime($order['created_at'])) ?>"
                                                        data-txn-id="<?= esc($order['txn_id']) ?>"
                                                        data-user-name="<?= esc($order['decoded_token']['name']) ?>"
                                                        data-user-phone="<?= esc($order['decoded_token']['phone']) ?>"
                                                        data-user-email="<?= esc($order['decoded_token']['email']) ?>"
                                                        data-package-name="<?= esc(get_dynamic_data('packages', 'name', ['id' => $order['package_id']])) ?>"
                                                        data-amount="<?= esc($order['amount']) ?>"
                                                        data-gateway="<?= esc(ucfirst($order['gateway'])) ?>"
                                                        data-status="<?= esc(ucfirst($order['status'])) ?>"
                                                        data-payment-screenshot="<?= base_url('public/uploads/others/') . $order['payment_screenshot'] ?>"
                                                        data-payment-ref="<?= $order['payment_ref'] ?>">
                                                    <i class="bi bi-eye" style="margin-left: 0px"></i>
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <!-- Pagination links -->
                <div class="mt-3">
                    <?= $pager ?>
                </div>
                <?php } else { ?>
                    <p>No orders found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->

<?php if ($status == 'pending') : ?>
<!-- Modal -->
<!--<div class="modal fade" id="orderApproveModal" tabindex="-1" aria-labelledby="orderApproveModalLabel" aria-hidden="true">-->
<!--  <div class="modal-dialog modal-dialog-centered">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h1 class="modal-title fs-5" id="orderApproveModalLabel">Order Details</h1>-->
<!--        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <div id="orderApproveDetails"></div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<div class="modal fade" id="orderViewModal" tabindex="-1" aria-labelledby="orderViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="orderViewModalLabel">Order Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="orderDetails"></div>
      </div>
    </div>
  </div>
</div>

<script>
// document.addEventListener('DOMContentLoaded', function() {
//     const orderDetailsContainer = document.getElementById('orderApproveDetails');
//     document.querySelectorAll('.approve-order-btn').forEach(button => {
//         button.addEventListener('click', function() {
//             const txnId = this.getAttribute('data-txn-id');
//             orderDetailsContainer.innerHTML = `
//             <form action="<?= base_url(env('app.adminURL') . '/update-order/')?>${txnId}" method="POST">
//                 <?= csrf_field() ?>
//                 <input type="hidden" name="status" value="approved">
//                 <div class="row mb-3">
//                     <div class="col-6">
//                         <label for="active_commission" class="form-label">Active</label>
//                         <select name="active_commission" class="form-control">
//                             <option selected="" disabled="">Select Option</option>
//                             <option value="yes">Yes</option>
//                             <option value="no">No</option>
//                         </select>
//                     </div>
//                     <div class="col-6">
//                         <label for="active_commission_paid" class="form-label">Active Paid/Unpaid</label>
//                         <select name="active_commission_paid" class="form-control">
//                             <option selected="" disabled="">Select Option</option>
//                             <option value="yes">Paid</option>
//                             <option value="no">Unpaid</option>
//                         </select>
//                     </div>
//                 </div>
//                 <div class="row mb-3">
//                     <div class="col-6">
//                         <label for="passive_commission" class="form-label">Passive</label>
//                         <select name="passive_commission" class="form-control">
//                             <option selected="" disabled="">Select Option</option>
//                             <option value="yes">Yes</option>
//                             <option value="no">No</option>
//                         </select>
//                     </div>
//                     <div class="col-6">
//                         <label for="passive_commission_paid" class="form-label">Passive Paid/Unpaid</label>
//                         <select name="passive_commission_paid" class="form-control">
//                             <option selected="" disabled="">Select Option</option>
//                             <option value="yes">Paid</option>
//                             <option value="no">Unpaid</option>
//                         </select>
//                     </div>
//                 </div>
//                 <button type="submit" class="btn btn-success mt-2"><i class="bi bi-check-circle" style="margin-left: 0px"></i> Approve</button>
//             </form>
//             `;
//         });
//     });
// });


document.addEventListener('DOMContentLoaded', function() {
    const orderDetailsContainer = document.getElementById('orderDetails');
    document.querySelectorAll('.view-order-btn').forEach(button => {
        button.addEventListener('click', function() {
            const txnId = this.getAttribute('data-txn-id');
            const userName = this.getAttribute('data-user-name');
            const userPhone = this.getAttribute('data-user-phone');
            const userEmail = this.getAttribute('data-user-email');
            const packageName = this.getAttribute('data-package-name');
            const amount = this.getAttribute('data-amount');
            const gateway = this.getAttribute('data-gateway');
            const status = this.getAttribute('data-status');
            const createdAt = this.getAttribute('data-created-at');
            const paymentScreenshot = this.getAttribute('data-payment-screenshot');
            const paymentRef = this.getAttribute('data-payment-ref');
            orderDetailsContainer.innerHTML = `
                <p><strong>Date:</strong> ${createdAt}</p>
                <p><strong>Txn ID:</strong> ${txnId}</p>
                <p><strong>User:</strong> ${userName}</p>
                <p><strong>Phone:</strong> ${userPhone}</p>
                <p><strong>Email:</strong> ${userEmail}</p>
                <p><strong>Package:</strong> ${packageName}</p>
                <p><strong>Amount:</strong> ${amount}</p>
                <p><strong>Gateway:</strong> ${gateway}</p>
                <p><strong>Status:</strong> ${status}</p>
                <p><strong>Payment Reference:</strong> ${paymentRef}</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" onclick="window.open('${paymentScreenshot}', '_blank')">View Payment Screenshot</button>
                </div>
            `;
        });
    });
});
</script>
<?php endif; ?>
<?= $this->include('admin/footer') ?>
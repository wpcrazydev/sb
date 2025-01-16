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
                                    <a href="<?= base_url(env('app.adminURL') . '/user/' . esc($payout['user_id'])) ?>" class="btn btn-primary"><i class="bi bi-eye" style="margin-left: 0px"></i> View User</a>
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
                    <p>No payouts found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->
<?= $this->include('admin/footer') ?>
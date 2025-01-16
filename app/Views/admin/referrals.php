<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase">Referrals</h6>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <!-- Search form -->
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by Order ID" value="<?= esc(request()->getGet('search')) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Linked Order Id</th>
                            <th>User</th>
                            <th>From</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $referral): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($referral['created_at'])) ?></td>
                            <td><?= esc($referral['linked_order']) ?></td>
                            <td><?= esc($users[$referral['user_id']]['name']) ?></td>
                            <td><?= esc($users[$referral['from_uid']]['name']) ?></td>
                            <td><?= esc($referral['amount']) ?></td>
                            <td><?= esc($referral['type']) ?></td>
                            <td><?= esc($referral['status']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination links -->
                <div class="mt-3">
                    <?= $pager ?>
                </div>
                <?php } else { ?>
                    <p>No referrals found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->
<?= $this->include('admin/footer') ?>
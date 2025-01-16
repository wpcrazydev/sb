<div class="table-responsive">
    <?php if (!empty($purchaseHistory)) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>TXN Id</th>
                <th>Package</th>
                <th>Amount</th>
                <th>Gateway</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchaseHistory as $history): ?>
            <tr>
                <td><?= date('Y-m-d H:i', strtotime($history['created_at'])) ?></td>
                <td><?= date('Y-m-d H:i', strtotime($history['updated_at'])) ?></td>
                <td><?= esc($history['txn_id']) ?></td>
                <td><?= esc(get_dynamic_data('packages', 'name', ['id' => $history['package_id']])) ?></td>
                <td><?= esc($history['amount']) ?></td>
                <td><?= esc($history['gateway']) ?></td>
                <td><?= esc($history['status']) ?></td>
                <td>
                    <a href="<?= base_url(env('app.adminURL') . '/orders?status=' . esc($history['status']) . '&search=' . esc($history['txn_id'])) ?>" class="btn btn-primary">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Pagination links -->
    <div class="mt-3">
        <?= $purchasePager->links('purchaseGroup', 'default_full') ?>
    </div>
    <?php } else { ?>
        <p>No data found!</p>
    <?php } ?>
</div>
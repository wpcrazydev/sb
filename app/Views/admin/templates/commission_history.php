<div class="table-responsive">
    <?php if (!empty($commissionHistory)) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Refer Id</th>
                <th>User</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commissionHistory as $history): ?>
            <tr>
                <td><?= date('Y-m-d H:i', strtotime($history['created_at'])) ?></td>
                <td><?= date('Y-m-d H:i', strtotime($history['updated_at'])) ?></td>
                <td><?= esc(get_dynamic_data('users', 'ref_code', ['id' => $history['from_uid']])) ?></td>
                <td><?= esc(get_dynamic_data('users', 'name', ['id' => $history['from_uid']])) ?></td>
                <td><?= esc($history['amount']) ?></td>
                <td><?= esc($history['type'] == 'direct' ? 'Active' : 'Passive') ?></td>
                <td><?= esc($history['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Pagination links -->
    <div class="mt-3">
        <?= $purchasePager->links('commissionGroup', 'default_full') ?>
    </div>
    <?php } else { ?>
        <p>No data found!</p>
    <?php } ?>
</div>
<div class="table-responsive">
    <?php if (!empty($walletHistory)) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Type</th>
                <th>Existing Amount</th>
                <th>Updated Amount</th>
                <th>Final Balance</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($walletHistory as $history): ?>
            <tr>
                <td><?= date('Y-m-d H:i', strtotime($history['created_at'])) ?></td>
                <td><?= date('Y-m-d H:i', strtotime($history['updated_at'])) ?></td>
                <td><?= esc($history['type']) ?></td>
                <td><?= esc($history['amount']) ?></td>
                <td><?= esc($history['updated_amount']) ?></td>
                <td><?= esc($history['balance']) ?></td>
                <td><?= esc($history['description']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Pagination links -->
    <div class="mt-3">
        <?= $purchasePager->links('walletGroup', 'default_full') ?>
    </div>
    <?php } else { ?>
        <p>No data found!</p>
    <?php } ?>
</div>
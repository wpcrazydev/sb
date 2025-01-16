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
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by User ID" value="<?= esc(request()->getGet('search')) ?>">
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
                            <th>Type</th>
                            <th>Existing Balance</th>
                            <th>Updated Amount</th>
                            <th>Final Balance</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $walletLog): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($walletLog['created_at'])) ?></td>
                            <td><?= esc($users[$walletLog['uid']]['name']) ?></td>
                            <td><?= esc($walletLog['type']) ?></td>
                            <td><?= esc($walletLog['amount']) ?></td>
                            <td><?= esc($walletLog['updated_amount']) ?></td>
                            <td><?= esc($walletLog['balance']) ?></td>
                            <td><?= esc($walletLog['description']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination links -->
                <div class="mt-3">
                    <?= $pager ?>
                </div>
                <?php } else { ?>
                    <p>No wallet log found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->
<?= $this->include('admin/footer') ?>
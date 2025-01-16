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
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by Holder Name or Account Number" value="<?= esc(request()->getGet('search')) ?>">
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
                            <th>Bank</th>
                            <th>Holder</th>
                            <th>Ac. No.</th>
                            <th>IFSC</th>
                            <th>UPI</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $kyc): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($kyc['created_at'])) ?></td>
                            <td><?= esc($users[$kyc['user_id']]['name']) ?> <strong>=</strong> <?= esc($users[$kyc['user_id']]['ref_code']) ?></td>
                            <td><?= esc($kyc['bank_name']) ?></td>
                            <td><?= esc($kyc['holder_name']) ?></td>
                            <td><?= esc($kyc['account_number']) ?></td>
                            <td><?= esc($kyc['ifsc_code']) ?></td>
                            <td><?= esc($kyc['upi_id']) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="<?= base_url(env('app.adminURL') . '/kyc-update')?>" method="POST">
                                        <input type="hidden" name="status" value="approved">
                                        <input type="hidden" name="id" value="<?= esc($kyc['id']) ?>">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle" style="margin-left: 0px"></i></button>
                                    </form>
                                    <form action="<?= base_url(env('app.adminURL') . '/kyc-update')?>" method="POST">
                                        <input type="hidden" name="status" value="rejected">
                                        <input type="hidden" name="id" value="<?= esc($kyc['id']) ?>">
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle" style="margin-left: 0px"></i></button>
                                    </form>
                                    <a href="<?= base_url(env('app.adminURL') . '/user/' . esc($kyc['user_id'])) ?>">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-eye" style="margin-left: 0px"></i></button>
                                    </a>
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
                    <p>No kyc request found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->
<?= $this->include('admin/footer') ?>
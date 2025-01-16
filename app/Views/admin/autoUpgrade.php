<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <?php if ($addonStatus['auto_upgrade'] == 'Active') { ?>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#autoUpgradeModal">Add New</button>
        <?php } ?>
    </div>
    <?php if ($addonStatus['auto_upgrade'] != 'Active') {
        echo '<br>';
        echo $addonStatus['badge'];
    } ?>
    <hr />
    <div class="card <?= $addonStatus['auto_upgrade'] != 'Active' ? 'biz-disabled' : '' ?>">
        <div class="card-body">
            <!-- Search form -->
            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>From Package</th>
                            <th>Upgrade Package</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $package): ?>
                        <tr>
                            <td><?= esc($packageData[$package['package_id']]['name']) ?></td>
                            <td><?= esc($packageData[$package['upgrade_to']]['name']) ?></td>
                            <td>
                                <form action="<?= base_url(env('app.adminURL') . '/auto-upgrade-update/' . esc($package['id'])) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="status" value="delete">
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash" style="margin-left: 0px;"></i></button>
                                </form>
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
                    <p>No <?= $title ?> found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!--end page main-->

<!-- Modal -->
<div class="modal fade" id="autoUpgradeModal" tabindex="-1" aria-labelledby="autoUpgradeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="autoUpgradeModalLabel">Add New Auto Upgrade</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(env('app.adminURL') . '/new-auto-upgrade') ?>" method="POST" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="name" class="form-label">Package From</label>
                        <select name="package_id" id="" class="form-control">
                            <option value="0" disabled="" selected="">Select Package</option>
                            <?php foreach ($packages as $package): ?>
                                <option value="<?= $package['id'] ?>"><?= $package['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="name" class="form-label">Upgrade To</label>
                        <select name="upgrade_to" id="" class="form-control">
                            <option value="0" disabled="" selected="">Select Package</option>
                            <?php foreach ($packages as $package): ?>
                                <option value="<?= $package['id'] ?>"><?= $package['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Add Auto Upgrade">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('admin/footer') ?>
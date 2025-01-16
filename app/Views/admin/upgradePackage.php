<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Upgrade Package Details</h6>
                        <hr>
                        <form action="<?= base_url(env('app.adminURL') . '/upgrade-package/' . $upgradePackage['id']) ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Upgrade From</label>
                                <select class="form-select" aria-label="Default select example" name="upgrade_from" required>
                                    <option selected="" disabled="">Select Package</option>
                                    <?php foreach ($packages as $package): ?>
                                        <option value="<?= esc($package['id']) ?>" <?= $package['id'] == $upgradePackage['upgrade_from'] ? 'selected' : '' ?>><?= esc($package['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Upgrade To</label>
                                <select class="form-select" aria-label="Default select example" name="upgrade_to" required>
                                    <option selected="" disabled="">Select Package</option>
                                    <?php foreach ($packages as $package): ?>
                                        <option value="<?= esc($package['id']) ?>" <?= $package['id'] == $upgradePackage['upgrade_to'] ? 'selected' : '' ?>><?= esc($package['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" value="<?= $upgradePackage['price'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Direct Commission</label>
                                <input type="text" name="direct_commission" value="<?= $upgradePackage['direct_commission'] ?>" class="form-control">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">MLM Commission</label>
                                <input type="text" name="mlm_commission" value="<?= $upgradePackage['mlm_commission'] ?>" class="form-control">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Package Status</label>
                                <select class="form-select" aria-label="Default select example" name="status" required>
                                    <option value="active" <?= $upgradePackage['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $upgradePackage['status'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- right side section -->
    </div>
    <!--end row-->

    <!-- here is second row -->
</main>
<?= $this->include('admin/footer') ?>
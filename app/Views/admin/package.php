<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Package Details</h6>
                        <hr>
                        <img style="width:25%; margin-bottom:20px;" src="<?= base_url('public/uploads/packages/' . $package['image']) ?>" alt="Package Avatar">

                        <form action="<?= base_url(env('app.adminURL') . '/package/' . $package['id']) ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?= $package['name'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" value="<?= $package['price'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Referral Discount</label>
                                <input type="text" name="ref_discount" value="<?= $package['ref_discount'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Direct Commission</label>
                                <input type="text" name="direct_commission" value="<?= $package['direct_commission'] ?>" class="form-control">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">MLM Commission</label>
                                <input type="text" name="mlm_commission" value="<?= $package['mlm_commission'] ?>" class="form-control">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Package Status</label>
                                <select class="form-select" aria-label="Default select example" name="status" required>
                                    <option value="active" <?= $package['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $package['status'] == 'inactive' ? 'selected' : '' ?>>InActive</option>
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
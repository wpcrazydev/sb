<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Super Admin Details</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/profile') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?= $superAdminData['name'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="<?= $superAdminData['phone'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Email ID</label>
                                <input type="email" name="email" value="<?= $superAdminData['email'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label">Change Password</label>
                                <input type="text" name="password" value="" class="form-control">
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

        <!-- here is kyc data section -->
    </div>
    <!--end row-->

    <!-- here is second row -->
</main>
<?= $this->include('superAdmin/footer') ?>
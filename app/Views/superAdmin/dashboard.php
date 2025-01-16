<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase">Dashboard</h6>
        <button class="btn btn-outline-dark" onclick="checkVersion()">v <?= env('app.current_version') ?> <i class="bi bi-arrow-clockwise"></i></button>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-capitalize">License Overview</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/customizer/site') ?>" method="POST"
                            class="row g-3">
                            <?= csrf_field() ?>
                            <div class="input-group mb-1">
                                <span class="input-group-text">Email</span>
                                <input type="text" class="form-control" value="<?= env('app.license_email') ?>"
                                    disabled>
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text">Key</span>
                                <input type="text" class="form-control"
                                    value="<?= str_repeat('*', 8) . substr(env('app.license_key'), 8, -8) . str_repeat('*', 8) ?>"
                                    disabled>
                            </div>
                            <div class="input-group mb-1">
                                <span class="input-group-text">Status</span>
                                <input type="text" class="form-control" value="<?php if ($licenseCheck) { echo 'Active'; } else { echo 'Inactive'; } ?>" disabled>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <a href="javascript:void(0)" onclick="refreshLicense()"
                                        class="btn btn-outline-danger">Refresh</a>
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
</main>
<!-- Modal -->
<div class="modal fade" id="newVersionModal" tabindex="-1" aria-labelledby="newVersionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center">
            <i class="bi bi-check-circle" style="font-size: 90px; color: #06b006;"></i>
        </div>
        <h5 class="text-center">Update Available - v<?= $newVersion['new_version'] ?></h5>
        <p class="text-center mb-0">We added some new features and security patches to the website. Please click below to explore before update.</p>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="<?= base_url(env('app.adminURL') . 'core/new-update') ?>" class="btn btn-primary">Explore</a>
      </div>
    </div>
  </div>
</div>
<script>
    <?php if ($isNewVersion): ?>
        window.onload = function() {
            $('#newVersionModal').modal('show');
        }
    <?php endif; ?>
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function checkVersion() {
    $.ajax({
        url: '<?= base_url('/cron/check-version') ?>',
        type: 'GET',
        success: function(response) {
            if (response.status == 'success') {
                swalFire('success', 'Success', response.message);
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            }
        }
    });
}

function refreshLicense() {
    $.ajax({
        url: '<?= base_url(env('app.superAdminURL') . '/reset-license') ?>',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                reloadLicense();
            } else {
                swalFire('error', 'Error', response.message);
            }
        }
    });
}

function reloadLicense() {
    $.ajax({
        url: '<?= base_url(env('app.superAdminURL') . '/reissue-license') ?>',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                swalFire('success', 'Success', response.message);
            } else {
                swalFire('error', 'Error', response.message);
            }
        }
    });
}

function swalFire(type, title, msg) {
    Swal.fire({
        icon: type,
        title: title,
        html: msg,
        timer: 1500,
        timerProgressBar: true,
        showConfirmButton: false
    });
}
</script>
<?= $this->include('superAdmin/footer') ?>
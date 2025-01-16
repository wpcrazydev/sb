<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<style>
    .course-title {
        color: #283c50;
        font-size: 18px;
        font-weight: 600;
        text-decoration: underline;
        background: #fff;
        padding: 10px 15px;
        border-radius: 10px;
    }
    @media only screen and (max-width: 767px) {
        .course-title {
            font-size: 16px;
        }
    }
    .alert {
        margin-bottom: 0;
    }
</style>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($packages)) { ?>
                    <?php foreach ($packages as $package): ?>
                        <div class="col-xxl-3 col-md-6 mb-3">
                            <div class="card stretch stretch-full">
                                <div class="card-body p-3">
                                    <img src="<?= base_url('public/uploads/packages/'. get_dynamic_data('packages', 'image', ['id' => $package['upgrade_to']])); ?>" alt="Img" class="w-100 rounded">
                                    <h2 class="mt-3 text-center" style="font-size:15px; font-weight:600;">
                                        <?= esc(get_dynamic_data('packages', 'name', ['id' => $package['upgrade_from']])) . ' To ' . esc(get_dynamic_data('packages', 'name', ['id' => $package['upgrade_to']])); ?>
                                    </h2>
                                    <a href="#" class="btn ls-btn w-100" data-bs-toggle="modal" data-bs-target="#chooseGatewayModal" data-package="<?= $package['id']; ?>">Upgrade</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <p>No package found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="chooseGatewayModal" tabindex="-1" aria-labelledby="chooseGatewayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="chooseGatewayModalLabel">Choose Payment Gateway</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <?php if ($siteAdminToken['razorpay'] === 'active') : ?>
                    <a href="#" class="btn ls-btn w-100 mb-3 chooseGateway" data-gateway="razorpay">Razorpay</a>
                    <?php endif; ?>
                    <?php if ($siteAdminToken['phonepe'] === 'active') : ?>
                    <a href="#" class="btn ls-btn w-100 mb-3 chooseGateway" data-gateway="phonepe">PhonePe</a>
                    <?php endif; ?>
                    <?php if ($siteAdminToken['cosmofeed'] === 'active') : ?>
                    <a href="#" class="btn ls-btn w-100 mb-3 chooseGateway" data-gateway="cosmofeed">Cosmofeed</a>
                    <?php endif; ?>
                    <?php if ($siteAdminToken['upi_qr'] === 'active') : ?>
                    <a href="#" class="btn ls-btn w-100 mb-3 chooseGateway" data-gateway="upi_qr">UPI Qr</a>
                    <?php endif; ?>
                    <?php if ($siteAdminToken['wallet'] === 'active') : ?>
                    <a href="#" class="btn ls-btn w-100 chooseGateway" data-gateway="wallet">Wallet</a>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let selectedPackage;
        
        $('[data-bs-toggle="modal"]').on('click', function() {
            selectedPackage = $(this).data('package');
        });

        $('.chooseGateway').on('click', function(e) {
            e.preventDefault();
            var gateway = $(this).data('gateway');
            fetch('<?= base_url('user/processUpgrade'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    gateway: gateway,
                    package_id: selectedPackage
                })
            }).then(response => response.json()).then(data => {
                if (data.status == 'success') {
                    window.location.href = data.url;
                } else {
                    swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message,
                        button: "Okay",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        });
    });
</script>
<?= $this->include('user/footer') ?>

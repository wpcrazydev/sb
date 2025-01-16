<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<style>
iframe {
    width: 100%;
    height: 380px;
    border-radius: 10px;
}

@media (max-width: 768px) {
    iframe {
        height: 160px;
    }
}
</style>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">WP Migration Guide</h6>
                        <hr>
                        <iframe src="https://www.youtube.com/embed/6KcV1C1Ui5s?si=OV-lqq0yrYzJSFr4"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Import Data</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/wp-migration/import') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-12 col-12">
                                <input type="file" name="wp_data" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Import">
                                </div>
                                <div class="d-grid">
                                    <a href="<?= base_url(env('app.superAdminURL') . '/download-sample-csv') ?>"
                                        class="btn btn-outline-primary"><i class="bi bi-file-earmark-arrow-down"></i>
                                        Sample File</a>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <p class="text-muted mt-3">
                            <i class="bi bi-info-circle"></i>
                            STEP 1: Export data from WordPress according to the video guide.
                        </p>
                        <p class="text-muted mt-3">
                            <i class="bi bi-info-circle"></i>
                            STEP 2: Format your CSV file according to the example file.
                        </p>
                        <p class="text-muted mt-3">
                            <i class="bi bi-info-circle"></i>
                            STEP 3: Upload the CSV file and click on the button below.
                        </p>
                        <p class="text-muted mt-3">
                            <i class="bi bi-info-circle"></i>
                            STEP 4: Wait for the process to complete.
                        </p>
                        <p class="text-muted mt-3 mb-0">
                            <i class="bi bi-info-circle"></i>
                            STEP 5: If you face any issue, please <a href="<?= $agencyToken['help_url'] ?>"
                                target="_blank">contact us</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- here is kyc data section -->
    </div>
    <!--end row-->
</main>
<?= $this->include('superAdmin/footer') ?>
<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Agency Area <?= $addonStatus['agency_area'] != 'Active' ? $addonStatus['badge'] : '' ?></h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/agency-token-update') ?>" method="POST"
                            class="row g-3 <?= $addonStatus['agency_area'] != 'Active' ? 'biz-disabled' : '' ?>">
                            <?= csrf_field() ?>
                            <div class="col-md-12 col-12">
                                <input type="text" name="agency_label" class="form-control" required
                                    value="<?= isset($agencyToken['agency_label']) ? $agencyToken['agency_label'] : '' ?>"
                                    placeholder="Enter Agency Label">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="agency_url" class="form-control" required
                                    value="<?= isset($agencyToken['agency_url']) ? $agencyToken['agency_url'] : '' ?>"
                                    placeholder="Enter Agency URL">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="help_url" class="form-control" required
                                    value="<?= isset($agencyToken['help_url']) ? $agencyToken['help_url'] : '' ?>"
                                    placeholder="Enter Your WhatsApp Chat URL">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="cart_url" class="form-control" required
                                    value="<?= isset($agencyToken['cart_url']) ? $agencyToken['cart_url'] : '' ?>"
                                    placeholder="Enter Cart URL">
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
</main>
<?= $this->include('superAdmin/footer') ?>
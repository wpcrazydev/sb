<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <?php if ($addonStatus['cosmofeed_gateway'] == 'Active') { ?>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cosmoLinkModal">Add New</button>
        <?php } ?>
    </div>
    <?php if ($addonStatus['cosmofeed_gateway'] != 'Active') {
        echo '<br>';
        echo $addonStatus['badge'];
    } ?>
    <hr />
    <div class="card <?= $addonStatus['cosmofeed_gateway'] != 'Active' ? 'biz-disabled' : '' ?>">
        <div class="card-body">
            <!-- Search form -->

            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Package</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $cosmoLink): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($cosmoLink['created_at'])) ?></td>
                            <td><?= esc($packageData[$cosmoLink['package_id']]['name']) ?></td>
                            <td><?= esc($cosmoLink['link']) ?></td>
                            <td>
                                <form action="<?= base_url(env('app.adminURL') . '/cosmo-link-update/' . esc($cosmoLink['id'])) ?>" method="POST">
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

<!-- Modal -->
<div class="modal fade" id="cosmoLinkModal" tabindex="-1" aria-labelledby="cosmoLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cosmoLinkModalLabel">Add New Cosmofeed Link</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(env('app.adminURL') . '/new-cosmo-link') ?>" method="POST" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="package_id" class="form-label">Package</label>
                        <select name="package_id" class="form-select">
                            <option value="" disabled selected>Select</option>
                            <?php foreach ($packages as $package): ?>
                                <option value="<?= esc($package['id']) ?>"><?= esc($package['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="course_id" class="form-label">Course</label>
                        <input type="text" name="link" class="form-control">
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Add Cosmofeed Link">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end page main-->
<?= $this->include('admin/footer') ?>
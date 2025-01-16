<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#packageModal">Add New</button>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <!-- Search form -->
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by name" value="<?= esc(request()->getGet('search')) ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $package): ?>
                        <tr>
                            <td><?= esc($package['id']) ?></td>
                            <td><?= date('Y-m-d', strtotime($package['created_at'])) ?></td>
                            <td><img src="<?= base_url('public/uploads/packages/' . $package['image']) ?>" alt="<?= esc($package['name']) ?>" class="img-fluid" style="max-width: 100px;"></td>
                            <td><?= esc($package['name']) ?></td>
                            <td><?= esc($package['price']) ?></td>
                            <td><a href="<?= base_url(env('app.adminURL') . '/package/' . esc($package['id'])) ?>"><button class="btn btn-primary">View</button></a></td>
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
<div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="packageModalLabel">Add New Package</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(env('app.adminURL') . '/new-package') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="ref_discount" class="form-label">Referral Discount</label>
                        <input type="text" name="ref_discount" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="direct_commission" class="form-label">Direct Commission</label>
                        <input type="text" name="direct_commission" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="mlm_commission" class="form-label">MLM Commission</label>
                        <input type="text" name="mlm_commission" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">InActive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Add Package">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('admin/footer') ?>
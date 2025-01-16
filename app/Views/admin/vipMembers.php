<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#vipMemberModal">Add New</button>
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
                            <th>Date</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $vipMember): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($vipMember['created_at'])) ?></td>
                            <td><img src="<?= base_url('public/uploads/others/' . $vipMember['image']) ?>" alt="<?= esc($vipMember['name']) ?>" class="img-fluid" style="max-width: 100px;"></td>
                            <td><?= esc($vipMember['name']) ?></td>
                            <td>
                                <form action="<?= base_url(env('app.adminURL') . '/vip-member-update/' . esc($vipMember['id'])) ?>" method="POST">
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
<div class="modal fade" id="vipMemberModal" tabindex="-1" aria-labelledby="vipMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="vipMemberModalLabel">Add New Vip Member</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(env('app.adminURL') . '/new-vip-member') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
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
                        <input type="submit" class="btn btn-primary" value="Add Vip Member">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end page main-->
<?= $this->include('admin/footer') ?>
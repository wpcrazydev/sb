<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#webinarModal">Add New</button>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <!-- Search form -->
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by title" value="<?= esc(request()->getGet('search')) ?>">
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
                            <th>Title</th>
                            <th>Link</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $webinar): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($webinar['created_at'])) ?></td>
                            <td><img src="<?= base_url('public/uploads/others/' . $webinar['image']) ?>" alt="<?= esc($webinar['title']) ?>" class="img-fluid" style="max-width: 100px;"></td>
                            <td><?= esc($webinar['title']) ?></td>
                            <td><?= esc($webinar['link']) ?></td>
                            <td><?= esc($webinar['description']) ?></td>
                            <td>
                                <form action="<?= base_url(env('app.adminURL') . '/webinar-update/' . esc($webinar['id'])) ?>" method="POST">
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
<div class="modal fade" id="webinarModal" tabindex="-1" aria-labelledby="webinarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="webinarModalLabel">Add New Webinar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(env('app.adminURL') . '/new-webinar') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-12">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="col-12">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" class="form-control">
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Add Webinar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end page main-->
<?= $this->include('admin/footer') ?>
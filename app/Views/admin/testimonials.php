<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#testimonialModal">Add New</button>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <!-- Search form -->
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by user name" value="<?= esc(request()->getGet('search')) ?>">
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
                            <th>Content</th>
                            <th>Tag</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $testimonial    ): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($testimonial['created_at'])) ?></td>
                            <td><img src="<?= base_url('public/uploads/others/' . $testimonial['image']) ?>" alt="<?= esc($testimonial['name']) ?>" class="img-fluid" style="max-width: 100px;"></td>
                            <td><?= esc($testimonial['name']) ?></td>
                            <td><?= esc($testimonial['content']) ?></td>
                            <td><?= esc(ucfirst($testimonial['tag'])) ?></td>
                            <td>
                                <form action="<?= base_url(env('app.adminURL') . '/testimonial-update/' . esc($testimonial['id'])) ?>" method="POST">
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
<div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="testimonialModalLabel">Add New Testimonial</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url(env('app.adminURL') . '/new-testimonial') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
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
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" class="form-control"></textarea>
                    </div>
                    <div class="col-12">
                        <label for="tag" class="form-label">Tag</label>
                        <select name="tag" class="form-select">
                            <option value="" disabled selected>Select</option>
                            <option value="student">Student</option>
                            <option value="freelancer">Freelancer</option>
                            <option value="working professional">Working Professional</option>
                            <option value="affiliate marketer">Affiliate Marketer</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary" value="Add Testimonial">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end page main-->
<?= $this->include('admin/footer') ?>
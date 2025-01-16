<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase"><?= $title ?></h6>
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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $contactForm): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($contactForm['created_at'])) ?></td>
                            <td><?= esc($contactForm['name']) ?></td>
                            <td><?= esc($contactForm['phone']) ?></td>
                            <td><?= esc($contactForm['email']) ?></td>
                            <td><?= esc($contactForm['message']) ?></td>
                            <td>
                                <form action="<?= base_url(env('app.adminURL') . '/contact-form-update/' . esc($contactForm['id'])) ?>" method="POST">
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
                    <p>No data found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<!--end page main-->
<?= $this->include('admin/footer') ?>
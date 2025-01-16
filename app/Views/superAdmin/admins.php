<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase">Admins</h6>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addAdminModal" class="btn btn-outline-primary">Add New <i class="bi bi-person-plus"></i></a>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?php if (!empty($data)) { ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $user): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                            <td><?= esc($user['name']) ?></td>
                            <td><?= esc($user['phone']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= ucfirst(esc($user['status'])) ?></td>
                            <td>
                                <?php if ($user['status'] == 'active'): ?>
                                <a href="<?= base_url(env('app.superAdminURL') . '/admin-ban?uid=' . esc($user['id'])) ?>"><button class="btn btn-outline-danger"><i class="bi bi-x-circle-fill" style="margin-left: 0px"></i></button></a>
                                <?php else: ?>
                                <a href="<?= base_url(env('app.superAdminURL') . '/admin-unban?uid=' . esc($user['id'])) ?>"><button class="btn btn-outline-success"><i class="bi bi-check-circle-fill" style="margin-left: 0px"></i></button></a>
                                <?php endif; ?>
                                <a href="<?= base_url(env('app.superAdminURL') . '/admin-delete?uid=' . esc($user['id'])) ?>"><button class="btn btn-danger" style="margin-left: 5px"><i class="bi bi-trash-fill" style="margin-left: 0px"></i></button></a>
                                <?php if ($user['status'] == 'active'): ?>
                                <a href="<?= base_url(env('app.superAdminURL') . '/goToAdmin?uid=' . esc($user['id'])) ?>"><button class="btn btn-success" style="margin-left: 5px"><i class="bi bi-box-arrow-in-right" style="margin-left: 0px"></i></button></a>
                                <?php endif; ?>
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
                    <p>No admin found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAdminModalLabel">Add New Admin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url(env('app.superAdminURL') . '/add-admin') ?>" method="POST" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-12">
                <label for="name" class="form-label">Admin Name</label>
                <input type="text" name="name" placeholder="Enter admin name" class="form-control">
            </div>
            <div class="col-12">
                <label for="phone" class="form-label">Admin Phone</label>
                <input type="number" name="phone" placeholder="Enter admin phone" class="form-control">
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Admin Email</label>
                <input type="email" name="email" placeholder="Enter admin email" class="form-control">
            </div>
            <div class="col-12">
                <label for="password" class="form-label">Admin Password</label>
                <input type="password" name="password" placeholder="Enter admin password" class="form-control">
            </div>
            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="Add Admin">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--end page main-->
<?= $this->include('superAdmin/footer') ?>
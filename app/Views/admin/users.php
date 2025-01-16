<?= $this->include('admin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase">Users</h6>
        <!--<a href="#" data-bs-toggle="modal" data-bs-target="#modifyEarningModal" class="btn btn-outline-primary">Modify Earning <i class="bi bi-sliders"></i></a>-->
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <!-- Search form -->
            <div class="mb-3">
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by phone, email or ref code" value="<?= esc(request()->getGet('search')) ?>">
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
                            <th>Referral Code</th>
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
                            <td><?= esc($user['ref_code']) ?></td>
                            <td>
                                <a href="<?= base_url(env('app.adminURL') . '/user/' . esc($user['id'])) ?>"><button class="btn btn-primary"><i class="bi bi-eye" style="margin-left: 0px"></i></button></a>
                                <a href="<?= base_url(env('app.adminURL') . '/goToUser?uid=' . esc($user['id'])) ?>"><button class="btn btn-success" style="margin-left: 5px"><i class="bi bi-box-arrow-in-right" style="margin-left: 0px"></i></button></a>
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
                    <p>No users found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modifyEarningModal" tabindex="-1" aria-labelledby="modifyEarningModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modifyEarningModalLabel">Modify Earning</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url(env('app.adminURL') . '/update-user-earning') ?>" method="POST" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-12">
                <label for="ref_code" class="form-label">Sponsor SB Code</label>
                <input type="text" name="ref_code" placeholder="Enter Sponsor SB Code" class="form-control" required>
            </div>
            <div class="col-12">
                <label for="from_ref_code" class="form-label">Lead SB Code</label>
                <input type="text" name="from_ref_code" placeholder="Enter Lead SB Code" class="form-control">
            </div>
            <div class="col-12">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" placeholder="Enter amount" class="form-control">
            </div>
            <div class="col-12">
                <label for="type" class="form-label">Type</label>
                <select name="type" class="form-control">
                    <option selected="" disabled="">Select Type</option>
                    <option value="direct">Direct</option>
                    <option value="mlm">Mlm</option>
                    <option value="manual">Manual</option>
                </select>
            </div>
            <div class="col-12">
                <label for="paid" class="form-label">is Paid?</label>
                <select name="paid" class="form-control">
                    <option selected="" disabled="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="col-12">
                <label for="duration" class="form-label">Duration</label>
                <select name="duration" class="form-control">
                    <option selected="" disabled="">Select Duration</option>
                    <option value="today">Today</option>
                    <option value="7days">7 Days</option>
                    <option value="30days">30 Days</option>
                    <option value="alltime">All Time</option>
                    <option value="default">Default</option>
                </select>
            </div>
            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="Update Earning">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--end page main-->
<?= $this->include('admin/footer') ?>
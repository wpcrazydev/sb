<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="pagenav">
        <h6 class="mb-0 text-uppercase">FAQ's</h6>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addFaqModal" class="btn btn-outline-primary">Add New <i class="bi bi-file-earmark-plus"></i></a>
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
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $faq): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($faq['created_at'])) ?></td>
                            <td><?= esc($faq['question']) ?></td>
                            <td><?= esc($faq['answer']) ?></td>
                            <td>
                                <a href="<?= base_url(env('app.superAdminURL') . '/faq-delete?id=' . esc($faq['id'])) ?>"><button class="btn btn-danger" style="margin-left: 5px"><i class="bi bi-trash-fill" style="margin-left: 0px"></i></button></a>
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
                    <p>No faq found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addFaqModalLabel">Add New FAQ</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url(env('app.superAdminURL') . '/add-faq') ?>" method="POST" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-12">
                <label for="question" class="form-label">FAQ Question</label>
                <input type="text" name="question" placeholder="Enter FAQ question" class="form-control">
            </div>
            <div class="col-12">
                <label for="answer" class="form-label">FAQ Answer</label>
                <input type="text" name="answer" placeholder="Enter FAQ answer" class="form-control">
            </div>
            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="Add FAQ">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--end page main-->
<?= $this->include('superAdmin/footer') ?>
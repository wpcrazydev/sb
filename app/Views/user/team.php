<?= $this->include('user/header') ?>
<style>
.teamimg {
    width: 50px;
    height: 50px;
}
</style>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card rounded-4 w-100">
                        <div class="card-body p-0">
                            <div class="p-3 rounded">
                                <div class="table-responsive">
                                    <?php if (!empty($teamMembers)) { ?>
                                    <table id="example" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:25%;">Avatar</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Package</th>
                                                <th>Status</th>
                                                <th>Joined At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($teamMembers as $team): ?>
                                            <tr>
                                                <td class="ls-td">
                                                    <img class="teamimg" src="<?= base_url('public/uploads/profiles/' . $team['image']); ?>" alt="img">
                                                </td>
                                                <td class="ls-td"><?= esc($team['name']); ?></td>
                                                <td class="ls-td"><?= esc($team['email']); ?></td>
                                                <td class="ls-td"><?= esc($packages[$team['plan_id']]); ?></td>
                                                <td class="ls-td"><?= esc(ucfirst($team['status'])); ?></td>
                                                <td class="ls-td"><?= date('d-m-Y', strtotime($team['created_at'])); ?>
                                                </td>
                                                <td class="ls-td"><a
                                                        href="https://api.whatsapp.com/send?phone=91<?= esc($team['phone']) ?>&text=Hello!"
                                                        target="_blank"><button
                                                            class="btn btn-success rounded-4">WhatsApp</button></a></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            </tfoot>
                                    </table>
                                    <?php
                                    } else {
                                        echo "<div class='alert alert-warning'>No data found!</div>";
                                    }
                                    ?>

                                    <nav aria-label="Page navigation" style="margin-top:12px;">
                                        <ul class="pagination justify-content-center">
                                            <!-- Previous Page Link -->
                                            <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?= $page - 1 ?>"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php else: ?>
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php endif; ?>

                                            <!-- Page Numbers -->
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                            <?php endfor; ?>

                                            <!-- Next Page Link -->
                                            <?php if ($page < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                            <?php else: ?>
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>
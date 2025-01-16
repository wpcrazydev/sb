<?= $this->include('user/header') ?>
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
                                    <?php if (!empty($payouts)) { ?>
                                    <table id="example" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($payouts as $payout): ?>
                                            <tr>
                                                <td class="ls-td"><?= date('d-m-Y', strtotime($payout['created_at'])); ?></td>
                                                <td class="ls-td"><?= esc($payout['amount']); ?></td>
                                                <td class="ls-td"><?= esc(ucfirst($payout['status'])); ?></td>
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
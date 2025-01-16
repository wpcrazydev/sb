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
                                    <?php if (!empty($referrals)) { ?>
                                    <table id="example" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>From</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($referrals as $referral): ?>
                                            <tr>
                                                <td class="ls-td"><?= date('d-m-Y', strtotime($referral['created_at'])); ?></td>
                                                <td class="ls-td"><?= esc($users[$referral['from_uid']]); ?></td>
                                                <td class="ls-td"><?= esc($referral['amount']); ?></td>
                                                <td class="ls-td"><?= esc(ucfirst($referral['type'] == 'direct' ? 'Active' : 'Passive')); ?></td>
                                                <td class="ls-td"><?= esc(ucfirst($referral['status'])); ?></td>
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
                                                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
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
                                    
                                            <!-- Limited Page Numbers -->
                                            <?php
                                            $start = max(1, $page - 2);
                                            $end = min($totalPages, $page + 2);
                                    
                                            if ($start > 1) {
                                                echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                                if ($start > 2) {
                                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                }
                                            }
                                    
                                            for ($i = $start; $i <= $end; $i++) {
                                                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                                                echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                                echo '</li>';
                                            }
                                    
                                            if ($end < $totalPages) {
                                                if ($end < $totalPages - 1) {
                                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                }
                                                echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                            }
                                            ?>
                                    
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
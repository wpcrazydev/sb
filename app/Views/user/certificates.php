<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($courses)) { ?>
                <?php foreach ($courses as $course): ?>
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-3">
                            <img src="<?= base_url('public/uploads/courses/'.$course['image']); ?>" alt="<?= $course['name']; ?>" style="width:100%; border-radius:10px;">
                            <h2 class="mt-3 text-center" style="font-size:15px; font-weight:600;">
                                <?= $course['name']; ?>
                            </h2>
                            <?php if (in_array($course['id'], $watchedCourseIds)) { ?>
                            <a href="<?= base_url('user/quiz?course='.$course['id']); ?>" class="btn ls-btn mt-2">Get Certificate</a>
                            <?php } else { ?>
                            <a href="#" class="btn ls-btn mt-2" data-bs-toggle="modal" data-bs-target="#lockedCourse">Get
                                Certificate</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php
                } else {
                    echo "No course found!";
                }
                ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="lockedCourse" tabindex="-1" aria-labelledby="lockedCourseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3">
                <div class="d-flex justify-content-center align-items-center">
                    <i class="feather-x-circle mb-3" style="font-size: 90px; color: #cb3e29;"></i>
                </div>
                <h2 class="text-center">Certificate Locked</h2>
                <p class="text-center" style="font-size:13px;">You need to watch all the course videos to get the certificate.</p>
            </div>
        </div>
    </div>
</div>
<?= $this->include('user/footer') ?>
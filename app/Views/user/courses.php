<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<style>
    .course-title {
        color: #283c50;
        font-size: 18px;
        font-weight: 600;
        text-decoration: underline;
        background: #fff;
        padding: 10px 15px;
        border-radius: 10px;
    }
    @media only screen and (max-width: 767px) {
        .course-title {
            font-size: 16px;
        }
    }
    .alert {
        margin-bottom: 0;
    }
</style>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($courses)) { ?>
                    <?php foreach ($courses as $packageId => $packageCourses): ?>
                        <?php
                            $package = null;
                            foreach ($packages as $pkg) {
                                if ($pkg['id'] == $packageId) {
                                    $package = $pkg;
                                    break;
                                }
                            }
                        ?>
                        <?php if ($package): ?>
                            <div class="col-xxl-12 col-md-12 mb-3">
                                <div class="alert alert-primary course-title" role="alert">
                                    <b><?= ucfirst($package['name']); ?></b>
                                </div>
                            </div>
                            <?php foreach ($packageCourses as $course): ?>
                                <div class="col-xxl-3 col-md-6 mb-3">
                                    <div class="card stretch stretch-full">
                                        <div class="card-body p-3">
                                            <img src="<?= base_url('public/uploads/courses/'.$course['image']); ?>" alt="<?= esc($course['name']); ?>" class="w-100 rounded">
                                            <h2 class="mt-3 text-center" style="font-size:15px; font-weight:600;">
                                                <?= esc($course['name']); ?>
                                            </h2>
                                            <a href="<?= base_url('user/course-view?course='.$course['id'].'&page=1'); ?>" class="btn ls-btn w-100">Start Now</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <p>No courses found!</p>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>

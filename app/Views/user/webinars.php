<?= $this->include('user/header') ?>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($webinars)) { ?>
                    <?php foreach ($webinars as $webinar): ?>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body p-3">
                                    <img src="<?= base_url('public/uploads/others/'.$webinar['image']); ?>" alt="<?= $webinar['title']; ?>" class="w-100 rounded">
                                    <h2 class="mt-3 text-center" style="font-size:15px; font-weight:600;">
                                        <?= $webinar['title']; ?>
                                    </h2>
                                    <?php if (!empty($webinar['description'])): ?>
                                        <p class="text-center" style="margin-bottom:8px;"><?= $webinar['description']; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($webinar['link'])): ?>
                                        <a href="<?= $webinar['link']; ?>" target="_blank" class="btn ls-btn w-100">Watch Now</a>
                                    <?php else: ?>
                                        <a href="javascript:void(0);" class="btn ls-btn btn-danger w-100">Link Not Available</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                } else {
                    echo "No webinar found!";
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>
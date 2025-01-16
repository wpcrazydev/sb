<?= $this->include('user/header') ?>
<style>
   iframe {
    width: 100%;
    height: 170px;
    border-radius: 10px;
}

@media only screen and (max-width: 768px) {
    iframe {
        height: 158px;
    }
}
</style>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($trainings)) { ?>
                    <?php foreach ($trainings as $training): ?>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body p-3">
                                    <iframe src="https://www.youtube.com/embed<?= parse_url($training['video_url'], PHP_URL_PATH); ?>" title="<?= $training['title']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    <h2 class="mt-3 text-center" style="font-size:15px; font-weight:600;">
                                        <?= $training['title']; ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                } else {
                    echo "No training video found!";
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>
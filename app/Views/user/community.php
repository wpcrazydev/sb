<?= $this->include('user/header') ?>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($community)) { ?>
                    <?php foreach ($community as $res): ?>
                        <div class="col-xxl-2 col-md-6 col-6">
                            <a href="<?= $res['link'] ?>">
                                <div class="card stretch stretch-full">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-center">
                                            <img src="<?= base_url('public/uploads/others/'.$res['image']); ?>" alt=""
                                                style="width:80%; border-radius:10px; margin-bottom: 15px;">
                                        </div>
                                        <h2 style="font-size: 15px; font-weight: 600; text-align: center; margin: 0px;">
                                            <?= $res['title'] ?>
                                        </h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php
                } else {
                    echo "No community link found!";
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>
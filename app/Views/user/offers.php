<?= $this->include('user/header') ?>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row">
                <?php if (!empty($offers)) { ?>
                    <?php foreach ($offers as $offer): ?>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card stretch stretch-full">
                                <div class="card-body p-3">
                                    <img src="<?= base_url('public/uploads/others/'.$offer['image']); ?>" alt="<?= $offer['title']; ?>" class="w-100 rounded">
                                    <h2 class="mt-3 text-center" style="font-size:15px; font-weight:600;">
                                        <?= $offer['title']; ?>
                                    </h2>
                                    <?php if (!empty($offer['description'])): ?>
                                        <p class="text-center" style="margin-bottom:0px;"><?= $offer['description']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                } else {
                    echo "No offer found!";
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>
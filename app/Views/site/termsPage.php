<?= $this->include('site/header') ?>
<?= $this->include('alert') ?>
<main class="rbt-main-wrapper">
    <div class="rbt-elements-area rbt-section-gap pt--60" style="background: #c6c2fc5c;">
        <div class="container">
            <div class="row gy-5 row--30 justify-content-center">
                <div class="col-lg-12">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <h3 class="title text-start">Terms & Conditions</h3>
                        <p><?= $content['content'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->include('site/footer') ?>
<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<style>
span#basic-addon {
    border-radius: 15px;
    background-color: #5b3aee;
    color: #fff;
    cursor: pointer;
    font-weight: 400;
    font-size: 13px;
}
</style>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <!-- Affiliate Link Copied Alert -->
            <div id="copyAlert" class="alert border-0 bg-soft-success alert-dismissible fade show py-2 d-none">
                <div class="d-flex align-items-center">
                    <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="ms-3">
                        <div class="text-success">Link copied to clipboard!</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <!-- Affiliate Link Copied Alert END-->

            <!-- Affiliate Code Copied Alert-->
            <div id="copyCodeAlert" class="alert border-0 bg-soft-success alert-dismissible fade show py-2 d-none">
                <div class="d-flex align-items-center">
                    <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="ms-3">
                        <div class="text-success">Referral code copied to clipboard!</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <!-- Affiliate code Copied Alert END-->

            <div class="row">
                <div class="col-12 col-lg-12 d-flex">
                    <div class="card rounded-4 w-100">
                        <div class="card-body p-0">
                            <div class="p-3 rounded">
                                <p>Referral Code</p>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control copyCodeInput " value="<?= $userData['ref_code']; ?>"
                                        aria-label="Recipient's username" aria-describedby="basic-addon" readonly><span
                                        class="input-group-text" id="basic-addon" onclick="copyCode(this)">Copy</span>
                                </div>
                                <p>Common Link</p>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control copyInput"
                                        value="<?= base_url() ?>checkout?ref=<?= $userData['ref_code'] ?>"
                                        aria-label="Recipient's username" aria-describedby="basic-addon" readonly><span
                                        class="input-group-text" id="basic-addon" onclick="copyLink(this)">Copy</span>
                                </div>
                                <p>Packages Link</p>
                                <?php foreach ($packages as $pkg): ?>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="useravatar" class="form-label"><?= $pkg['name']; ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control copyInput"
                                            value="<?= base_url() ?>checkout?pkg=<?= $pkg['id'] ?>&ref=<?= $userData['ref_code'] ?>"
                                            aria-label="Recipient's username" aria-describedby="basic-addon" readonly>
                                        <span class="input-group-text" id="basic-addon"
                                            onclick="copyLink(this)">Copy</span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</main>
<!--end page main-->

<script>
function copyLink(element) {
    const copyInput = element.previousElementSibling;
    copyInput.select();
    copyInput.setSelectionRange(0, 99999);
    document.execCommand('copy');
    const copyAlert = document.getElementById('copyAlert');
    copyAlert.classList.remove('d-none');
}
</script>

<script>
function copyCode(element) {
    const copyCodeInput = element.previousElementSibling;
    copyCodeInput.select();
    copyCodeInput.setSelectionRange(0, 99999);
    document.execCommand('copy');
    const copyCodeAlert = document.getElementById('copyCodeAlert');
    copyCodeAlert.classList.remove('d-none');
}
</script>
<?= $this->include('user/footer') ?>
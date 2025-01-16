<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-uppercase">Frontend Theme</h6>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" target="_blank" class="btn btn-outline-primary" style="font-size: 12px;"><i class="bi bi-code-slash"></i> Code Editor</a>
                        </div>
                        <hr>
                        <h6 class="mb-3 text-uppercase text-decoration-underline">Import HTML Files</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/customizer') ?>" method="POST" class="row g-3" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="theme_type" value="site">
                            <div class="col-md-12 col-12">
                                <input type="file" name="theme_file" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Import Zip">
                                </div>
                            </div>
                        </form>
                        <h6 class="mt-5 mb-3 text-uppercase text-decoration-underline">Import Assets Files</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/customizer') ?>" method="POST" class="row g-3" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="theme_type" value="site">
                            <input type="hidden" name="file_type" value="assets">
                            <div class="col-md-12 col-12">
                                <input type="file" name="theme_file" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Import Zip">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-uppercase">User Theme</h6>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" target="_blank" class="btn btn-outline-primary" style="font-size: 12px;"><i class="bi bi-code-slash"></i> Code Editor</a>
                        </div>
                        <hr>
                        <h6 class="mb-3 text-uppercase text-decoration-underline">Import HTML Files</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/customizer') ?>" method="POST" class="row g-3" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="theme_type" value="user">
                            <div class="col-md-12 col-12">
                                <input type="file" name="theme_file" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Import Zip">
                                </div>
                            </div>
                        </form>
                        <h6 class="mt-5 mb-3 text-uppercase text-decoration-underline">Import Assets Files</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/customizer') ?>" method="POST" class="row g-3" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="theme_type" value="user">
                            <input type="hidden" name="file_type" value="assets">
                            <div class="col-md-12 col-12">
                                <input type="file" name="theme_file" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Import Zip">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-uppercase">Email Theme</h6>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" target="_blank" class="btn btn-outline-primary" style="font-size: 12px;"><i class="bi bi-code-slash"></i> Code Editor</a>
                        </div>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/customizer') ?>" method="POST" class="row g-3" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="theme_type" value="email">
                            <div class="col-md-12 col-12">
                                <input type="file" name="theme_file" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Import Theme">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-3 text-uppercase text-decoration-underline">Colour Picker - <span class="text-success">Coming Soon...</span></h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/update-theme-colours') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <?php
                            foreach ($themeConfig as $section => $colors) {
                                echo "<p class='text-uppercase'><strong>Category -</strong> " . ucfirst($section) . "</p>";
                                foreach ($colors as $key => $value) {
                                    $colorKey = str_replace('_', '-', $key);
                                    if ($key === 'isGradient') {
                                        unset($colors[$key]);
                                    }
                                    echo '<div class="col-md-4 col-12" style="margin: 0px;">';
                                    echo "<label for='{$colorKey}' class='form-label' style='font-size: 12px;'>" . ucfirst(str_replace('_', ' ', $key)) . "</label>";
                                    echo "<input type='color' class='form-control' name='{$section}[{$colorKey}]' id='{$colorKey}' value='{$value}' onchange='updateColorValue(this)'><br>";
                                    echo '</div>';
                                }
                            }
                            ?>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary" value="Update Colours">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-3 text-uppercase text-decoration-underline">Last 10 Theme Backups</h6>
                            <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Build Backup</a>
                        </div>
                        <hr>
                        <table class="table table-striped table-bordered">
                            <!-- <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Action</th>
                                </tr>
                            </thead> -->
                            <tbody>
                                <p>Coming Soon...</p>
                                <!-- <tr>
                                    <td>01-01-2023</td>
                                    <td>theme.zip</td>
                                    <td>2.5 MB</td>
                                    <td>
                                        <a href="#" class="btn btn-primary" style="margin-right: 5px"><i class="bi bi-download" style="margin-left: 0px"></i></a>
                                        <a href="#" class="btn btn-success" style="margin-right: 5px"><i class="bi bi-arrow-clockwise" style="margin-left: 0px"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="bi bi-trash" style="margin-left: 0px"></i></a>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="d-flex justify-content-center align-items-center box-content">
            <i class="bi bi-check-circle" style="font-size: 5rem; color: green;"></i>
        </div>
        <p class="text-center" style="font-size:18px;">Coming Soon...</p>
      </div>
    </div>
  </div>
</div>
<script>
function updateColorValue(input) {
    input.setAttribute('value', input.value);
}
</script>
<?= $this->include('superAdmin/footer') ?>
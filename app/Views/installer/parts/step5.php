<div class="box-content">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="website_name" value="<?= isset($data['session']['website_name']) ? $data['session']['website_name'] : '' ?>" placeholder="Website Name...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="website_tagline" value="<?= isset($data['session']['website_slogan']) ? $data['session']['website_slogan'] : '' ?>" placeholder="Website Tagline...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="website_url" value="<?= isset($data['session']['website_url']) ? $data['session']['website_url'] : '' ?>" placeholder="Website URL...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="admin_url" value="<?= isset($data['session']['admin_url']) ? $data['session']['admin_url'] : '' ?>" placeholder="Admin URL...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="super_admin_url" value="<?= isset($data['session']['super_admin_url']) ? $data['session']['super_admin_url'] : '' ?>" placeholder="Super Admin URL...">
        </div>

        <p id="step5ErrorMessage"></p>
        
</div>
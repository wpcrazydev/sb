<div class="box-content">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="licenseKey" value="<?= isset($data['session']['license_key']) ? $data['session']['license_key'] : '' ?>" placeholder="License Key...">
        </div>
        <div class="form-group mb-3">
            <input type="email" class="form-control" id="licenseEmail" value="<?= isset($data['session']['license_email']) ? $data['session']['license_email'] : '' ?>" placeholder="License Registered Email...">
        </div>

        <p id="step2ErrorMessage"></p>
        
</div>
<div class="box-content">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="admin_name" value="<?= isset($data['session']['admin_name']) ? $data['session']['admin_name'] : '' ?>" placeholder="Super Admin Name...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="admin_phone" value="<?= isset($data['session']['admin_phone']) ? $data['session']['admin_phone'] : '' ?>" placeholder="Super Admin Phone...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="admin_email" value="<?= isset($data['session']['admin_email']) ? $data['session']['admin_email'] : '' ?>" placeholder="Super Admin Email...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="admin_password" value="<?= isset($data['session']['admin_password']) ? $data['session']['admin_password'] : '' ?>" placeholder="Super Admin Password...">
        </div>

        <p id="step4ErrorMessage"></p>
        
</div>
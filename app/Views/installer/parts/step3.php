<div class="box-content">
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="db_host" value="<?= isset($data['session']['db_host']) ? $data['session']['db_host'] : '' ?>" placeholder="Database Host...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="db_name" value="<?= isset($data['session']['db_name']) ? $data['session']['db_name'] : '' ?>" placeholder="Database Name...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="db_user" value="<?= isset($data['session']['db_user']) ? $data['session']['db_user'] : '' ?>" placeholder="Database Username...">
        </div>
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="db_password" value="<?= isset($data['session']['db_password']) ? $data['session']['db_password'] : '' ?>" placeholder="Database Password...">
        </div>
        <p id="step3ErrorMessage"></p>
        
</div>
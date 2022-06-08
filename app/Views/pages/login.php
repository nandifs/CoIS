<div class="login-box">
    <div class="card">
        <div class="card-body">
            <div class="login-logo">
                <img class="center-block" src="<?= $baseFolderImg; ?>/applogo.png" alt="Logo Corporate" width="180" height="200">
            </div>
            <?php echo form_open('login/user_login'); ?>

            <div class="input-group mb-3">
                <input type="username" class="form-control" placeholder="User Name" name="username">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block center-block">Masuk</button>
                </div>
            </div>
            <hr>
            <?php echo view('templates/notification'); ?>
            <small>*)Gunakan User Id atau User Name Anda untuk Login</small>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
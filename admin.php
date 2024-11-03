<?php include 'header.php'; ?>

<div class="login-page first-container">
    <div class="login-box">
        <div class="card card-outline rounded-0 card-dark text-dark mt-3 mb-4 elevation-4">
            <div class="card-body px-4">
                <p class="login-box-msg small">
                    <img src="assets/system-images/logo.png" class="mb-2" height="50" /><br>
                    <strong>Pet Plus</strong><br>
                    Administrator Portal
                </p>

                <form method="POST" onsubmit="showLoaderAnimation()">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="username" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <button type="submit" name="login_button" class="btn btn-danger btn-sm btn-block elevation-1">
                                LOGIN
                                <span class="fas fa-sign-in-alt pl-1"></span>
                            </button>
                        </div>

                        <div class="col-12 mb-3">
                            <a href="index.php" type="button" class="btn btn-light border btn-sm btn-block">
                                Return to <b class="text-danger">Homepage</b>
                                <span class="fas fa-sign-in-alt pl-1"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
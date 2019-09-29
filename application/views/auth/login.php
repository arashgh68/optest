<div class="container pt-lg-md main">
    <div class="row justify-content-center my-4">
        <div class="col-md-7 col-lg-5">
            <div class="card bg-white shadow border-0">
                <div class="card-header bg-transparent pb-2">
                    <h2>ورود</h2>
                    <p>لطفا موارد زیر را تکمیل فرمایید</p>
                </div>
                <div class="card-body px-lg-5 py-lg-4">
                    <?php if ($message != "") { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $message ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    <?php } ?>

                    <?php echo form_open('auth/login'); ?>
                    <div class="form-group">
                        <label class="sr-only">نام کاربری</label>
                        <input type="text" name="identify" class="form-control form-control-alternative"
                               placeholder="نام کاربری" id="identify">
                        <!--  <span class="help-block"><?php echo $username_err; ?></span> -->
                    </div>
                    <div class="form-group">
                        <label class="sr-only">کلمه عبور</label>
                        <input type="password" name="password" id="password" placeholder="کلمه عبور"
                               class="form-control form-control-alternative">
                        <!--        <span class="help-block"><?php echo $password_err; ?></span> -->
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input class="custom-control-input" type="checkbox" name="remember" id="remember">
                        <label class="custom-control-label" for="remember">مرا به خاطر بسپار</label>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="ورود">
                    </div>
                    <p>عضو نیستید؟<a href="registeruser">به سادگی عضو شوید</a>.</p>
                    <?php echo form_close(); ?>
                    <?php echo validation_errors(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
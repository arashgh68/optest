<div class="container pt-lg-md mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card bg-white shadow border-0">
                <div class="card-header bg-transparent pb-2">
                    <h2>تغییر کلمه عبور</h2>
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

                    <?php echo form_open("auth/change_password");?>
                    <div class="form-group">
                        <label class="sr-only">کلمه عبور</label>
                        <input type="password" name="old" class="form-control form-control-alternative"
                               placeholder="کلمه عبور" id="old">
                        <!--  <span class="help-block"><?php echo $username_err; ?></span> -->
                    </div>
                    <div class="form-group">
                        <label class="sr-only">کلمه عبور جدید</label>
                        <input type="password" name="new" id="new" placeholder="کلمه عبور جدید"
                               class="form-control form-control-alternative">
                        <!--        <span class="help-block"><?php echo $password_err; ?></span> -->
                    </div>
                    <div class="form-group">
                        <label class="sr-only">تکرار کلمه عبور جدید</label>
                        <input type="password" name="new_confirm" id="new_confirm" placeholder="تکرار کلمه عبور جدید"
                               class="form-control form-control-alternative">
                        <!--        <span class="help-block"><?php echo $password_err; ?></span> -->
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="ذخیره">
                    </div>
                    <p>عضو نیستید؟<a href="registeruser">به سادگی عضو شوید</a>.</p>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
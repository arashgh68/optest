<div class="container pt-lg-md main">
    <div class="row justify-content-center my-4">
        <div class="col-md-7 col-lg-5">
            <div class="card bg-white shadow border-0">
                <div class="card-header bg-transparent pb-2">
                    <h2>عضویت</h2>
                    <p>لطفا موارد زیر را کامل کنید</p>
                </div>
                <div class="card-body">
                    <?php if ($message != "") { ?>
                        <div class="alert alert-danger"><?php echo $message; ?></div>
                    <?php } ?>

                    <form action="registeruser" method="post">

                        <div class="form-group">
                            <label class="sr-only">نام</label>
                            <input type="text" name="first_name" class="form-control form-control-alternative" placeholder="نام" value=""
                                   required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only">نام خانوادگی</label>
                            <input type="text" name="last_name" class="form-control form-control-alternative" placeholder="نام خانوادگی" value=""
                                   required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only">آدرس Email</label>
                            <input type="text" name="email" class="form-control form-control-alternative" placeholder="ایمیل" value="" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only">نام کاربری</label>
                            <input type="text" name="identity" class="form-control form-control-alternative" placeholder="نام کاربری" value=""
                                   required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only">رمز عبور</label>
                            <input type="password" name="password" class="form-control form-control-alternative" placeholder="رمز عبور" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only">تکرار رمز عبور</label>
                            <input type="password" name="password_confirm" class="form-control form-control-alternative"
                                   placeholder="تکرار رمز عبور" required>
                        </div>
                        <br>
                        <div class="form-group align-content-center">
                            <input type="submit" class="btn btn-primary" name="register" value="ثبت نام">
                            <input type="reset" class="btn btn-primary" name="reset" value="بازنشانی فرم">
                        </div>
                        <p>عضو هستید؟<a href="login">وارد شوید</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
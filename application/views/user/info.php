<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 shadow-sm fixed-top">
        <div class="d-flex align-items-center">
            <img src="<?php echo base_url() ?>image/person.png" class="rounded shadow-sm bg-white p-1" height="120" width="100" alt="">
            <div class="mr-3">
                <h6 class="mb-0"><?php echo $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name ?></h6>
                <!-- <span class="text-secondary">رشته تحصیلی</span> -->
            </div>
        </div>
        <div class="border-bottom my-4"></div>
        <ul id="user-menu" class="navbar-nav flex-column">
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-home ml-2"></i>داشبورد</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book-reader  ml-2 "></i>درس</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/quiz" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book   ml-2"></i>آزمون</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/info" class="nav-link text-white p-2 mb-2 sidebar-link active"><i class="fas fa-user ml-2"></i>اطلاعات کاربری</a>
            </li>
        </ul>
    </div>
</div>


<div class="content row">
    <div class="col-md-9 mr-auto pt-4">

        <div class="card-item bg-white shadow-sm p-4">
            <h3>اطلاعات کاربری <a href="#" class="btn btn-success float-left">ذخیره</a></h3>

            <div class="border-bottom border-light my-3"></div>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">نام</label>
                <div class="col-md-9 col-lg-6">
                    <input type="text" name="" id="" class="form-control" placeholder="<?php echo $user->first_name ?>">
                </div>
            </div>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">نام خانوادگی</label>
                <div class="col-md-9 col-lg-6">
                    <input type="text" name="" id="" class="form-control" placeholder="<?php echo $user->last_name ?>">
                </div>
            </div>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">موبایل</label>
                <div class="col-md-9 col-lg-6">
                    <input type="text" name="" id="" class="form-control" placeholder="09151445280">
                </div>
            </div>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">ایمیل</label>
                <div class="col-md-9 col-lg-6">
                    <input type="text" name="" id="" class="form-control" placeholder="<?php echo $user->email ?>">
                </div>
            </div>
            <div class="border-bottom border-light my-3"></div>
            <h5>اطلاعات تحصیلی</h5>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">رشته تحصیلی</label>
                <div class="col-md-9 col-lg-6">
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">مقطع تحصیلی</label>
                <div class="col-md-9 col-lg-6">
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="border-bottom border-light my-3"></div>
            <h5>اطلاعات امنیتی</h5>
            <div class="row form-group">
                <label for="" class="col-md-3 col-form-label text-md-left">کلمه عبور</label>
                <div class="col-md-9 col-lg-6">
                    <input type="password" name="" id="" class="form-control">
                </div>
            </div>
        </div>

    </div>
</div>
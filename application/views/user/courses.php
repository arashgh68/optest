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
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link active"><i class="fas fa-book-reader ml-2"></i>درس</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/quiz" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book   ml-2"></i>آزمون</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/info" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-user ml-2"></i>اطلاعات کاربری</a>
            </li>
        </ul>
    </div>
</div>

<div class="content row">
    <div class="col-md-9 mr-auto pt-4">
        <div class="card-item bg-white p-4 mb-4">
            <h4>درس ها</h4>
            <div class="row d-flex flex-wrap">
                <?php foreach ($courses as $course) { ?>
                    <div class="col-md-4 mt-4">
                        <div class="course-item card border-0 shadow-sm">
                            <img class="card-img-top" src="<?php echo base_url() ?>image/course.png" alt="">
                            <div class="card-body">
                                <h6 class="card-title text-truncate"><?php echo $course->title ?></h6>
                                <p class="card-text">این متن برای تست می باشد</p>
                                <a class="btn btn-primary float-left" href="<?php echo base_url('course/index/') . $course->course_id ?>">نمایش</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>
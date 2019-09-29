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
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link active"><i class="fas fa-home ml-2"></i>داشبورد</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/course" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book-reader  ml-2 "></i>درس</a>
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
        <div class="card-item bg-white mb-4 p-3">
            <div class="row">
                <div class="col-md-6 border-left">
                    <?php if ($last_quiz) { ?>
                    <h5><img src="<?php echo base_url() ?>image/verified-text-paper.png" alt=""> آخرین آزمون</h5>
                    <span><?php echo $last_quiz->title ?></span>
                    <strong class="mr-4">نمره: </strong> <span class="h5 text-info"><?php echo number_format($last_quiz->quiz_grade, 2) ?></span>
                    <br>
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo base_url('quiz/index/') . $last_quiz->quiz_id ?>" class="btn btn-primary">نمایش</a>
                    </div>
                    <?php } else { ?>
                    <h5>شما در هیچ آزمونی شرکت نکرده اید</h5>
                    <?php } ?>

                </div>
                <div class="col-md-6">
                    <h5><img src="<?php echo base_url() ?>image/test-black.png" alt=""> آزمون فعال</h5>
                    <?php if (!$active_quiz) { ?>
                    <span>شما آزمون فعالی ندارید</span>
                    <?php } else { ?>
                    <span><?php echo $last_quiz->title ?></span>
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo base_url('take/index/') . $last_quiz->quiz_id ?>" class="btn btn-success">ادامه آزمون</a>
                    </div>
                    <?php } ?>
                </div>

            </div>
        </div>

        <div class="card-item bg-white p-4 mb-4">
            <h4>درس ها</h4>
            <?php if ($courses) { ?>
            <div class="row d-flex flex-wrap">
                <?php foreach ($courses as $course) { ?>
                <div class="col-md-4 mt-4">
                    <div class="course-item card border-0 shadow-sm">
                        <img class="card-img-top" src="<?php echo base_url() ?>image/course.png" alt="">
                        <div class="card-body">
                            <h6 class="card-title text-truncate"><?php echo $course->title ?></h6>
                            <p class="card-text"></p>
                            <a class="btn btn-primary float-left" href="<?php echo base_url('course/index/') . $course->course_id ?>">نمایش</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } else { ?>
            <h6>
                شما در هیچ درسی ثبت نام نکرده اید
            </h6>
            <div class="text-left">
                <a href="<?php echo base_url(); ?>course" class="btn btn-outline-primary mt-4">مشاهده همه دروس <i class="fas fa-arrow-left  fa-fw"></i></a>
            </div>
            <?php } ?>


        </div>
    </div>
</div>
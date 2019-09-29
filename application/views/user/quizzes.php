<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 shadow-sm fixed-top">
        <div class="d-flex align-items-center">
            <img src="<?php echo base_url() ?>image/person.png" class="rounded shadow-sm bg-white p-1" height="120" width="100" alt="">
            <div class="mr-3">
                <h6 class="mb-0">آرش غفاری مقدم</h6>
                <span class="text-secondary">رشته تحصیلی</span>
            </div>
        </div>
        <div class="border-bottom my-4"></div>
        <ul id="user-menu" class="navbar-nav flex-column">
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-home ml-2"></i>داشبورد</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/course" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book-reader  ml-2 "></i>درس</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url() ?>user/quiz" class="nav-link text-white p-2 mb-2 sidebar-link active"><i class="fas fa-book   ml-2"></i>آزمون</a>
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
            <h4>آزمون ها</h4>
            <div class="row mt-4 align-items-center">
                <div class="col-4">
                    <strong class="text-truncate">نام آزمون</strong>
                </div>
                <div class="col-4">
                    <strong class="text-truncate">نام درس</strong>
                </div>
                <div class="col-md-2 text-center">
                    <strong>میانگین نمرات</strong>
                </div>
                <div class="col-2 text-left">

                </div>
            </div>
            <div class="border-bottom mt-2"></div>
            <?php foreach ($quizzes as $quiz) { ?>
                <div class="row mt-4 align-items-center">
                    <div class="col-4">
                        <h6 class="text-truncate"><?php echo $quiz->title ?></h6>
                    </div>
                    <div class="col-4">
                        <span class="text-truncate"><?php echo $quiz->ctitle ?></span>
                    </div>
                    <div class="col-md-2 text-center">
                        <span><?php echo number_format($quiz->avg_grade) ?></span>
                    </div>
                    <div class="col-2 text-left">
                        <a href="<?php echo base_url('quiz/index/') . $quiz->quiz_id ?>" class="btn btn-primary">نمایش</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
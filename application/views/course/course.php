<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 bg-primary shadow-sm fixed-top">
        <div class="d-flex align-items-center">
            <!-- <i class="fas fa-chevron-right fa-3x ml-3"></i> -->
            <div class="mr-0">
                <h6 class="mb-0"><?php echo $course->title ?></h6>
                <!-- <span class="text-secondary">مهارت های آزمون های ICDL</span>                     -->
                <ul id="user-menu" class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a href="<?php echo base_url('course') ?>" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-home ml-2"></i>درس ها</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-bottom my-4"></div>
        <ul id="user-menu" class="navbar-nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-home ml-2"></i>خلاصه</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book-reader  ml-2  "></i>سرفصل ها</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book   ml-2 "></i>آزمون ها</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-prescription   ml-2 "></i>عملکرد شما</a>
            </li>
        </ul>
    </div>
</div>

<div class="content row">
    <div class="col-md-9 mr-auto pt-4">
        <div class="card-item bg-white mb-4 p-4">
            <h4><?php echo $course->title ?></h4>
            <p class="text-justify"><?php echo $course->description ?></p>
        </div>
        <div class="card-item bg-white mb-4 p-4">
            <h4>سرفصل ها</h4>
            <?php foreach ($parts as $part) { ?>
                <div class="row mt-4 align-items-center">
                    <div class="col-4">
                        <h6>مهارت اول<h6>
                    </div>
                    <div class="col-6">
                        <h6><?php echo $part->title ?><h6>
                    </div>
                    <div class="col-2">
                        <a href="<?php echo base_url('course/part/') . $part->part_id ?>" class="btn btn-info">نمایش</a>
                    </div>

                </div>
            <?php } ?>
        </div>
        <div class="card-item bg-white mb-4 p-4">
            <h4>آزمون ها</h4>
            <?php foreach ($quizzes as $quiz) { ?>
                <div class="row mt-4 align-items-center">
                    <div class="col-4">
                        <h6><?php echo $quiz->title ?><h6>
                    </div>
                    <div class="col-4">
                        شامل همه مباحث
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <?php if ($take_quiz) { ?>
                            <a class="btn btn-success ml-2" href="<?php echo base_url('take/') . $quiz->quiz_id ?>">شرکت در آزمون</a>
                        <?php } ?>
                        <a class="btn btn-primary" href="<?php echo base_url('quiz/index/') . $quiz->quiz_id ?>">نمایش</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
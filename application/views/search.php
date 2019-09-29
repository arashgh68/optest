<div class="container pt-lg-md main">
    <div class="card bg-white shadow border-0 my-4">
        <div class="card-body">
        <div class="row">
            <?php foreach ($courses as $course) { ?>
                <div class="col-md-4 mt-4">
                    <div class="course-item card border-0 shadow-sm">
                        <img class="card-img-top" src="<?php echo base_url() ?>image/course.png" alt="">
                        <div class="card-body">
                            <h6 class="card-title text-truncate"><?php echo $course->title ?></h6>
                            <p class="card-text">این متن برای تست می باشد</p>
                            <?php if ($course->registered) { ?>
                                <a class="btn btn-primary float-left" href="<?php echo base_url('course/index/') . $course->course_id ?>">نمایش</a>
                            <?php } else { ?>
                                <a class="btn btn-success float-left" href="<?php echo base_url('course/register/') . $course->course_id ?>">ثبت نام</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        </div>
    </div>
</div>
<!-- Showcase Section -->
<section id="showcase-section">
    <div class="container py-5 text-light">
        <h3>سیستم آزمون آنلاین هوشمند</h3>
        <div class="row py-4">
            <div class="col-md-6 align-self-center">
                <h6>اگر می خواهید در آزمون های مدرسه، کنکور ، ارشد، استخدامی موفق بشی اولا باید منابع خوب پیدا کن
                    بعد از اون باید آزمون بدی تا با شرایط آزمون آشنا بشی. اینجا ما بهترین منابع و آزمون ها رو به
                    صورت هوشمند آماده کردی تا راه موفقیت شما آسون تر بشه</h6>
                <a href="<?php echo $this->ion_auth->logged_in()? '#course-section':base_url('auth/registeruser') ?>" class="btn btn-light mt-3 btn-lg">همین حالا شروع کن<i class="fas fa-arrow-left fa-lg mr-2"></i></a>

            </div>
            <div class="col-md-6 text-center d-none d-md-block">
                <img src="<?php echo base_url(); ?>image/success.png" height="348" alt="">
            </div>
        </div>

        <div class="border-bottom border-light"></div>

        <div class="row mt-5 mx-auto">
            <div class="col-md-3 mt-3 mt-md-0 d-flex align-items-center">
                <img src="<?php echo base_url(); ?>image/study.png" alt="">
                <div class="mr-2">
                    <h6 class="mb-0">یاد بگیر</h6>
                    <small class="text-muted">
                        با استفاده از منابع سایت یاد بگیرید
                    </small>
                </div>
            </div>
            <div class="col-md-3 mt-3 mt-md-0 d-flex align-items-center">
                <img src="<?php echo base_url(); ?>image/test.png" alt="">
                <div class="mr-2">
                    <h6 class="mb-0">تست بزن</h6>
                    <small class="text-muted">
                        در آزمون های سایت شرکت کنید
                    </small>
                </div>
            </div>
            <div class="col-md-3 mt-3 mt-md-0 d-flex align-items-center">
                <img src="<?php echo base_url(); ?>image/analyze.png" alt="">
                <div class="mr-2">
                    <h6 class="mb-0">تحلیل کن</h6>
                    <small class="text-muted">
                        یادگیری و آزمون های خودت رو تحلیل کن
                    </small>
                </div>
            </div>
            <div class="col-md-3 mt-3 mt-md-0 d-flex align-items-center">
                <img src="<?php echo base_url(); ?>image/graduate.png" alt="">
                <div class="mr-2">
                    <h6 class="mb-0">موفق شو</h6>
                    <small class="text-muted">
                        به راحتی راه موفقیت را پیدا کن
                    </small>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End Of Showcase Section -->


<!-- Course Section -->
<section id="course-section">
    <div class="container py-5">
        <h3>درس ها</h3>
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
        <div class="text-left">
            <a href="<?php echo base_url(); ?>course" class="btn btn-outline-primary mt-4">مشاهده همه دروس <i class="fas fa-arrow-left  fa-fw"></i></a>
        </div>
    </div>
</section>
<!-- End Course Section -->


<!-- Exam Section -->
<section id="exam-section">
    <div class="dark-overlay">
        <div class="container py-4 text-light">
            <div class="row">
                <div class="col text-center">
                    <h3>آزمون آنلاین</h3>
                    <p>با شرکت در آزمون های آنلاین خود را برای آزمون های واقعی آماده کنید</p>
                    <a href="#"><i class="far fa-play-circle fa-3x text-light"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Exam Section -->


<!-- empty -->
<section>
    <div class="container py-5 my-5">

    </div>
</section>
<!--  -->
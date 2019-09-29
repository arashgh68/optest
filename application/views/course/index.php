<div class="container main">
    <div class="row mb-5">
        <div class="col-md-3 mt-4 py-4 bg-white text-dark shadow-sm">
            <!-- <div class="d-flex align-items-center">
                <i class="fas fa-chevron-right fa-3x ml-3"></i>
                <div class="mr-0">
                    <h6 class="mb-0">مهارت ICDL</h6>
                    <span class="text-secondary">مهارت های آزمون های ICDL</span>                    
                </div>
            </div> -->
            <h4>فیلتر</h4>
            <select name="category" id="" class="form-control">
                <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category->category_id ?>"><?php echo $category->name ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-9 mr-auto">
            <div class="row d-flex flex-wrap">
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
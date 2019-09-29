<div class="row mb-4">
    <div class="col-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5><?php echo $part->title ?></h5>

                <ul class="list-unstyled">
                    <li><a href="<?php echo base_url("/course/part/" . $part->part_id) ?>">خلاصه وضعیت</a></li>
                    <li><a href="">پرسش و پاسخ</a> </li>
                    <li><a href="<?php echo base_url("/course/part/" . $part->part_id . "/resource") ?>">منابع</a></li>
                    <li><a href="<?php echo base_url("/course/part/" . $part->part_id . "/quiz") ?>">آزمون ها</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-9">
        <h3>آزمون ها</h3>

        <!--view quizzes -->
        <div class="row">
            <?php foreach ($quizzes as $quiz) { ?>

                <div class="col-4">
                    <div class="card flex-md-row mb-2 shadow-sm h-md-250">
                        <div class="card-body">
                            <h4><?php echo $quiz->title ?></h4>
                            <h6><?php echo $quiz->description ?></h6>
                            <h6>زمان آزمون: <?php echo $quiz->max_time ?> ثانیه</h6>
                            <h6>آخرین نمره: </h6>
                            <div class="float-left">
                                <?php if ($take_quiz) { ?>
                                    <a class="text-success ml-2"
                                       href="<?php echo base_url('take/') . $quiz->quiz_id ?>">شرکت در آزمون</a>
                                <?php } ?>
                                <a class=""
                                   href="<?php echo base_url('quiz/index/') . $quiz->quiz_id ?>">نمایش</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


    </div>
</div>
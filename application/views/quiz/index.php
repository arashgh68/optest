<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>گزارشات</h3>
                <br>
                <?php echo 'بهترین نمره:'.$UserRecords['MaxScore'];?>
                <br>
                <?php echo 'سریع ترین آزمون:'.$UserRecords['FastestScore'];?>
                <br>
                <?php echo 'بهترین نمره در کمترین زمان:'.$UserRecords['BestScore'];?>
                <br>
                <?php echo 'کمترین نمره'.$UserRecords['MinScore'];?>
                <br>
                <?php echo 'کندترین آزمون:'.$UserRecords['SlowestScore'];?>
                <br>
            </div>
        </div>
    </div>
    <div class="col-md-9">

        <!--view quizzes -->
        <div class="row">
            <?php foreach ($quizzes as $quiz) { ?>

                <div class="col-md-4">
                    <div class="card flex-md-row mb-2 shadow-sm h-md-250">
                        <div class="card-body">
                            <h4 class="text-truncate"><?php echo $quiz->title ?></h4>
                            <div><span class="text-black-50">زمان آزمون: </span><?php echo $quiz->max_time ?> ثانیه</div>
                            <div><span class="text-black-50">آخرین نمره: </span></div>
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
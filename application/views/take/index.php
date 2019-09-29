<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 bg-primary shadow-sm fixed-top">
        <div id="time" class="d-flex align-items-center">
            <?php if (isset($quiz_name)) { ?>
                <h6 class="mb-4"><?php echo $quiz_name ?></h6>
            <?php } ?>
        </div>
    </div>
</div>

<div class="content row">
    <div class="col-md-9 mr-auto">
        <div class="card-item bg-white my-4 p-4 d-flex flex-column">
            <?php if (isset($quiz_name)) { ?>
                <h2 class="mb-4"><?php echo $quiz_name ?></h2>
                <dl class="row">
                    <dt class="col-md-2">
                        مدت زمان پاسخگویی:
                    </dt>
                    <dd class="col-md-9 pnf">
                        <?php echo $quiz_time ?> ثانیه
                    </dd>
                    <dt class="col-md-2">
                        تعداد سوالات:
                    </dt>
                    <dd class="col-md-9 pnf">
                        <?php echo $questions ?>
                    </dd>
                    <dt class="col-md-2">
                        نمره:
                    </dt>
                    <dd class="col-md-9 pnf">
                        <?php echo $max_score ?>
                    </dd>
                    <dt class="col-md-2">
                        نمره منفی:
                    </dt>
                    <dd class="col-md-9 pnf">
                        <?php echo $demerit == 0 ? 'ندارد' : 'هر ' . $demerit . ' سوال غلط 1 نمره منفی' ?>
                    </dd>
                </dl>
            <?php }
            if (isset($error)) { ?>
                <div class="alert alert-danger">
                    <?php echo $error ?>
                </div>
            <?php } else { ?>
                <a href='<?php echo base_url("take/start") ?>' class="btn btn-success align-self-end">شروع آزمون</a>
            <?php } ?>
        </div>
    </div>
</div>
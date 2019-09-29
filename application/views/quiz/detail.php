<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 bg-primary shadow-sm fixed-top">
        
        <ul id="user-menu" class="navbar-nav flex-column">
            <li class="nav-item">
                <a href="<?php echo base_url('user/quiz') ?>" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-user ml-2"></i>آزمون های کاربر</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('course/index/').$course->course_id ?>" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-book ml-2"></i>درس</a>
            </li>
            
        </ul>
        <div class="border-bottom my-4"></div>
            <div class="mr-0">
                <h6 class="mb-0"><?php echo $quiz->title ?></h6>
            </div>
       
        
        
    </div>
</div>

<div class="content row">
    <div class="col-md-9 mr-auto pt-4">
        <div class="card-item bg-white mb-4 p-4">
            <div class="row">
                <div class="col-md-6 d-flex">
<div class="d-flex flex-column w-100">
                    <h6>بالاترین نمره</h6>
                    <span><?php echo number_format($max_quiz,2) ?></span>
                    </div>
                    <div class="d-flex flex-column mr-4 w-100">
                    <h6>میانگین نمرات</h6>
                    <span><?php echo number_format($avg,2) ?></span>
                  </div>
<div class="d-flex align-items-end justify-content-end w-100">
                    <a class="btn btn-success" href="<?php echo base_url('take/index/') . $quiz->quiz_id ?>">شرکت در آزمون</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="curve_chart"></div>
                </div>
            </div>
        </div>

        <div class="card-item bg-white mb-4 p-4">
            <h4>آزمون ها</h4>
            <?php
            $i = 1;
            foreach ($quizzes as $quiz) { ?>
                <div class="row mt-4 align-items-center">
                    <div class="col-1">
                        <h6><?php echo $i ?> <h6>
                    </div>
                    <div class="col-2">
                        <?php echo $quiz->quiz_date ?>
                        <br>
                        <?php echo date_format(date_create($quiz->quiz_start), "H:i:s") ?>
                    </div>
                    <div class="col-2">
                        نمره آزمون
                        <h6 class="mb-0"><?php echo number_format($quiz->quiz_grade, 2) ?></h6>
                    </div>
                    <div class="col-2">
                        زمان آزمون
                        <h6 class="mb-0"><?php echo $quiz->time_elapsed ?></h6>
                    </div>
                    <div class="col-5 d-flex justify-content-end">
                        <a class="btn btn-primary" href="<?php echo base_url('take/result/') . $quiz->user_quiz_id ?>">نمایش</a>
                    </div>
                </div>
                <?php
                $i++;
            } ?>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'نمره'], 
            <?php
            $n = 1;            
            foreach(array_reverse($quizzes) as $quiz) {
                ?> ['<?php echo "آزمون " . $n ?>', <?php echo $quiz->quiz_grade ?> ], 
                <?php $n++;
            } ?>
        ]);

        var options = {
            title: 'نمودار پیشرفت نمره',
            curveType: 'function',
            legend: {
                position: 'bottom'
            },
            vAxis: {
                textPosition: 'none'
            },
            hAxis: {
                textPosition: 'none'
            },
            chartArea: {
                left: 0,
                top: 0,
                width: "100%",
                height: "100%"
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>
<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 shadow-sm fixed-top">
    <ul id="user-menu" class="navbar-nav flex-column border-bottom">
            <li class="nav-item">
                <a href="<?php echo base_url('quiz/index/').$quiz_id ?>" class="nav-link text-white p-2 mb-2 sidebar-link"><i class="fas fa-arrow-right ml-2"></i>بازگشت</a>
            </li>        
        </ul>
        <div id="question" class="mt-4">
            <div class="border-bottom">
                <span>سوالات</span>
                <span class="badge badge-light float-left p-1"><?php echo $total ?></span>
            </div>
            <div ss-container style="max-height:300px;">
            <div class="question-items ml-3 d-flex flex-row flex-wrap justify-content-between">
                <?php
                $i = 1;
                foreach ($questions as $question) { ?>
                    <div class="question-item mt-2 d-flex align-items-center justify-content-center <?php echo $question->user_result ?>" id="<?php echo $question->question_id ?>">
                        <?php echo $i ?>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="content row">
    <div class="col-md-9 mr-auto">
        <div class="card-item bg-white p-4 my-4 d-flex align-items-center justify-content-around">
            <h5 class="rounded-circle bg-success text-light d-flex align-items-center justify-content-center" style="height:70px;width:70px;"><?php echo number_format($grade, 2) ?></h5>
            <div class="mr-5 d-flex flex-column">
                <strong><i class="fas fa-clock text-info"></i> <?php echo $quiz_time ?></strong>
            </div>
            <div class="mr-4 d-flex d-column">
                <table class="table-hover table-borderless table mb-0">
                    <tr class="">
                        <td class="p-0 pr-4"><i class="fas fa-check-circle text-success"></i> پاسخ های صحیح</td>
                        <td class="p-0 pr-4"><strong><?php echo $correct ?></strong></td>
                    </tr>
                    <tr class="">
                        <td class="p-0 pr-4"><i class="fas fa-times-circle text-danger"></i> پاسخ های غلط</td>
                        <td class="p-0 pr-4"><strong><?php echo $false ?></strong></td>
                    </tr>
                    <tr class="">
                        <td class="p-0 pr-4"><i class="far fa-circle text-black-50"></i> بدون پاسخ</td>
                        <td class="p-0 pr-4"><strong><?php echo $total - $answered ?></strong></td>
                    </tr>
                    <tr class="">
                        <td class="p-0 pr-4"><i class="fas fa-circle"></i> تعداد کل سوالات</td>
                        <td class="p-0 pr-4"><strong><?php echo $total ?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        $i = 1;
        foreach ($questions as $question) { ?>
            <div class="card question border-0 mt-4 <?php echo $question->user_result ?>" id="question-<?php echo $question->question_id ?>">
                <div class="card-body d-flex">
                    <div>
                        <?php echo '<h5 class="question-number">' . $i . '</h5> ' ?>
                    </div>
                    <div class="w-100">
                        <h6 class="card-title rounded-lg"><?php echo $question->question; ?></h6>
                        <ul class="list-unstyled pr-0">
                            <?php foreach ($answers[$question->question_id] as $answer) { ?>
                                <li class="py-1 mb-3">
                                    <div class="form-check form-check-inline m-0">
                                        <label class="form-check-label" for="<?php echo $question->question_id . '_' . $answer->answer_id ?>">
                                            <input class="form-check-input answer_trig" type="radio" name="<?php echo $question->question_id ?>" id="<?php echo $question->question_id . '_' . $answer->answer_id ?>" <?php echo $answer->checked ? 'checked' : null ?>>
                                            <span class="checkmark"></span>
                                            <span class="<?php echo $answer->correct ? 'text-success' : null ?> <?php echo !$answer->correct && $answer->checked ? 'text-danger' : null ?>"><?php echo $answer->answer ?></span>
                                        </label>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        } ?>
    </div>
</div>

<script>
    //رفتن به سوال با کلیک بر راهنمای سوال
    $(".question-item").click(function() {
        var value = this.id;
        $('html, body').animate({
            scrollTop: $("#question-" + value).offset().top - 80
        }, 1000);
    });
</script>
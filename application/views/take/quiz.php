<div class="row">
    <div id="quiz-sidebar" class="col-md-3 p-4 bg-primary shadow-sm fixed-top">
        <div id="time" class="d-flex flex-column align-items-center">
            <div id="timer" class="back-timer d-flex justify-content-center align-items-center">
                <div class="front-timer d-flex flex-column align-items-center justify-content-end">
                    <h5 class="mb-0"><span id="minute"></span>:<small class="text-muted"><span id="second"></span></small></h5>
                    <span class="mb-1">باقیمانده</span>
                </div>
            </div>
            <span class="mt-3">زمان کل: <span id="total_time"></span> دقیقه</span>
        </div>
        <div id="question" class="mt-4">
            <div class="border-bottom">
                <span>سوالات</span>
                <span class="badge badge-light float-left p-1">۱۶</span>
            </div>
            <div ss-container style="max-height:300px;">
            <div class="question-items ml-3 d-flex flex-row flex-wrap justify-content-between">
                <?php
                $i = 1;
                foreach ($questions as $question) { ?>

                    <div class="question-item mt-2 d-flex align-items-center justify-content-center" <?php echo $question->checked ? 'style="background-color: rgb(204, 238, 255);"' : null ?> id="<?php echo $question->question_id ?>">
                        <?php echo $i ?>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
            </div>
        </div>
        <button type="button" class="btn btn-success float-left mt-5" id="finish_quiz">پایان آزمون</button>
    </div>
</div>

<div class="content row">
    <div class="col-md-9 mr-auto">
        <?php
        $i = 1;
        foreach ($questions as $question) { ?>
            <div class="card question border-0 mt-4 <?php echo $question->checked ? ' question-ans' : null ?>" id="question-<?php echo $question->question_id ?>">
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
                                            <span class="check-text"><?php echo $answer->answer ?></span>
                                        </label>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <button id="clear_<?php echo $question->question_id ?>" class="btn btn-outline-danger un-answer-trig float-left">حذف پاسخ
                        </button>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        } ?>
    </div>
</div>

<script>
    //جواب به سوال
    $(".answer_trig").click(function() {
        var url = "<?php echo base_url('take/answer') ?>";
        var value = this.id;

        $.ajax({
            type: "POST",
            url: url,
            data: {
                value: value
            },
            success: function(result) {
                if (result == 1) {
                    var question_id = value.split('_')[0];                    
                    $('#' + question_id).css("background-color", "#cceeff");
                    $('#question-' + question_id).addClass('question-ans');
                    $('#'+value).blur();
                } else {
                    alert("Error");
                }
            }
        });
    });
    //حذف جواب سوال
    $(".un-answer-trig").click(function() {
        var url = "<?php echo base_url('take/clear_answer') ?>";
        var value = this.id;

        $.ajax({
            type: "POST",
            url: url,
            data: {
                value: value
            },
            success: function(result) {
                if (result == 1) {
                    var question_id = value.split('_')[1];
                    $('#' + question_id).css("background-color", "#fcfcfc");
                    $('#question-' + question_id).removeClass('question-ans');
                    $('input[name=' + question_id + ']').prop('checked', false);
                } else {
                    alert("Error");
                }
            }
        });
    });
    //رفتن به سوال با کلیک بر راهنمای سوال
    $(".question-item").click(function() {
        var value = this.id;
        $('html, body').animate({
            scrollTop: $("#question-" + value).offset().top - 80
        }, 1000);
    });

    $("#finish_quiz").click(function() {
        window.location.href = "<?php echo base_url('take/finish') ?>";
    });
    //quiz timer
    // Update the count down every 1 second
    var distance = <?php echo $max_time ?>;
    var total = <?php echo $quiz_time ?>;
    document.getElementById("total_time").innerHTML = total/60;
    var x = setInterval(function() {

        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor(distance / (60 * 60));
        var minutes = Math.floor((distance % (60 * 60)) / (60));
        var seconds = Math.floor((distance % 60));

        // Display the result in the element with id="demo"
        document.getElementById("minute").innerHTML = minutes;
        document.getElementById("second").innerHTML = seconds;
        

        distance--;
        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "زمان شما به پایان رسیده است";
            $("#finish_quiz").trigger('click');
        }
    }, 1000);
</script>
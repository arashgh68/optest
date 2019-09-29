<form action="<?php echo base_url('/admin/quiz/insert') ?>" method="post">

    <div class="form-group row">
        <div class="col-md-3">
            <label class="col-form-label" for="quiz_course">درس</label>
            <select class="form-control" id="quiz_course" required title="درس مربوط به آزمون باید مشخص شده باشد">
                <?php
        foreach($course_list as $Course){
            ?>
                <option value="<?php echo $Course->course_id ?>"><?php echo $Course->description ?></option>
                <?php
        }
        ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="col-form-label" for="quiz[part_id]">بخش</label>
            <select name="quiz[part_id]" class="form-control" id="quiz_part" required
                title="بخش مربوطه را انتخاب نمایید">
            </select>
        </div>


        <div class="col-md-3">
            <label class="col-form-label" for="quiz[title]">نام آزمون</label>
            <input type='text' class="form-control" name='quiz[title]' required title='نام آزمون نباید خالی باشد'>
        </div>

        <div class="col-md-3">
            <label class="col-form-label" for="quiz[time]">زمان آزمون دقیقه</label>
            <input type="number" class="form-control" name="quiz[time]" required title='زمان آزمون نمی تواند خالی باشد'>
        </div>
    </div>


    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="quiz[max_score]">حداکثر نمره</label>
            <input type="number" class="form-control" name="quiz[max_score]" required title='حداکثر نمره برای محاسبه'>
        </div>
        <div class="form-group col-md-3">
            <label for="quiz[question_number]">تعداد سوال</label>
            <input type='number' class="form-control" name='quiz[question_number]' required
                title='تعداد سوال نباید خالی باشد'>
        </div>
        <div class="form-group col-md-3">
            <label>تعداد دفعات شرکت در آزمون</label>
            <input type='number' class="form-control" name='quiz[attempt]' required
                title='حداکثر مجاز امتحان را وارد کنید'>
        </div>
        <div class="form-group col-md-3">
            <label>نمره منفی</label>
            <input type='number' class="form-control" name='quiz[demerit]' required
                title='تعداد غلط ها برای یک نمره منفی را وراد کنید صفر بدون نمره منفی'>
        </div>
    </div>

    <div class="form-row">

        <div class="form-check col-md-3">
            <label>
                <input type='checkbox' name='randomoption'>
                <span class="label-text">نمایش تصادفی گزینه ها در آزمون</span>
            </label>
        </div>
        <div class="form-check col-md-3">
            <label><input type='checkbox' name='randomquestion'> نمایش تصادفی سوال ها در آزمون</label>
        </div>
    </div>
    <hr>
    <div class="row mt-4">
        <div class="col-md-2">
            <label id="questioncount">تعداد </label>
        </div>
        <div class="col-md-8">
            <div class="input-group mb-3">
                <input id="tagquery" type="text" class="form-control search-input" placeholder="براساس برچسب">
                <input id="query" type="text" class="form-control search-input" placeholder="جستجو براساس سوال">
                <button id="search" type="button" class="btn btn-success">جست و جو</button>
            </div>

        </div>
        <div class="col-md-2" style="text-align: left">
            <select class="custom-select mr-sm-2" id="number_to_show" style="max-width: 75px">
                <option value="5">5</option>
                <option selected value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="250">250</option>
                <option value="500">500</option>
            </select>
        </div>
    </div>

    <div class="loader">
        <h4>
            <img src="<?php echo base_url('/image') . '/loading.gif'; ?>" style="vertical-align:middle" /><br />
            در حال بارگذاری
        </h4>
    </div>

    <div id="question_list">

    </div>

    <br>
    <div id="hiddenfield">
        <!-- store th checked question id list -->

    </div>
    <input type="hidden" name="questionchek" id="chekedquestion">
    <input type='submit' name='save' value='ذخیره کردن' class="btn btn-primary">
    <input type="button" name="back" onclick="location.href='<?php echo base_url('admin/quiz') ?>'" value="بازگشت"
        class="btn btn-primary">
</form>


<script>
function load_questionlist(query, pageno, perpage, tagquery) {
    var datas = {};
    datas['pagenum'] = pageno;
    datas['perpage'] = perpage;
    datas['query'] = query;
    datas['tagquery'] = tagquery;
    $.ajax({
        url: "<?php echo base_url('admin/quiz/new_quiz_question_list'); ?>",
        method: "POST",
        data: {
            datas: datas
        },
        beforeSend: function(xhr) {
            $('.loader').show();
        },
        complete: function(xhr, status) {
            $('.loader').hide();
        },
        success: function(data) {
            $('#question_list').html(data);
        }
    })
}

//load_parts for selected course
function load_parts($course_id) {
    var datas = {};
    datas['course_id'] = $course_id;
    $.ajax({
        url: "<?php echo base_url('admin/quiz/get_course_parts'); ?>",
        method: "POST",
        data: {
            datas: datas
        },
        success: function(data) {
            const rep = JSON.parse(data);
            $("#quiz_part").empty();
            $.each(rep, function(index, part) {
                //Use the Option() constructor to create a new HTMLOptionElement.
                var option = new Option(part.title, part.part_id);
                //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                $(option).html(part.title);
                //Append the option to our Select element.
                $("#quiz_part").append(option);
            });




        }
    })
}
//Run the load parts function to refresh the parts
$('#quiz_course').on('change', function(e) {
    load_parts(this.value);

});

//change page number
$('#question_list').on('click', '.pagination >li > a', function(e) {
    e.preventDefault();
    var pageno = 0;
    if ($(this).attr('data-ci-pagination-page') != null)
        pageno = $(this).attr('data-ci-pagination-page');

    $('.page-item active').removeClass("active");

    load_questionlist($('#query').val(), pageno, $('#number_to_show').val(), $('#tagquery').val());
});

// change number of rows to show by changing the drop down
$('#number_to_show').on('change', function(e) {
    load_questionlist($('#query').val(), 0, this.value, $('#tagquery').val());

});
//search buttons
$('#search').click(function() {
    load_questionlist($('#query').val(), 0, $('#number_to_show').val(), $('#tagquery').val());
})
//enter on search input
$('#query').keypress(function(e) {
    if (e.which == 13) { //enter key is 13
        load_questionlist($('#query').val(), 0, $('#number_to_show').val(), $('#tagquery').val());
        return false;
    }
});
$('#tagquery').keypress(function(e) {
    if (e.which == 13) { //enter key is 13
        load_questionlist($('#query').val(), 0, $('#number_to_show').val(), $('#tagquery').val());
        return false;
    }
});

var selected = []; //store list of selected questions
$(document).ready(function() {
    load_parts($('#quiz_course').val());
    load_questionlist($('#query').val(), 0, $('#number_to_show').val(), $('#tagquery').val());


    //select row save
    $('#question_list').on('click', '.bigcheckbox2', function() {

        var id = this.id;
        var index = $.inArray(id, selected);
        if ($(this).prop('checked') === true) {
            selected.push(id);

        } else {
            selected.splice(index, 1);
            //$('#hidv'+id).remove();
        }
        $(this).parent().parent().toggleClass('selectedrow');
        $('#chekedquestion').attr('value', selected);
        $('#questioncount').html('تعداد: ' + selected.length);
        //alert('تعداد سوال: '+selected.length);
    });
})
$(document).ajaxComplete(function() {
    // add popover to tag lists
    $('[data-toggle="popover"]').popover();
    //add sort title to question_list table
    //        $('#question_list').dataTable({searching: false, paging: false, info: false});
    $('#question_data .bigcheckbox2').each(function() {
        console.log('selecetd = ' + selected);
        var id = $(this).attr('id');
        var index = $.inArray(id, selected);
        //  console.log('id = ' + id + 'index= ' + index);

        if (index === -1) //NOt selected item
        {
            $(this).removeAttr('checked');
            $(this).parent().parent().removeClass('selectedrow');
        } else {
            $(this).parent().parent().addClass('selectedrow');
            $(this).attr('checked', 'checked');
        }

    })
});
</script>
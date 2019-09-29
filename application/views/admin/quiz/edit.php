<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 12/4/2018
 * Time: 12:18 AM
 */

?>
<br>

<a href='<?php echo base_url("admin/quiz")?>'>لیست کوییز</a>
<br>
<label class="form-inline">موقعیت کوییز: <h5><?php echo $part_detail ?></h5></label>
<?php
$attributes = array('value' => 'edit');
echo form_open(base_url("admin/quiz/edit/").$quiz_id ,$attributes); ?>
    <div class="container">
        <div class="form-group row">
            <div class="col-md-3">
                <label>نام آزمون <input type='text' name='quiz[title]' required  title='نام آزمون نباید خالی باشد' value="<?php echo $quiz[0]->title ?>"></label>
            </div>
            <div class="col-md-3">
                <label> زمان آزمون دقیقه <input type='number' name='quiz[max_time]' required  title='زمان آزمون نمی تواند خالی باشد' value="<?php echo $quiz[0]->max_time/60 ?>"></label>
            </div>
            <div class="col-md-3">
                <label>تعداد سوال<input type='number' value='<?php echo $quiz[0]->question_number ?>' name='quiz[question_number]' required  title='تعداد سوال نباید خالی باشد'></label>
            </div>
            <div class="col-md-3">
                <label> تعداد شرکت<input type='number' value="<?php echo $quiz[0]->max_attempt ?>" name='quiz[max_attempt]' required  title='حداکثر مجاز امتحان را وارد کنید'></label>
            </div>
        </div>
        <div class="form-group row">
           
            <div class="col-md-3">
                <label><input type='checkbox' name='random_answer' <?php if($quiz[0]->random_answer==true){echo 'checked';} ?> > نمایش تصادفی گزینه ها در آزمون</label>
            </div>
            <div class="col-md-3">
                <label><input type='checkbox' name='random_question' <?php if($quiz[0]->random_question==true){echo 'checked';} ?> > نمایش تصادفی سوال ها در آزمون</label>
            </div>
        </div>
    </div>
</br></br>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <label id="questioncount" >تعداد </label>
        </div>
        <div class="col-md-8">
            <div class="input-group mb-3">
                <input id="tagquery" type="text" class="form-control search-input" placeholder="براساس برچسب">
                <input id="query" type="text" class="form-control search-input" placeholder="جستجو براساس سوال">
                <button id="search" type="button" class="btn btn-success" >جست و جو</button>
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
</div>

        <div class="loader">
            <h4>
                <img src="<?php echo base_url('/image').'/loading.gif';?>" style="vertical-align:middle" /><br />
                در حال بارگذاری
            </h4>
        </div>

        <div id="question_list">

        </div>

    <br>
    <input type="hidden" name="questionchek" id="chekedquestion" value="
            <?php
                $j=0;
            foreach($question as $row) {
                if ($j == 0) {
                    echo $row->question_id;
                } else {
                    echo ',' . $row->question_id;
                }
                $j++;
            }
    ?>
">
    <input type='submit' name='edit' value='ویرایش' class="btn btn-primary">
    <input type='button' onclick="location.href='<?php echo base_url('/admin/quiz')?>'" value='بازگشت' class="btn btn-primary">
</form>
<script>
    function load_questionlist(query,pageno,perpage,tagquery)
    {
        var datas={};
        datas['pagenum']=pageno;
        datas['perpage']=perpage;
        datas['query']=query;
        datas['tagquery']=tagquery;
        $.ajax({
            url: "<?php echo base_url('admin/quiz/new_quiz_question_list'); ?>",
            method: "POST",
            data: {datas:datas},
            beforeSend: function (xhr) {
                $('.loader').show();
            },
            complete: function (xhr, status) {
                $('.loader').hide();
            },
            success: function (data) {
                $('#question_list').html(data);
            }
        })
    }
    //change page number
    $('#question_list').on('click','.pagination >li > a',function(e){
        e.preventDefault();
        var pageno = 0;
        if($(this).attr('data-ci-pagination-page')!=null)
            pageno=$(this).attr('data-ci-pagination-page');

        $('.page-item active').removeClass("active");

        load_questionlist($('#query').val(),pageno,$('#number_to_show').val(),$('#tagquery').val());
    });

    // change number of rows to show by changing the drop down
    $('select').on('change', function(e){
        load_questionlist($('#query').val(),0,this.value,$('#tagquery').val());

    });
    //search buttons
    $('#search').click(function() {
        load_questionlist($('#query').val(),0,$('select').val(),$('#tagquery').val());
    })
    //enter on search input
    $('#query').keypress(function (e) {
        if (e.which == 13) { //enter key is 13
            load_questionlist($('#query').val(),0,$('select').val(),$('#tagquery').val());
            return false;
        }
    });
    $('#tagquery').keypress(function (e) {
        if (e.which == 13) { //enter key is 13
            load_questionlist($('#query').val(),0,$('select').val(),$('#tagquery').val());
            return false;
        }
    });

    var selected = []; //store list of selected questions
    $(document).ready(function () {
        firstload();
        load_questionlist($('#query').val(),0,$('select').val(),$('#tagquery').val());
        //select row save
        $('#question_list').on('click', '.bigcheckbox2', function () {

            var id = this.id;
            var index = $.inArray(id, selected);
            if($(this).prop('checked') === true) {
                selected.push(id);

            }
            else{
                selected.splice( index, 1 );
                //$('#hidv'+id).remove();
            }
            $(this).parent().parent().toggleClass('selectedrow');
            $('#chekedquestion').attr('value',selected);
            $('#questioncount').html('تعداد: '+selected.length);
        } );
        function firstload() {
            var string=$('#chekedquestion').val().trim();
            if(string!=='') {
                selected = string.split(',');
                $('#questioncount').html('تعداد: ' + selected.length);
            }
        }
    })
    $(document).ajaxComplete(function() {
        // add popover to tag lists
        $('[data-toggle="popover"]').popover();
        //add sort title to question_list table
//        $('#question_list').dataTable({searching: false, paging: false, info: false});
        $('#question_data .bigcheckbox2').each(function(){
            console.log('selecetd = '+selected);
            var id=$(this).attr('id');
            var index = $.inArray(id, selected);
            console.log('id = '+id+'index= '+index);

            if(index===-1) //NOt selected item
            {
                $(this).removeAttr('checked');
                $(this).parent().parent().removeClass('selectedrow');
            }
            else
            {
                $(this).parent().parent().addClass('selectedrow');
                $(this).attr('checked','checked');
            }

        })
    });
</script>
<div class="container">
    <div class="form-group">
        <?php
 $attributes = array('value' => 'edit');
 echo form_open('admin/question/edit/'.$id,$attributes); ?>
        <div class="container">
            <div class="row">
                <label>مشخصات سوال</label>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <label>تگ های سوال </label>
                        <input type="text" id="tagname" list="all_tag_list" class="form-control" placeholder=""
                            aria-describedby="button-addon1">
                        <button class="btn btn-info" type="button" id="button-addon1">اضافه کردن</button>
                        <datalist id="all_tag_list">
                            <?php
                         foreach($all_tags as $row)
                         {?>
                            <option value="<?php echo $row->tag_name; ?>"><?php echo $row->tag_name; ?></option>
                            <?php
                         }
                         ?>
                        </datalist>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <label>میزان دشواری </label>
                            </div>
                            <div class="col-md-5" style="text-align: left">
                                <label id="demo">میانه</label>
                            </div>
                        </div>
                        <div class="row">
                            <input type="range" name="question[question_level]" aria-describedby="demo" min="0" max="10"
                                value="<?php echo $query[0]->question_level ?>" class="slider" id="myRange">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3" style="">
                        <label>نوع سوال </label>
                        <select class="custom-select mr-sm-2" name="question[question_type]" id="question_type">
                            <?php $i=0;
                         foreach (question_types as $row)
                         {?>
                            <option value="<?php echo $row ?>"><?php echo question_types_names[$i]; ?></option>
                            <?php
                             $i++;
                         }
                         ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <ul class="list-group-horizontal" id="tag-list">
                    <?php
                     $i=0;
                     foreach($taglist as $tag)
                     {
                         $i++;
                         ?>
                    <button type="button" class="btn btn-light"
                        id="<?php echo $i; ?>"><?php echo $tag->tag_name; ?></button>
                    <input type="hidden" id="htag<?php echo $i ?>" name="taglist[]"
                        value="<?php echo $tag->tag_name; ?>">
                    <?php
                     }
                     ?>
                </ul>
            </div>
        </div>
        </br>



        <div class="table-responsive">
            <div id='editquestion' class="form-group">
                <label>صورت سوال</label>
                <textarea id="editquestion" class="form-control summernote"
                    name="question[text]"><?php echo $query[0]->question; ?></textarea>
            </div>

            <table class="table table-bordered" id="dynamic_field">
                <tr>
                    <td style="width:90%">
                        <textarea class="option_editor" name="options[]"><?php echo $options[0]->answer; ?></textarea>
                    </td>
                    <td style="width:5%">
                        <input type="checkbox" name="options[]" value="g#1#true" class="form-control"
                            <?php if($options[0]->correct==true){ echo "checked";} ?> />
                    </td>
                    <td style="width:5%">
                        <button type="button" name="add" id="add" class="btn btn-success"
                            <?php if($query[0]->question_type>0) echo "disabled"; ?>>+</button>
                    </td>
                </tr>
                <?php
                  $n=count($options); //1st option was shown up there
                  $checkstate='checked';
                  for($i=1;$i<$n;$i++)
                  {
                      if($options[$i]->correct==true)
                      {
                          $checkstate='checked';
                      }
                      else
                      {
                          $checkstate='';
                      }
                  ?>
                <tr id="row<?php echo $i ?>" class="answer_options">
                    <td style="width:90%">
                        <textarea class="option_editor" name="options[]"><?php echo $options[$i]->answer; ?></textarea>
                    </td>
                    <td style="width:5%">
                        <input type="checkbox" value="g#1#true" name="options[]" class="form-control name_list"
                            <?php echo $checkstate ?> />
                    </td>
                    <td style="width:5%">
                        <button type="button" name="remove" id="<?php echo $i ?>"
                            class="btn btn-danger btn_remove">X</button>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <input type="submit" name="edit" class="btn btn-primary" value="ویرایش" />
            <input type="button" name="back" class="btn btn-primary" value="بازگشت"
                onclick="location.href='<?php echo base_url(); ?>admin/question';" />
        </div>
        <?php form_close() ?>

    </div>
</div>
<script>
var i = 1;
$('#add').click(function() {
    add_options_editor(i);
    i++;
});
//add summernote as options
function add_options_editor(id) {
    $('#dynamic_field').append('<tr id="row' + id +
        '" class="answer_options"><td><textarea class="option_editor" name="options[]"></textarea></td><td><input type="checkbox" value="g#1#true" name="options[]" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
        id + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    $('.option_editor').summernote({
        placeholder: 'گزینه',
        toolbar: false
    });
}
$(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
});

//add/remove from tag list
//select question_type on page load
$('#question_type').val(<?php echo $query[0]->question_type;?>);

var id = document.getElementById("tag-list").childElementCount;
id = id / 2;
var text = "";
//enter on tag input
$('#tagname').keypress(function(e) {
    if (e.which == 13) { //enter key is 13
        $("#button-addon1").click()
        return false;
    }
});

//click on button
$('#button-addon1').click(function() {
    id++;
    text = document.getElementById("tagname").value;
    if (text != "") {
        $('#tag-list').append('<button type="button" class="btn btn-light" id="' + id + '">' +
            text + '</button>');
        $('#tag-list').append('<input type="hidden" id="htag' + id + '" name="taglist[]" value="' + text +
            '">');
        document.getElementById("tagname").value = "";
    }
});
$(document).on('click', '.btn-light', function() {
    var bid = $(this).attr("id");
    $('#htag' + bid).remove();
    $(this).remove();
});

$(document).ready(function() {

    //slider menu
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        var value = this.value;
        if (value > 8)
            output.innerHTML = 'بسیار دشوار';
        else if (value > 6)
            output.innerHTML = 'دشوار';
        else if (value > 4)
            output.innerHTML = 'میانه';
        else if (value > 2)
            output.innerHTML = 'آسان';
        else
            output.innerHTML = 'بسیار آسان';
    }
});

//change answer list by changing question type
$('select').on('change', function(e) {
    Change_question_type($('select').val());
});
//change question type
function Change_question_type(question_type) {

    if (question_type == 1) {
        $('#dynamic_field tr').each(function() {
            $("#add").prop("disabled", true);
            //processing this row
            //how to process each cell(table td) where there is checkbox
            if ($(this).attr('class') === 'answer_options') {
                $(this).remove();
            }
        });
    } else if (question_type == 0) //char gozinei
    {
        $("#add").prop("disabled", false);
        for (j = 1; j < 4; j++) {
            add_options_editor(j);
        }
        i = 4;
    }
}

//editor load
$(document).ready(function() {
    $('.summernote').summernote({
        placeholder: 'صورت سوال'
    });
    $('.option_editor').summernote({
        placeholder: 'گزینه',
        toolbar: false
    });

});
</script>
<div class="form-group">
    <form action="insert" method="post">

        <div class="container">
            <div class="row">
                <label>مشخصات سوال</label>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <label>تگ های سوال </label>
                        <input type="text" id="tagname" class="form-control" placeholder="" list="all_tag_list" aria-describedby="button-addon1">
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
                            <div class="col-md-6">
                                <label>میزان دشواری </label>
                            </div>
                            <div class="col-md-6" style="text-align: left">
                                <label id="demo">میانه</label>
                            </div>
                        </div>
                        <div class="row">
                            <input type="range" name="question[question_level]" aria-describedby="demo" min="0" max="10" value="5" class="slider" id="myRange">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3" style="">
                        <label>نوع سوال </label>
                        <select class="custom-select mr-sm-2" name="question[question_type]" id="question_type" >
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
            <div class="row"> <!-- where tags are shown -->
                <ul class="list-group-horizontal" id="tag-list">
                </ul>
            </div>
        </div>
    </br>
            <table class="table table-bordered" id="dynamic_field">
                <tr>
                    <label>صورت سوال</label>
                    <textarea type="text" class="summernote" name="question[text]" placeholder="صورت سوال" required></textarea>
                </tr>
                <tr>
                <label>متن گزینه ها</label>
                </tr>
                <tr>
                    <td style="width:90%">
                        <textarea class="option_editor" name="options[]"></textarea>
                    </td>
                    <td style="width:5%">
                        <input type="checkbox" name="options[]" value="g#1#true" class="form-control"/>
                    </td>
                    <td style="width:5%">
                        <button type="button" name="add" id="add" class="btn btn-success">+</button>
                    </td>
                </tr>

                <?php
                for ($i = 1; $i < 4; $i++) { ?>
                    <tr id="<?php echo 'row' . $i; ?>" class="answer_options">
                        <td style="width:90%">
                            <textarea class="option_editor" name="options[]"></textarea>
                        </td>
                        <td style="width:5%">
                            <input type="checkbox" value="g#1#true" name="options[]" class="form-control name_list"/>
                        </td>
                        <td style="width:5%">
                            <button type="button" name="remove" id="<?php echo $i; ?>"
                                    class="btn btn-danger btn_remove">X
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <input type="submit" name="save" class="btn btn-primary" value="ذخیره کردن"/>
            <input type="button" onclick="location.href='<?php echo base_url() ?>admin/question'"
                   class="btn btn-primary" value="بازگشت"/>
    </form>
</div>

<script>
    var i = 1;
    $('#add').click(function () {
        add_options_editor(i);
        i++;
    });
    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    var id=0;
    var text="";

    // click on add tag button
    $('#button-addon1').click(function () {
        id++;
        text=document.getElementById("tagname").value;
        if(text!="") {
            $('#tag-list').append('<button type="button" class="btn btn-light" id="' + id + '">' +
                text + '</button>');
            $('#tag-list').append('<input type="hidden" id="htag' + id + '" name="taglist[]" value="' + text + '">');
            document.getElementById("tagname").value = "";
        }
    });
    //click to remove tag
    $(document).on('click', '.btn-light', function () {
        var bid=$(this).attr("id");
        $('#htag'+bid).remove();
        $(this).remove();
    });

    //add tag by enter
    $('#tagname').keypress(function (e) {
        if (e.which == 13) { //enter key is 13
            $("#button-addon1").click()
            return false;
        }
    });

    $(document).ready(function () {
        //add/remove from tag list

        //slider menu
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");

        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function() {
            var value=this.value;
            if(value>8)
                output.innerHTML = 'بسیار دشوار';
            else if(value>6)
                output.innerHTML = 'دشوار';
            else if(value>4)
                output.innerHTML = 'میانه';
            else if(value>2)
                output.innerHTML = 'آسان';
            else
                output.innerHTML = 'بسیار آسان';
        }
    });

    //change answer list by changing question type
    $('select').on('change', function(e){
        Change_question_type($('select').val());
    });

    //changes question_type when it is changed
    function Change_question_type(question_type) {

        if (question_type == 1) { //chahar gozine
            $('#dynamic_field tr').each(function () {
                $( "#add" ).prop( "disabled", true );
                //processing this row
                //how to process each cell(table td) where there is checkbox
                if($(this).attr('class')==='answer_options')
                {
                    $(this).remove();
                }
            });
        }
        else if(question_type == 0)
        {
            $( "#add" ).prop( "disabled", false );
            for(j=1;j<4;j++)
            {
                add_options_editor(j);
            }
            i=4;
        }
    }

    //add summernote as options
    function add_options_editor(id)
    {
        $('#dynamic_field').append('<tr id="row' + id + '" class="answer_options"><td><textarea class="option_editor" name="options[]"></textarea></td><td><input type="checkbox" value="g#1#true" name="options[]" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + id + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        $('.option_editor').summernote({
            placeholder: 'گزینه',
            toolbar: false
        });
    }

    $(document).ready(function () {
        $('.summernote').summernote({
            placeholder: 'صورت سوال'
        });
        $('.option_editor').summernote({
            placeholder: 'گزینه',
            toolbar: false
        });

    });


</script>
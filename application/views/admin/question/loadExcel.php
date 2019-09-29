<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 1/24/2019
 * Time: 11:24 PM
 */
?>
<div class="loader" id="loading">
    <h4>
        <img src="<?php echo base_url('/image').'/loading.gif';?>" style="vertical-align:middle" /><br />
        در حال بارگذاری
    </h4>
</div>
<div class="loader" id="saveloader">
    <h4>
        <img src="<?php echo base_url('/image').'/loading.gif';?>" style="vertical-align:middle" /><br />
        در حال ذخیره کردن در بانک اطلاعاتی
    </h4>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <h5>تعدادی از سوالات فایل اکسل نمایش داده شده است. در صورت اطمینان کلید ورود را بزنید تا اطلاعات ثبت نهایی شوند</h5>
        </div>
        <div class="col-md-2" style="text-align: left">
            <button id="save_button" class="btn btn-primary edit">ثبت نهایی</button>
        </div>
    </div>
    <div class="row" id="question_list">

    </div>
</div>
<script>
    //loads the excel file
    var filename="<?php echo $filename; ?>";
    load_data(filename,100);
    function load_data(filename,NoItemToShow) {
        var datas={};
        datas['filename']=filename;
        datas['NoItemShow']=NoItemToShow;
        $.ajax({
            url: "<?php echo base_url('admin/question/load_excel/'); ?>",
            method: "POST",
            data: {datas:datas},
            beforeSend: function (xhr) {
                $('#loading').show();
            },
            complete: function (xhr, status) {
                $('#loading').hide();
            },
            success: function (data) {
                $('#question_list').html(data);
            }
        })
    }

    function save_excel(filename)
    {
        var datas={};
        datas['filename']=filename;
        $.ajax({
            url: "<?php echo base_url('admin/question/saveexcel/'); ?>",
            method: "POST",
            data: {datas:datas},
            beforeSend: function (xhr) {
                $('#saveloader').show();
            },
            complete: function (xhr, status) {
                $('#saveloader').hide();
            },
            success: function (data) {
                alert('تمام مقادیر در بانک اطاعاتی ذخیره شد');
                window.location = "<?php echo base_url('admin/question'); ?>";
            }
        })
    }
    $('#save_button').click(function() {
        save_excel(filename);
    })
</script>
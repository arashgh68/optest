<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h5>کاربر: <?php echo $Userfullname;?></h5>
            <br>
        </div>
        <div class="col-md-6"><!-- search box
            <div class="input-group mb-3">
                <input id="query" type="text" class="form-control search-input">
                <button id="search" class="btn btn-success">جست و جو</button>
            </div>-->
        </div>
        <div class="col-md-3" style="text-align: left">
            <select class="custom-select mr-sm-2" id="number_to_show" style="max-width: 75px">
                <option selected value="5">5</option>
                <option value="10">10</option>
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
<div id="user_quiz_list">

</div>

<script type="text/javascript">

    function load_data(userid, pageno, perpage) {
        var datas={};
        datas['pagenum']=pageno;
        datas['perpage']=perpage;
        datas['user_id']=userid;
        $.ajax({
            url: "<?php echo base_url('admin/user/User_quiz_list'); ?>",
            method: "POST",
            data: {datas:datas},
            beforeSend: function (xhr) {
                $('.loader').show();
            },
            complete: function (xhr, status) {
                $('.loader').hide();
            },
            success: function (data) {
                $('#user_quiz_list').html(data);
            }
        })
    }

    $(document).ready(function () {
        load_data(<?php echo  $user_id ?>,0,$('select').val());
    });

    // change number of rows to show by changing the drop down
    $('select').on('change', function(e){
        load_data(<?php echo  $user_id ?>,0,this.value);
    });
    //search button
    $('#search').click(function() {
        load_data(<?php echo  $user_id ?>,0,$('select').val());
    })
    //enter on search input
    $('#query').keypress(function (e) {
        if (e.which == 13) { //enter key is 13
            load_data(<?php echo  $user_id ?>,0,$('select').val());
            return false;
        }
    });

    $('#user_quiz_list').on('click','.pagination >li > a',function(e){
        e.preventDefault();
        var pageno = 0;
        if($(this).attr('data-ci-pagination-page')!=null)
            pageno=$(this).attr('data-ci-pagination-page');
        //$('.page-item active').removeClass("active");
        load_data(<?php echo  $user_id ?>,pageno,$('#number_to_show').val());
    });
    //add sorting to table
    $(document).ajaxComplete(function() {
        // add popover to tag lists
        $('[data-toggle="popover"]').popover();
        //add sort title to question_list table
        $('#user_quiz_data').dataTable({searching: false, paging: false, info: false});
    });

</script>
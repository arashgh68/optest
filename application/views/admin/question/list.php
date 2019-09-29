<div>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo $new_question_link.'/1' ?>">چند سوال جدید</a>
                /
                <a href="<?php echo $new_question_link ?>">سوال جدید</a>
                </br>
                <a href="<?php echo $excel_import_link ?>">ورود سوالات از اکسل</a>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                     <input id="query" type="text" class="form-control search-input">
                    <button id="search" class="btn btn-success">جست و جو</button>
                </div>
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
</div>
    <!-- Example single danger button -->


<div class="loader">
    <h4>
        <img src="<?php echo base_url('/image').'/loading.gif';?>" style="vertical-align:middle" /><br />
        در حال بارگذاری
    </h4>
</div>

<div id="question_list">

</div>

<script type="text/javascript">

    //load the datatable
    function load_data(query, pageno, perpage) {
        var datas={};
        datas['pagenum']=pageno;
        datas['perpage']=perpage;
        datas['query']=query;
        $.ajax({
            url: "<?php echo base_url('admin/question/loadquestion/'); ?>",
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

    // change number of rows to show by changing the drop down
    $('select').on('change', function(e){
        load_data($('#query').val(),0,this.value);
    });
    //search button
    $('#search').click(function() {
        load_data($('#query').val(),0,$('select').val());
    })
    //enter on search input
    $('#query').keypress(function (e) {
        if (e.which == 13) { //enter key is 13
            load_data($('#query').val(),0,$('select').val());
            return false;
        }
    });

    $('#question_list').on('click','.pagination >li > a',function(e){
        e.preventDefault();
        var pageno = 0;
        if($(this).attr('data-ci-pagination-page')!=null)
            pageno=$(this).attr('data-ci-pagination-page');

        $('.page-item active').removeClass("active");

        load_data($('#query').val(),pageno,$('#number_to_show').val());
    });


    $(document).ready(function() {
        load_data("", 0, 5);
    });

    var url="<?php echo base_url('admin/question/delete/');?>";

    $("#question_list").on('click','.remove',function(){
    var qid = $(this).parents("tr").attr("id");
    if(confirm('از حذف این سوال اطمینان دارید؟'))
    {
        $.ajax({
            url: url+qid,
            type: 'DELETE',
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
                alert('Something is wrong');
            },
            success: function(result) {
                if(result)
                {
                    $("#"+qid).remove();
                    load_data($('#query').val(),0,$('select').val());
                    alert("با موفقیت حذف گردید");
                }
                else
                {
                    alert('این سوال غیر قابل حذف می باشد');
                }
            }
        });
    }
});

//tags buttons popover
$(document).ajaxComplete(function() {
    // add popover to tag lists
    $('[data-toggle="popover"]').popover();
    //add sort title to question_list table
    $('#question_data').dataTable({searching: false, paging: false, info: false});
});

</script>


<form action="<?php echo base_url('admin/course/newcourse'); ?>" method="post">
    <div class='container'>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group row">
                    <label class='col-md-3' for="course_title">عنوان درس</label>
                    <div class="col-md-9">
                        <input type="text" id="course_title" class="form-control" placeholder="عنوان درس"
                            name="course[title]" required title='عنوان نمی تواند خالی باشد'>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group row">
                    <label class='col-md-2' for="course_description">توصیف درس</label>
                    <div class="col-md-10">
                        <textarea type="text" class="summernote" name="course[description]"
                            placeholder="توصبف درس"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="submit" name="save" class="btn btn-primary" value="ذخیره کردن" />
    <input type="button" onclick="location.href='<?php echo base_url(); ?>admin/course'" class="btn btn-primary"
        value="بازگشت" />
</form>
</div>

<script>
$(document).ready(function() {
    $('.summernote').summernote({
        placeholder: 'توصیف درس'
    });
});
</script>
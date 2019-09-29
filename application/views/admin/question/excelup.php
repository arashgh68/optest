<h3>ورود سوالات از Excel</h3>
<?php echo form_open_multipart(base_url('admin/question/DoUpExcel'));?>

<div class="custom-file" style="text-align: left">
    <input type="file" class="custom-file-input" name="userfile" id="ExcelFile">
    <label class="custom-file-label" for="ExcelFile">فایل اکسل را انتخاب کنید</label>
</div>
</br>
</br>
<input type="submit" value="upload" class="btn btn-primary"/>
</form>

<script>
    $('#ExcelFile').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>
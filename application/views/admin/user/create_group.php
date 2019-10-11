<form action="<?php echo base_url('/admin/user/save_users') ?>" method="post">
<div class="mb-4 text-left">    
    <button type="button" class="btn btn-outline-secondary" onclick="addUser()">کاربر جدید</button>
    <button type="submit" class="btn btn-success">ذخیره</button>
    
</div>
    <table id="user_quiz_data" class="table table-striped table-bordered" style="text-align:right">
        <thead>
            <tr>
                <th></th>
                <th>
                    نام
                </th>
                <th>
                    نام خانوادگی
                </th>
                <th>
                    نام کاربری
                </th>
                <th>
                    کلمه عبور
                </th>
            </tr>
        </thead>
        <tbody id="users">
            <tr>
                <td>
                    1
                </td>
                <td>
                    <input type="text" name="firstName[]" class="form-control">
                </td>
                <td>
                    <input type="text" name="lastName[]" class="form-control">
                </td>
                <td>
                    <input type="text" name="userName[]" class="form-control">
                </td>
                <td>
                    <input type="text" name="password[]" class="form-control">
                </td>
            </tr>
        </tbody>
    </table>
    
</form>


<script>
    var i = 1;

    function addUser() {
        i++;
        $('#users').append('<tr><td>' + i + '</td></td><td><input type="text" name="firstName[]" class="form-control"></td><td><input type="text" name="lastName[]" class="form-control"></td><td>            <input type="text" name="userName[]" class="form-control">        </td>        <td>            <input type="text" name="password[]" class="form-control">        </td>    </tr>    ');
    }
</script>
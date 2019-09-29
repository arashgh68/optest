<div>
    <div>
        <a href='<?php echo base_url("admin/course/newcourse")?>'>ایجاد درس</a>
        <br>
        <a href='<?php echo base_url("admin/course/parts")?>'>بخش ها</a>
    </div>
    <div class="container">
        <table id="course_list" class="table table-bordered" style="text-align:right">
            <thead>
                <tr id="0">
                    <th class="sorting" scope="col">#</th>
                    <th class="sorting" scope="col">عنوان</th>
                    <th class="sorting" scope="col">توضیح</th>
                    <th class="sorting" scope="col">تعداد کاربر فعال</th>
                    <th class="sorting" scope="col">عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php
    $i=1; 
    foreach($course_list as $course){?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $course->title?></td>
                    <td><?php echo $course->description ?></td>
                    <td><?php echo $user_count[$i-1] ?></td>
                    <td>
                        <div class="form-inline">
                            <button
                                onclick="location.href='<?php echo base_url('admin/course/parts/'.$course->course_id) ?>'"
                                class="btn btn-warning btn-xs">بخش‏‏ ها</button>
                            <button
                                onclick="location.href='<?php echo base_url('admin/course/edit_course/'.$course->course_id) ?>'"
                                class="btn btn-secondary btn-xs">ویرایش</button>
                            <button
                                onclick="location.href='<?php echo base_url('admin/course/delcourse/'.$course->course_id) ?>'"
                                class="btn btn-danger btn-xs">x</span></button>
                        </div>
                    </td>
                </tr>
                <?php
    $i++;
    }
    ?>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
    $('.del_course').click(function(e) {

        if (confirm('از حذف این درس اطمینان دارید؟')) {
            alert('yes');
        } else {
            alert('no');
        }
    });
    </script>
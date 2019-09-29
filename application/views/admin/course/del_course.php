<div>
<h5><?php echo $course_data[0]->title ?></h5>
    <div class="container">
        <?php 
    if(empty($part_list)){
        ?>
        <form action="<?php echo base_url('admin/course/delcourse/'.$course_id); ?>" method="post">
        <p>از حذف درس اطمینان دارید؟</p>
            <input type="submit" name="delete" class="btn btn-danger" value="حذف" />
            <input type="button" onclick="location.href='<?php echo base_url(); ?>admin/course'" class="btn btn-primary"
                value="بازگشت" />
        </form>
        <?php
    }else {
        ?>
        <p>این درس دارای بخش هایی بوده و قابل حذف نمی باشد. (ابتدا باید بخش های درس حذف شوند)</p>
        <label for="course_list">بخش ها</label>
        <table id="course_list" class="table table-bordered" style="text-align:right">
            <thead>
                <tr id="0">
                    <th class="sorting" scope="col">#</th>
                    <th class="sorting" scope="col">عنوان</th>
                    <th class="sorting" scoppe="col">درس</th>
                    <th class="sorting" scope="col">توصیف</th>
                    <th class="sorting" scoppe="col">تعداد آزمون</th>
                </tr>
            </thead>
            <tbody>
                <?php
    $i = 1;
    foreach ($part_list as $part) {
        ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $part->title; ?></td>
                    <td><?php echo $part->course_title; ?></td>
                    <td><?php echo $part->description; ?></td>
                    <td><?php echo $quiz_count[$i-1]; ?></td>
                </tr>
                <?php
    ++$i;
    }
    ?>
            </tbody>
        </table>
        <?php 
    }
   ?>
    </div>
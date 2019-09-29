<div>
    <div>
        <a href='<?php echo base_url('admin/course/newpart'); ?>'>ایجاد بخش</a>
    </div>
    <div class="container">
        <table id="course_list" class="table table-bordered" style="text-align:right">
            <thead>
                <tr id="0">
                    <th class="sorting" scope="col">#</th>
                    <th class="sorting" scope="col">عنوان</th>
                    <th class="sorting" scoppe="col">درس</th>
                    <th class="sorting" scope="col">توصیف</th>
                    <th class="sorting" scoppe="col">تعداد آزمون</th>
                    <th class="sorting" scope="col">عملیات</th>
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
                    <td>
                       
                    </td>
                </tr>
                <?php
    ++$i;
    }
    ?>
            </tbody>
        </table>
    </div>
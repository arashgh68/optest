<div class="row mb-4">
    <div class="col-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5><?php echo $part->title ?></h5>

                <ul class="list-unstyled">
                    <li><a href="<?php echo base_url("/course/part/" . $part->part_id) ?>">خلاصه وضعیت</a></li>
                    <li><a href="">پرسش و پاسخ</a></li>
                    <li><a href="<?php echo base_url("/course/part/" . $part->part_id . "/resource") ?>">منابع</a></li>
                    <li><a href="<?php echo base_url("/course/part/" . $part->part_id . "/quiz") ?>">آزمون ها</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <p><?php echo $part->description ?></p>
            </div>
        </div>
    </div>
</div>
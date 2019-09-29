<ul class="nav flex-column nav-pills">
    <li class="nav-item">
        <a class="nav-link <?php echo uri_string() == 'user' || uri_string() == 'user/index' ? 'active' : null ?>"
           href="<?php echo base_url('user') ?>">اطلاعات کاربری</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo uri_string() == 'user/quizzes' ? 'active' : null ?>"
           href="<?php echo base_url('user/quizzes') ?>">لیست آزمون ها</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('auth/change_password') ?>">تغییر کلمه عبور</a>
    </li>
</ul>
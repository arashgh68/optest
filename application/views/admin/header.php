<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" type="text/css" />


    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-admin.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.css" type="text/css" />

    <?php foreach ($styles as $style){
        echo $style;
    } ?>

    <!-- temporary, must move to footer -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

    <title><?php echo $page_title ?></title>
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">مدیریت</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="<?php echo base_url('auth/logout') ?>">خروج</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu == 'dashboard'?'active':null ?>"
                                href="<?php echo base_url('admin') ?>">
                                <i class="fas fa-bars"></i>
                                پیشخوان <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu == 'quiz'?'active':null ?>"
                                href="<?php echo base_url('admin/quiz') ?>">
                                <i class="fas fa-list"></i>
                                آزمون
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu == 'question'?'active':null ?>"
                                href="<?php echo base_url('admin/question') ?>">
                                <i class="fas fa-question"></i>
                                سوال
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu == 'course'?'active':null ?>"
                                href="<?php echo base_url('admin/course') ?>">
                                <i class="fas fa-book"></i>
                                درس
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $active_menu == 'user'?'active':null ?>"
                                href="<?php echo base_url('admin/user') ?>">
                                <i class="fas fa-user"></i>
                                کاربر
                            </a>
                        </li>
                    </ul>

                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="d-flex align-items-center text-muted" href="#">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>

                </div>
            </nav>
            <main role="main" class="col-md-9 mr-sm-auto col-lg-10 px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $page_title ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">


                    </div>
                </div>
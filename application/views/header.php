<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">

    <title></title>
</head>

<body>
    <header class="py-3 shadow-sm">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>image/logo.png" class="img-fluid" width="60px" alt=""></a>
                </div>

                <div class="col-sm-4 align-items-center d-flex">
                    <form action="<?php echo base_url('home/search'); ?>" class="w-100">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control border-0" placeholder="چی می خوای یاد بگیری؟">
                        
                        </div>
                    </form>
                </div>

                <div class="col-sm-5 d-flex align-items-center justify-content-end">
                    <?php if ($this->ion_auth->logged_in()) { ?>
                    <ul class="navbar-nav d-none d-md-flex">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0 text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle fa-2x fa-fw"></i>
                                <span class="mb-0 text-sm"><?php echo $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left text-right">
                                <div class=" dropdown-header noti-title">
                                    <span class="text-overflow m-0">خوش آمدید!</span>
                                </div>
                                <a class="dropdown-item" href="<?php echo base_url('user') ?>">
                                    <i class="fas fa-user"></i>
                                    <span class="text-sm">حساب کاربری</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="text-sm">خروج</span></a>
                            </div>
                        </li>
                    </ul>
                    <?php } else { ?>
                    <a href="<?php echo base_url('auth/login') ?>" class="btn btn-link"><i class="fas fa-sign-in-alt"></i> ورود</a>
                    <a href="<?php echo base_url('auth/registeruser') ?>"><i class="fas fa-user-plus"></i> ثبت نام</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>
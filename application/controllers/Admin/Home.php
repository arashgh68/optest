<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends TA_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->data['active_menu'] = "dashboard";
        $this->verify_auth();
    }

    public function index()
    {
        $this->data['page_title'] = "مدیریت - پیشخوان";
        $this->render('home');
    }
}
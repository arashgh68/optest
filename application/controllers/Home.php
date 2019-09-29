<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends TA_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        //set title
        $this->data['page_title'] = 'خوش آمدید';
        
        $this->load->model('Course_model');

        $courses = $this->Course_model->get_courses(3);

        $registered_courses = array();
        if ($this->ion_auth->logged_in()) {
            $registered_courses = $this->Course_model->get_registered_course($this->user_id);
        }

        foreach ($courses as $course) {
            $course->registered = false;
            foreach ($registered_courses as $rc) {
                if ($course->course_id == $rc->course_id) {
                    $course->registered = true;
                }
            }
        }

        $this->data['courses'] = $courses;
        

        //core controller auto load data and header footer for view
        $this->render('home');
    }

    public function comment()
    {
        echo 'logged in babae';
    }

    public function search($q = null)
    {

        if(!$q){
            $q = $this->input->get('q');
        }

        $this->load->model('Course_model');

        $courses = $this->Course_model->get_search_course($q);

        $registered_courses = array();
        if ($this->ion_auth->logged_in()) {
            $registered_courses = $this->Course_model->get_registered_course($this->user_id);
        }

        foreach ($courses as $course) {
            $course->registered = false;
            foreach ($registered_courses as $rc) {
                if ($course->course_id == $rc->course_id) {
                    $course->registered = true;
                }
            }
        }

        $this->data['courses'] = $courses;
        

        //core controller auto load data and header footer for view
        $this->render('search');
    }

    public function login90()
    {

        $this->load->library('ion_auth');
        $remember = TRUE; // remember the user
        $done = false;
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $this->load->database();
        $done = $this->ion_auth->login($username, $password, $remember);
        if (!$this->ion_auth->logged_in()) {
            //	$this->load->view('login.php');


            echo '<script language="javascript">';
            echo 'alert("echo $done")';
            echo '</script>';
        }
        echo $done;
    }
}

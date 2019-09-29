<?php

/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/6/2018
 * Time: 11:15 PM
 */

class User extends TA_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->data['menu'] = $this->load->view('user/menu', '', true);
    }
    public function index()
    {
        $this->verify_auth();

        $this->data['page_title'] = "کاربر";
        $this->data['user'] = $this->user;

        $quizzes = $this->User_model->get_quizzes_taked($this->user_id);

        $active_quiz = null;
        if ($this->session->has_userdata('user_quiz_id')) {

            foreach ($quizzes as $quiz) {
                if ($quiz->user_quiz_id == $this->session->user_quiz_id) {
                    $active_quiz = $quiz;
                }
            }
        }

        $this->data['courses'] = $this->User_model->get_courses($this->user_id, 3);

        $this->data['active_quiz'] = $active_quiz;
        $this->data['last_quiz'] = null;
        if ($quizzes) {
            $this->data['last_quiz'] = $quizzes[count($quizzes) - 1];
        }

        $this->renderPanel('user/index');
    }

    public function quiz()
    {
        $this->verify_auth();
        $this->load->library('jalaliDate');
        $this->data['user'] = $this->user;
        $this->data['page_title'] = "کاربر";
        $quizzes = $this->User_model->get_quizzes($this->user_id);

        foreach ($quizzes as $quiz) {
            $quiz->time_elapsed = gmdate("H:i:s", strtotime($quiz->quiz_end) - strtotime($quiz->quiz_start));
            $quiz->quiz_date = $this->jalalidate->jdate('Y/m/d', strtotime($quiz->quiz_start));
        }

        $this->data['quizzes'] = $quizzes;

        $this->renderPanel('user/quizzes');
    }


    public function info()
    {
        $this->verify_auth();
        $this->data['user'] = $this->user;
        $this->data['page_title'] = "کاربر";


        $this->renderPanel('user/info');
    }

    public function course()
    {
        $this->verify_auth();

        $this->data['page_title'] = "کاربر";
        $this->data['user'] = $this->user;
        $this->data['courses'] = $this->User_model->get_courses($this->user_id);

        $this->renderPanel('user/courses');
    }
}

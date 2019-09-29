<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends TA_Controller
{
    public function index($course_id = null)
    {
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        if (isset($course_id)) {
            $parts = $this->Course_model->get_parts($course_id);
            $course = $this->Course_model->get_course($course_id);
            $quizzes = $this->Course_model->get_course_quiz($course_id);


            $this->data["take_quiz"] = false;
            if ($this->ion_auth->logged_in()) {
                $this->data["take_quiz"] = true;
            }

            $this->data['page_title'] = $course->title;
            $this->data['parts'] = $parts;
            $this->data['course'] = $course;
            $this->data['quizzes'] = $quizzes;

            $this->renderPanel('course/course');
        } else {
            $registered_courses = array();
            if ($this->ion_auth->logged_in()) {
                $registered_courses = $this->Course_model->get_registered_course($this->user_id);
            }
            $categories = $this->Category_model->get_categories();
            $courses = $this->Course_model->get_courses();

            foreach ($courses as $course) {
                $course->registered = false;
                foreach ($registered_courses as $rc) {
                    if ($course->course_id == $rc->course_id) {
                        $course->registered = true;
                    }
                }
            }

            $this->data['page_title'] = "درس ها";
            $this->data['courses'] = $courses;
            $this->data['categories'] = $categories;

            $this->render('course/index');
        }
    }

    public function part($part_id, $select = null)
    {
        $this->load->model('Course_model');

        $part = $this->Course_model->get_part($part_id);

        $this->data['page_title'] = $part->title;
        $this->data['part'] = $part;

        if (!isset($select)) {
            $this->render('course/part');
        } elseif ($select = "quiz") {
            $this->data["take_quiz"] = false;
            if ($this->ion_auth->logged_in()) {
                $this->data["take_quiz"] = true;
            }
            $this->data["quizzes"] = $this->Course_model->get_part_quiz($part_id);
            $this->render('course/partQuiz');
        }
    }

    public function register($course_id)
    {
        $this->verify_auth();
        $this->load->model('Course_model');

        $insert_id = $this->Course_model->register_course($course_id, $this->user_id);

        redirect('course');
    }
}

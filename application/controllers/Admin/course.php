<?php

defined('BASEPATH') or exit('No direct script access allowed');

class course extends TA_Admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/course_model', 'course_model');
        $this->data['active_menu'] = 'course';
        $this->verify_auth();
    }

    public function index()
    {
        $this->data['page_title'] = 'درس ها';
        $courses = $this->course_model->get_courses();
        $this->data['course_list'] = $courses;
        $user_count = array();
        foreach ($courses as $course) {
            array_push($user_count, $this->course_model->get_course_user_count($course->course_id));
        }
        $this->data['user_count'] = $user_count;
        $this->render('course/list');
    }

    //new course
    public function newcourse()
    {
        if ($this->input->post('save')) { //this means that user pressed the save button
            $course_data = $this->input->post('course');
            $this->course_model->save_course($course_data);
            redirect('admin/course');
        } else {
            $this->data['page_title'] = 'درس جدید';

            $this->data['styles'][] = '<link href="'.base_url('assets/summernote/summernote-lite.css').'" rel="stylesheet" type="text/css" />';

            $this->data['scripts'][] = '<script src="'.base_url('assets/summernote/summernote-lite.min.js').'"></script>';

            $this->render('course/new');
        }
    }

    //edit course
    public function edit_course($course_id)
    {
        if ($this->input->post('save')) { //this means that user pressed the save button
            $course_data = $this->input->post('course');
            $this->course_model->update_course($course_data, $course_id);
            redirect('admin/course');
        } else {
            $this->data['course_id'] = $course_id;
            $this->data['course_data'] = $this->course_model->get_course($course_id);
            $this->data['page_title'] = 'ویرایش درس';

            $this->data['styles'][] = '<link href="'.base_url('assets/summernote/summernote-lite.css').'" rel="stylesheet" type="text/css" />';

            $this->data['scripts'][] = '<script src="'.base_url('assets/summernote/summernote-lite.min.js').'"></script>';

            $this->render('course/edit_course');
        }
    }

    //parts controller part
    //Parts list
    public function parts($course_id = null)
    {
        $this->data['page_title'] = 'بخش ها';
        $parts = $this->course_model->get_parts($course_id);
        $this->data['part_list'] = $parts;
        $quiz_count = array();
        foreach ($parts as $part) {
            array_push($quiz_count, $this->course_model->get_part_quiz_count($part->part_id));
        }
        $this->data['quiz_count'] = $quiz_count;
        $this->render('course/part_list');
    }

    //delete a course
    public function delcourse($course_id)
    {
        if ($this->input->post('delete')) { //this means that user pressed the save button
            $this->course_model->delete_course($course_id);
            redirect('admin/course');
        } else {
            $this->data['course_id'] = $course_id;
            $course_data = $this->course_model->get_course($course_id);
            $this->data['course_data'] = $course_data;
            if (empty($course_data)) {
                redirect('admin/course');
            }
            $this->data['page_title'] = 'حذف درس';
            $parts = $this->course_model->get_parts($course_id);
            $this->data['part_list'] = $parts;
            $quiz_count = array();
            foreach ($parts as $part) {
                array_push($quiz_count, $this->course_model->get_part_quiz_count($part->part_id));
            }
            $this->data['quiz_count'] = $quiz_count;

            $this->render('course/del_course');
        }
    }
}

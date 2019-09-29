<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  quiz_manager_model
 */
class Quiz extends TA_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/quiz_manager_model', 'quiz_manager_model');
        $this->load->model('admin/Question_model', 'Question_model');
        $this->load->model('admin/course_model', 'course_model');
        $this->data['active_menu'] = 'quiz';
        $this->verify_auth();
    }

    public function new_quiz_question_list() //ajax controller for new/edit question list
    {
        //load My_site_helper
        $this->load->helper('MY_Site_Helper');
        $this->load->library("pagination");
        //pagination
        $data = $this->input->post('datas');
        $perpage=$data['perpage'];
        $pagenum=$data['pagenum'];
        $query=$data['query'];
        $tagquery=$data['tagquery'];

        //sets th current active page
        $config = array();
        $config["cur_page"] = $pagenum;
        $config['base_url']=base_url('admin/quiz/new_quiz_question_list');
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = true;

        $page=0;
        // Row position
        if($pagenum != 0){
            $page = ($pagenum-1) * $config['per_page'];
        }

        //get question list from model
        if($tagquery!=null) {
            $search_result = $this->Question_model->fetch_searched_questions_with_tagsearch($config["per_page"], $page, $query, $tagquery);
            $config["total_rows"] = $this->Question_model->question_count_with_tag($query, $tagquery);
        }
        else
        {

            $search_result = $this->Question_model->fetch_searched_questions($config["per_page"], $page, $query, $tagquery);
            $config["total_rows"] = $this->Question_model->question_count($query, $tagquery);
        }

        $this->pagination->initialize($config);

        $output='<table id="question_data" class="table table-bordered" style="text-align:right">
        <thead>
            <tr id="0">
                <th scope="col">انتخاب</th>
                <th class="sorting" scope="col">#</th>
                <th class="sorting" scope="col">نوع</th>
                <th class="sorting" scope="col">سطح سوال</th>
                <th class="sorting" scope="col">متن سوال (برای جزییات کلیک کنید)</th>
                <th scope="col">برچسب</th>
            </tr>
        </thead>';


        //get all tags and answers to show in question list
        foreach ($search_result as $question) {
            $loaded_tag[$question->question_id] =
                $this->tag_model->get_tags($question->question_id, question_tag_parent);
            $loaded_answer[$question->question_id]=
                $this->Question_model->getanswerlist($question->question_id);
        }
        $i=1;
        foreach($search_result as $row)
        {
            $output.='<tbody>';
            $output.='<tr id="'.$row->question_id.'">';

            $output.='<td><input class="bigcheckbox2" id=\''.$row->question_id.'\' value=\''.$row->question_id.'\' name="questionchek[]" type="checkbox"></td>';
            $output.='<td><a class="fa fa-point" aria-hidden="true">'.$i.'</a></td>';

            $output.='<td>'.question_types_names[$row->question_type].'</td>';
            $output.='<td>'.question_level_indicator($row->question_level).'</td>';
            $output.='<td class="clickable" data-toggle="collapse" data-target="#questionrow'.$i.'" aria-expanded="false" aria-controls="questionrow'.$i.'">'.$row->question.'</td>';
            $output.='<td>';
            $alltag='';
            $fourtag='';
            $j=1;
            foreach($loaded_tag[$row->question_id] as $tag)
            {
                if($alltag!='')
                    $alltag.='-'.$tag->tag_name;
                else
                    $alltag.=$tag->tag_name;
                if($j<4)
                {
                    if($fourtag!='')
                        $fourtag.=' - '.$tag->tag_name;
                    else
                        $fourtag.=$tag->tag_name;
                }
                $j++;

            }
            if($fourtag!='')
                $output.='<a tabindex="0" class="btn btn-sm btn-light" data-placement="top" role="button" data-toggle="popover" data-trigger="focus" title="برچسب های سوال" data-content="'.$alltag.'">'.$fourtag.'</a>';
            $output.='</td>';


            $output.='</tr>';

            $output.='</tbody>';
            $output.='<tbody id="questionrow'.$i.'" class="collapse" style="color:#007bff;background-color:#fbe1dc">';
            //collapse row detail
            $output.='<tr><td  colspan=7>';
            $output.='پاسخ سوال'.'</br>';
            $j=1;
            foreach($loaded_answer[$row->question_id] as $answer)
            {
                $output.='پاسخ'.'&nbsp'.$j.'&nbsp:&nbsp';
                $output.=$answer->answer;
                if($answer->correct)
                {
                    $output.=' (صحیح)';
                }
                $output.='</br>';
                $j++;
            }
            $output.='</td></tr>';
            $output.='</tbody>';
            $i++;
        }
        $output.='</table>';

        //pagination
        $output.=$this->pagination->create_links();
        echo $output;
    }

    //ajax controller for loading quiz table
    public function load_quiz()
    {
        $data = $this->input->post('datas');
        $perpage = $data['perpage'];
        $pagenum = $data['pagenum'];
        $query = $data['query'];

        //pagination
        $this->load->library('pagination');
        $config = array();
        $config['cur_page'] = $pagenum;
        $config['base_url'] = base_url() . 'admin/quiz/load_quiz';
        $config['total_rows'] = $this->quiz_manager_model->quiz_count($query);
        $config['per_page'] = $perpage;
        $config['use_page_numbers'] = true;
        $this->pagination->initialize($config);
        $page = 0;
        // Row position
        if ($pagenum != 0) {
            $page = ($pagenum - 1) * $config['per_page'];
        }

      
       

        $output = '<table id="quiz_data" class="table table-striped table-bordered" style="text-align:right">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">عنوان</th>
                        <th scope="col">درس/بخش</th>
                        <th scope="col">تعداد مجاز شرکت</th>
                        <th scope="col">زمان آزمون (دقیقه)</th>
                        <th scope="col">حداکثر نمره</th>
                        <th scope="col">حذف</th>
                        <th scope="col">ویرایش</th>
                        </tr>
                     </thead>
                    <tbody>';
        $search_result = $this->quiz_manager_model->fetch_search_quiz($config["per_page"], $page, $query);

        $i = 1;
        

        foreach ($search_result as $row) {
            $time = (double)$row->max_time;
            $time = $time / 60;
            $output .= '<tr id= "' . $row->quiz_id . '">';
            $output .= '<td>' . $i . '</td>';
            $output .= '<td>' . $row->title . '</td>';

            $part_detail=$this->course_model->get_quiz_part_course_detail($row->quiz_id);
            $output.='<td>' . $part_detail[0]->part_title.'/'.$part_detail[0]->course_title .'</td>';

            $output .= '<td>' . $row->max_attempt . '</td>';
            $output .= '<td>' . $time . '</td>';
            $output .= '<td>' . $row->max_score . '</td>';
            $output.='<td><button type="button" class="btn btn-danger remove">حذف</button></td>';
            $href=base_url('admin/quiz/edit/').$row->quiz_id;
            $output.='<td><button onclick="location.href=\''.$href.'\'" class="btn btn-warning edit">ویرایش</button></td>';
            $output.='</tr>';
            $i++;
        }
        $output.='</tbody>
                    </table>';
        $output.=$this->pagination->create_links();

        echo $output;
    }

    public function index()
    {
        $this->data['page_title'] = "مدیریت آزمون";
        //link address
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/jquery.dataTables.min.js').'"></script>';
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/dataTables.bootstrap4.min.js').'"></script>';

        $this->data['styles'][] = '<link href="'.base_url('assets/css/dataTables.bootstrap4.min.css').'" rel="stylesheet" type="text/css" />';

        $this->data['list_user_link'] = base_url('admin/quiz/users');
        $this->data['new_quiz_link'] = base_url('admin/quiz/insert');
        $this->render('quiz/list');
    }

    public function insert()
    {
        $this->data['page_title'] = "ایجاد آزمون جدید";

        if ($this->input->post('save')) {
            $this->load->library('session');
            $quizdata = $this->input->post('quiz');
            $quizdata['user_id'] = $this->session->userdata('user_id');

            $questionlist = $this->input->post('questionchek');
            $questionlist=explode(',',$questionlist);
            $checked = $this->input->post('randomoption');
            if (isset($checked)) {
                $quizdata['randomoption'] = true;
            } else {
                $quizdata['randomoption'] = false;
            }
            $checked = $this->input->post('randomquestion');
            if (isset($checked)) {
                $quizdata['randomquestion'] = true;
            } else {
                $quizdata['randomquestion'] = false;
            }
            $this->quiz_manager_model->savequiz($quizdata, $questionlist);
            redirect("admin/quiz");
        } else {
            $this->load->model('Course_model', 'Course_model');
            $this->data['course_list']=$this->Course_model->get_courses();
            $this->render('quiz/insert');
        }
    }

    public function delete($id)
    {

        if ($this->quiz_manager_model->deletequiz($id) == true) {
            echo true;
        } else {
            echo false;
        }
    }

    public function edit($id)
    {
        if ($this->input->post('edit')) {
            $quizdata = $this->input->post('quiz');
            $questionlist = $this->input->post('questionchek');
            $questionlist=explode(',',$questionlist);

            $checked = $this->input->post('random_answer');
            if (isset($checked)) {
                $quizdata['random_answer'] = true;
            } else {
                $quizdata['random_answer'] = false;
            }
            $checked = $this->input->post('random_question');
            if (isset($checked)) {
                $quizdata['random_question'] = true;
            } else {
                $quizdata['random_question'] = false;
            }
            $quizdata['quiz_id'] = $id;
            $this->quiz_manager_model->editquiz($quizdata, $questionlist);
            redirect('admin/quiz');
        } else {
            $this->load->helper('form');
            $this->data['page_title']='ویرایش آزمون';
            $this->data['quiz'] = $this->quiz_manager_model->getquiz($id);
            $this->data['question'] = $this->quiz_manager_model->getquizquestionlist($id);
            $this->data['allquestion'] = $this->quiz_manager_model->listallquestion();
            $this->data['quiz_id'] = $id;
            $part_detail=$this->course_model->get_quiz_part_course_detail($id);
            $this->data['part_detail']=$part_detail[0]->part_title.'/'.$part_detail[0]->course_title;
            $this->render('quiz/edit');
        }
    }

    public function users()
    {
        $this->data['data'] = $this->quiz_manager_model->list_user_quiz();
        $this->data['page_title'] = "لیست کاربران آزمون";

        $this->render('quiz/list_users');
    }


    public function get_course_parts() //akax to load parts in insert quiz page
    {
        $datas = $this->input->post('datas');
        $course_id=$datas['course_id'];
        $this->load->model('Course_model', 'Course_model');
        $parts=$this->Course_model->get_parts($course_id);
        echo json_encode($parts);
    }
}

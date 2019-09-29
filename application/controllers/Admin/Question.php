<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends TA_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/Question_model', 'Question_model');
        $this->load->model('admin/tag_manager_model', 'tag_model');
        $this->data['active_menu'] = 'question';
        $this->load->helper("url");
        $this->verify_auth();
    }

    public function loadquestion() //ajax load af questions
    {
        //load My_site_helper
        $this->load->helper('MY_Site_Helper');
        $this->load->library("pagination");
        //pagination
        $data = $this->input->post('datas');
        $perpage = $data['perpage'];
        $pagenum = $data['pagenum'];
        $query = $data['query'];

        //sets th current active page
        $config = array();
        $config["cur_page"] = $pagenum;
        $config['base_url'] = base_url('admin/question/loadquestion/');
        $config["total_rows"] = $this->Question_model->question_count($query);
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = true;

        $this->pagination->initialize($config);

        $page = 0;
        // Row position
        if ($pagenum != 0) {
            $page = ($pagenum - 1) * $config['per_page'];
        }


        $output = '<table id="question_data" class="table table-striped table-bordered" style="text-align:right">
        <thead>
            <tr>
                <th class="sorting" scope="col">#</th>
                <th class="sorting" scope="col">نوع</th>
                <th class="sorting" scope="col">سطح سوال</th>
                <th class="sorting" scope="col">متن سوال (برای جزییات کلیک کنید)</th>
                <th class="sorting" scope="col">برچسب</th>
                <th scope="col">حذف</th>
                <th scope="col">ویرایش</th>
           </tr>
        </thead>';

        $search_result = $this->Question_model->fetch_searched_questions($config["per_page"], $page, $query);
        //get all tags and answers to show in question list
        foreach ($search_result as $question) {
            $loaded_tag[$question->question_id] =
                $this->tag_model->get_tags($question->question_id, question_tag_parent);
            $loaded_answer[$question->question_id] =
                $this->Question_model->getanswerlist($question->question_id);
        }
        $i = 1;
        foreach ($search_result as $row) {
            $output .= '<tbody>';
            $output .= '<tr id="' . $row->question_id . '">';

            $output .= '<td><a class="fa fa-point" aria-hidden="true">' . $i . '</a></td>';

            $output .= '<td>' . question_types_names[$row->question_type] . '</td>';
            $output .= '<td>' . question_level_indicator($row->question_level) . '</td>';
            $output .= '<td class="clickable" data-toggle="collapse" data-target="#questionrow' . $i . '" aria-expanded="false" aria-controls="questionrow' . $i . '">' . $row->question . '</td>';
            $output .= '<td>';
            $alltag = '';
            $fourtag = '';
            $j = 1;
            foreach ($loaded_tag[$row->question_id] as $tag) {
                if ($alltag != '')
                    $alltag .= '-' . $tag->tag_name;
                else
                    $alltag .= $tag->tag_name;
                if ($j < 4) {
                    if ($fourtag != '')
                        $fourtag .= ' - ' . $tag->tag_name;
                    else
                        $fourtag .= $tag->tag_name;
                }
                $j++;

            }
            if ($fourtag != '')
                $output .= '<a tabindex="0" class="btn btn-sm btn-light" data-placement="top" role="button" data-toggle="popover" data-trigger="focus" title="برچسب های سوال" data-content="' . $alltag . '">' . $fourtag . '</a>';
            $output .= '</td>';
            $output .= '<td><button type="submit" class="btn btn-danger remove">حذف</button></td>';
            $output .= '<td><button onclick="location.href=\'' . base_url('admin/question/edit/') . $row->question_id . '\'" class="btn btn-warning edit">ویرایش</button></td>';
            $output .= '</tr>';

            $output .= '</tbody>';
            $output .= '<tbody id="questionrow' . $i . '" class="collapse" style="color:#007bff;background-color:#fbe1dc">';
            //collapse row detail
            $output .= '<tr><td  colspan=7>';
            $output .= 'پاسخ سوال' . '</br>';
            $j = 1;
            foreach ($loaded_answer[$row->question_id] as $answer) {
                $output .= 'پاسخ' . '&nbsp' . $j . '&nbsp:&nbsp';
                $output .= $answer->answer;
                if ($answer->correct) {
                    $output .= ' (صحیح)';
                }
                $output .= '</br>';
                $j++;
            }
            $output .= '</td></tr>';
            $output .= '</tbody>';
            $i++;
        }
        $output .= '</table>';

        //pagination
        $output .= $this->pagination->create_links();

        echo $output;

    }

    public function index() //load question list
    {
        $this->data['page_title'] = "مدیریت سوال";
        //link address
        $this->data['new_question_link'] = base_url('admin/question/insert');
        $this->data['excel_import_link']=base_url('admin/question/upexcel');
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/jquery.dataTables.min.js') . '"></script>';
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/dataTables.bootstrap4.min.js') . '"></script>';

        $this->data['styles'][] = '<link href="' . base_url('assets/css/dataTables.bootstrap4.min.css') . '" rel="stylesheet" type="text/css" />';
        $this->render('question/list');
    }

    public function insert($newnew=false) //save new question
    {
        if ($this->input->post('save')) {
            $questiondata = $this->input->post('question');
            $options = $this->input->post('options');
            $taglist = $this->input->post('taglist');

            $this->Question_model->saveq($questiondata, $options, $taglist, question_tag_parent);
            if(!$newnew){
                redirect("admin/question");
            }
            else {
                redirect("admin/question/insert/1");
            }
        } else {
            $this->data['page_title'] = "سوال جدید";

            $this->data['styles'][] = '<link href="' . base_url('assets/summernote/summernote-lite.css') . '" rel="stylesheet" type="text/css" />';

            $this->data['scripts'][] = '<script src="' . base_url('assets/summernote/summernote-lite.min.js') . '"></script>';

            //loads tags into view
            $all_tags = $this->tag_model->get_all_tags_list(question_tag_parent);
            $this->data['all_tags'] = $all_tags;
            $this->render('question/insert');
        }
    }

    public function delete($id)
    {
        $result = $this->Question_model->deleterecords($id);
        if ($result == true) {
            echo true;
        } else {
            echo false;
        }
    }

    public function edit($id)
    {
        if ($this->input->post('edit')) {
            $questiondata = $this->input->post('question');
            $options = $this->input->post('options');
            $taglist = $this->input->post('taglist');
            $this->Question_model->editquestion($id, $options, $questiondata, $taglist, question_tag_parent);

            redirect('admin/question');
        } else {
            $this->load->helper('form');
            $result = $this->Question_model->getquestion($id);
            $answerlst = $this->Question_model->getanswerlist($id);
            $taglist = $this->tag_model->get_taglist($id, question_tag_parent); //tagtype for question is 1

            $this->data['taglist'] = $taglist;
            $this->data['id'] = $id;
            $this->data['query'] = $result;
            $this->data['options'] = $answerlst;

            $this->data['page_title'] = "ویرایش سوال";

            $this->data['styles'][] = '<link href="' . base_url('assets/summernote/summernote-lite.css') . '" rel="stylesheet" type="text/css" />';

            $this->data['scripts'][] = '<script src="' . base_url('assets/summernote/summernote-lite.min.js') . '"></script>';

            //loads tags into view
            $all_tags = $this->tag_model->get_all_tags_list(question_tag_parent);
            $this->data['all_tags'] = $all_tags;

            $this->render('question/edit');
        }
    }

    public function editor_upload_image()
    {
        // Allowed extentions.
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // Get filename.
        $temp = explode(".", $_FILES["file"]["name"]);

        // Get extension.
        $extension = end($temp);

        // An image check is being done in the editor but it is best to
        // check that again on the server side.
        // Do not use $_FILES["file"]["type"] as it can be easily forged.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

        if ((($mime == "image/gif")
                || ($mime == "image/jpeg")
                || ($mime == "image/pjpeg")
                || ($mime == "image/x-png")
                || ($mime == "image/png"))
            && in_array($extension, $allowedExts)) {
            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;

            // Save file in the uploads folder.
            move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "/uploads/question_img/" . $name);

            // Generate response.
            $response = new StdClass;
            $response->link = base_url('/uploads/question_img/') . $name;
            echo stripslashes(json_encode($response));
        }
    }

    public function uloaded_image_delete()
    {
        // Get src.
        $src = $this->input->post('src');

        // Check if file exists.
        if (file_exists(getcwd() . $src)) {
            // Delete file.
            unlink(getcwd() . $src);
        }
    }

    public function DoUpExcel()
    {
        $this->load->library('upload');
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            foreach ($error as $er)
                echo $er;
        } else {
            $data = $this->upload->data();
            $this->data['filename']=$data['file_name'];
            $this->data['page_title']='لیست سوالات';
            $this->render('question/loadexcel');
        }
    }

    public function UpExcel()
    {
        $this->load->helper('form');
        $this->data['page_title'] = "ورود اکسل";
        $this->render('question/excelup.php');
    }

    public function load_excel() //Ajax_Load
    {
        //load excel file to show
        $this->load->library('excel');
        //load My_site_helper
        $this->load->helper('my_site_helper');

        $data = $this->input->post('datas');
        $filename = $data['filename'];
        $ItemShow = $data['NoItemShow'];
        $inputFileName = ROOT_UPLOAD_IMPORT_PATH . $filename;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                . '": ' . $e->getMessage());
        }
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $row=0;
        $output = '<table id="question_data" class="table table-striped table-bordered" style="text-align:right">
        <thead>
            <tr>
                <th class="sorting" scope="col">#</th>
                <th class="sorting" scope="col">متن سوال (برای جزییات کلیک کنید)</th>
                <th class="sorting" scope="col">برچسب</th>
                <th class="sorting" scope="col">سطح سوال</th>
                <th class="sorting" scope="col">نوع</th>
           </tr>
        </thead>';

        foreach ($allDataInSheet as $dataInSheet) {
            //ignore headers
            if($row!=0) {
                $column = 1;
                $gozine=1;
                $correctAnswer=-1;
                foreach ($dataInSheet as $key => $value) {//all in this foreach is for one question
                    switch ($column) {
                        case 1: //Question Text
                            //each question row
                            $output .= '<tr id="' .$row. '">';
                            $output .= '<td><a class="fa fa-point" aria-hidden="true">' . $row . '</a></td>';
                            $output .= '<td class="clickable" data-toggle="collapse" data-target="#questionrow' . $row . '" aria-expanded="false" aria-controls="questionrow' . $row . '">' . $value . '</td>';


                            break;
                        case 2: //Tags
                            if($value!='') {
                                $output .= '<td>'.$value.'</td>';
                            }
                            break;
                        case 3://question level
                            $output .= '<td>' . question_level_indicator($value) . '</td>';
                            break;
                        case 4: //question type
                            $output .= '<td>' . question_types_names[$value] . '</td>';
                            break;
                        case 5: //correct answer
                            $correctAnswer=$value;
                            //the below line should be on the last case before answer list
                            $output .= '</tr>';
                            $output .= '</tbody>';
                            $output .= '<tbody id="questionrow' . $row . '" class="collapse" style="color:#007bff;background-color:#fbe1dc">';
                            //collapse row detail
                            $output .= '<tr><td  colspan=7>';
                            $output .= 'پاسخ سوال' . '</br>';
                            break;
                        default: //AnswerList
                            if($value!='') {
                                $output .= 'پاسخ' . '&nbsp' . $gozine . '&nbsp:&nbsp';
                                $output .= $value;
                                if ($gozine==$correctAnswer) {
                                    $output .= ' (صحیح)';
                                }
                                $output .= '</br>';
                                $gozine++;
                            }
                            break;
                    }

                    $column++;
                }
                //close the question detail pane
                $output .= '</td></tr>';
                $output .= '</tbody>';
            }
            $row++;
        }
        echo $output;
    }
    public function saveexcel() //save excel file into db
    {
        //load excel file to show
        $this->load->library('excel');
        $data = $this->input->post('datas');
        $filename = $data['filename'];

        $inputFileName = ROOT_UPLOAD_IMPORT_PATH . $filename;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                . '": ' . $e->getMessage());
        }
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $row=0;
        //public function saveq($questiondata,$options,$taglist,$parent_type) //inserts new question into db


        foreach ($allDataInSheet as $dataInSheet) {
            //ignore headers
            if($row!=0) {
                $column = 1;
                $gozine=0;
                $correctAnswer=-1;
                $questiondata=array();
                $tags=array();
                $options=array();
                foreach ($dataInSheet as $key => $value) {//all in this foreach is for one question
                    switch ($column) {
                        case 1: //Question Text
                            $questiondata['text']=$value;
                            //each question row
                            break;
                        case 2: //Tags
                            $tags=explode(',',$value);
                            break;
                        case 3://question level
                            $questiondata['question_level']=$value;
                            break;
                        case 4: //question type
                            $questiondata['question_type']=$value;
                            break;
                        case 5: //correct answer
                            $correctAnswer=$value;
                            break;
                        default: //AnswerList
                            if($value!='') {
                                $options[$gozine]=$value;
                                if($correctAnswer==($gozine+1)){
                                    $gozine++;
                                    $options[$gozine]=correct_sign;
                                }
                                $gozine++;
                            }
                            break;
                    }
                    $column++;
                }
                $this->Question_model->saveq($questiondata,$options,$tags,question_tag_parent);
            }
            $row++;
        }
    }
}
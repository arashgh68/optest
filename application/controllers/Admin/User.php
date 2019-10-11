<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends TA_Admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/user_manager_model', 'user_manager_model');
        $this->data['active_menu'] = 'user';
        $this->verify_auth();
    }

    public function index()
    {
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/jquery.dataTables.min.js') . '"></script>';
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/dataTables.bootstrap4.min.js') . '"></script>';
        $this->data['styles'][] = '<link href="' . base_url('assets/css/dataTables.bootstrap4.min.css') . '" rel="stylesheet" type="text/css" />';
        $this->data['page_title'] = 'مدیریت کاربران';
        $this->render('user/list');
    }

    public function user_list_ajax() // list users as ajax
    {
        $data = $this->input->post('datas');
        $perpage = $data['perpage'];
        $pagenum = $data['pagenum'];
        $query = $data['query'];

        //pagination
        $this->load->library('pagination');
        $config = array();
        $config['cur_page'] = $pagenum;
        $config['base_url'] = base_url() . 'admin/user/user_list_ajax';
        $config['total_rows'] = $this->user_manager_model->user_list_count($query);
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
                        <th scope="col">نام کاربری</th>
                        <th scope="col">نام و نام خانوادگی</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">فعال</th>
                        <th scope="col">گروه</th>
                        <td scope="col">آزمون ها</td>
                        <td scope="col">ویرایش/حذف</td>
                        </tr>
                     </thead>
                    <tbody>';
        $search_result = $this->user_manager_model->fetch_user_list($query, $config["per_page"], $page);

        foreach ($search_result as $user) {
            $user_groups[$user->id] =
                $this->user_manager_model->get_groups($user->id);
        }

        $i = 1;
        foreach ($search_result as $row) {
            $output .= '<tr id= "' . $row->id . '">';
            $output .= '<td>' . $row->id . '</td>';
            $output .= '<td>' . $row->username . '</td>';
            $output .= '<td>' . $row->first_name . ' ' . $row->last_name . '</td>';
            $output .= '<td>' . $row->email . '</td>';
            $output .= '<td>' . ($row->active == 1 ? 'فعال' : 'غیرفعال') . '</td>';

            //this part loads the user groups button
            $allgr = '';
            $fourgr = '';
            $j = 1;
            foreach ($user_groups[$row->id] as $gro) {
                if ($allgr != '')
                    $allgr .= '-' . $gro->name;
                else
                    $allgr .= $gro->name;
                if ($j < 4) {
                    if ($fourgr != '')
                        $fourgr .= ' - ' . $gro->name;
                    else
                        $fourgr .= $gro->name;
                }
                $j++;
            }
            $output .= '<td>';
            if ($fourgr != '')
                $output .= '<a tabindex="0" class="btn btn-sm btn-light" data-placement="top" role="button" data-toggle="popover" data-trigger="focus" title="گروه های عضو" data-content="' . $allgr . '">' . $fourgr . '</a>';
            $output .= '</td>';
            $output .= '<td><button onclick="location.href=\'' . base_url('admin/user/user_quiz_result/') . $row->id . '\'" class="btn btn-warning edit">آزمون ها</button></td>';
            $output .= '<td><button onclick="location.href=\'' . base_url('admin/question/edit/') . '\'" class="btn btn-warning edit">ویرایش/حذف</button></td>';
            $output .= '</tr>';
            $i++;
        }
        $output .= '</tbody>
                    </table>';
        $output .= $this->pagination->create_links();

        echo $output;
    }

    public function User_quiz_list() //ajax list for getting user quiz list
    {
        $data = $this->input->post('datas');
        $perpage = $data['perpage'];
        $pagenum = $data['pagenum'];
        $user_id = $data['user_id'];

        //pagination
        $this->load->library('pagination');
        $config = array();
        $config['cur_page'] = $pagenum;
        $config['base_url'] = base_url() . 'admin/user/User_quiz_list';
        $config['total_rows'] = $this->user_manager_model->user_quiz_count($user_id);
        $config['per_page'] = $perpage;
        $config['use_page_numbers'] = true;
        $this->pagination->initialize($config);
        $page = 0;
        // Row position
        if ($pagenum != 0) {
            $page = ($pagenum - 1) * $config['per_page'];
        }

        $output = '<table id="user_quiz_data" class="table table-striped table-bordered" style="text-align:right">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <td scope="col">نام آزمون</td>
                        <td scope="col">نمره %</td>
                        <td scope="col">تعداد درست</td>
                        <td scope="col">تعداد نادرست</td>
                        <td scope="col">بالاترین نمره</td>
                        <td scope="col">تاریخ شرکت</td>
                        <td scope="col">پاسخنامه کامل</td>
                        </tr>
                     </thead>
                    <tbody>';
        $search_result = $this->user_manager_model->fetch_user_quiz($user_id, $config["per_page"], $page);
        $i = 1;
        $mark = 0;
        foreach ($search_result as $row) {
            if (($row->quiz_correct + $row->quiz_false) != 0) {
                $mark = ($row->quiz_correct) / ($row->quiz_correct + $row->quiz_false);
                $mark = $mark * 100;
            }
            $output .= '<tr id= "' . $row->user_quiz_id . '">';
            $output .= '<td>' . $i . '</td>';
            $output .= '<td>' . $row->title . '</td>';
            $output .= '<td>' . $mark . '</td>';
            $output .= '<td>' . $row->quiz_correct . '</td>';
            $output .= '<td>' . $row->quiz_false . '</td>';
            $output .= '<td>100</td>';
            $output .= '<td>' . $row->quiz_start . '</td>';
            $output .= '<td><button onclick="location.href=\'' . base_url('admin/user/user_answer_sheet/') . $row->user_quiz_id . '\'" class="btn btn-warning edit">دریافت</button></td>';
            $output .= '</tr>';
            $i++;
        }
        $output .= '</tbody>
                    </table>';
        $output .= $this->pagination->create_links();

        echo $output;
    }

    public function user_quiz_result($user_id) //getting the user quiz answer sheets
    {
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/jquery.dataTables.min.js') . '"></script>';
        $this->data['scripts'][] = '<script src="' . base_url('assets/js/dataTables.bootstrap4.min.js') . '"></script>';
        $this->data['styles'][] = '<link href="' . base_url('assets/css/dataTables.bootstrap4.min.css') . '" rel="stylesheet" type="text/css" />';
        $this->data['page_title'] = 'آزمون های کاربر';
        $this->data['user_id'] = $user_id;
        $userinfo = $this->user_manager_model->__get_userinfo($user_id);
        $this->data['Userfullname'] = $userinfo->first_name . ' ' . $userinfo->last_name;
        $this->render('user/user_quiz');
    }

    function user_answer_sheet($user_quiz_id)
    {
        //correct sign glyphicon glyphicon-ok-circle false sign glyphicon glyphicon-remove-circle
        $all_question_answers = $this->user_manager_model->_get_user_quiz_answer_list($user_quiz_id);
        foreach ($all_question_answers as $question) {
            $answer_sheet[$question->question_id] = $this->user_manager_model->_get_user_quiz_question_chek($question->question_id, $question->answer_id);
        }
        $this->data['answer_sheet'] = $answer_sheet;
        $this->data['page_title'] = 'پاسخنامه';
        //$this->data['user_id'] = $user_id;
        //$userinfo = $this->user_manager_model->__get_userinfo($user_id);
        //$this->data['Userfullname'] = $userinfo->first_name . ' ' . $userinfo->last_name;
        //$this->data['styles'][]='<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
        $this->render('user/user_answer_sheet');
    }

    function create_group()
    {

        $this->render('user/create_group');
    }

    function save_users()
    {
        if (isset($_POST['userName'])) {
            $group = array('2'); // Sets user to normal memebers.

            for ($i = 0; $i < count($this->input->post('userName')); $i++) {
                if ($this->input->post('userName') !== "") {
                    $email = "test@test.com";
                    $identity = $this->input->post('userName')[$i];
                    $password = $this->input->post('password')[$i];

                    $additional_data = array(
                        'first_name' => $this->input->post('firstName')[$i],
                        'last_name' => $this->input->post('lastName')[$i],
                    );

                    $this->ion_auth->register($identity, $password, $email, $additional_data, $group);
                }
            }
        }
    }
}

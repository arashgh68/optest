<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Take extends TA_Controller
{

    public function index($quiz_id)
    {
        $this->verify_auth();

        $this->load->model('Quiz_model');

        if ($this->session->has_userdata('user_quiz_id')) {
            $this->start();
            return;
        }
        $quiz = $this->Quiz_model->get_quiz($quiz_id);
        if ($quiz) {
            $this->data['page_title'] = 'آزمون';
            $this->data['quiz_name'] = $quiz->title;
            $this->data['quiz_time'] = $quiz->max_time;
            $this->data['questions'] = $quiz->question_number;
            $this->data['max_score'] = $quiz->max_score;
            $this->data['demerit'] = $quiz->demerit;

            if ($this->Quiz_model->get_user_quiz_attempt($quiz_id, $this->user_id) < $quiz->max_attempt) {

                $this->session->set_userdata('quiz_id', $quiz_id);
            } else {
                $this->session->unset_userdata('quiz_id', $quiz_id);
                $this->data['error'] = "شما مجاز به شرکت در این آزمون نیستید";
            }
        } else {
            $this->data['error'] = "این آزمون وجود ندارد";
        }

        $this->renderPanel('take/index');

    }

    public function start()
    {
        $this->verify_auth();

        if ($this->session->has_userdata('quiz_id')) {
            $this->load->model('Quiz_model');

            $quiz_id = $this->session->quiz_id;

            

            $quiz = $this->Quiz_model->get_quiz($quiz_id);

            if (!$this->session->has_userdata('user_quiz_id')) {
                $this->session->set_userdata('user_quiz_id', $this->Quiz_model->set_user_quiz($this->user_id, $quiz_id, $quiz->question_number));
            }

            $user_quiz = $this->Quiz_model->get_user_quiz($this->session->user_quiz_id);

            $this->data['quiz_name'] = $quiz->title;

            $this->data['quiz_time'] = $quiz->max_time;

            $this->data['max_time'] = $quiz->max_time - (strtotime("now") - strtotime($user_quiz->quiz_start));

            if ($this->data['max_time'] > 0) {

                //سوالات آزمون
                $questions = $this->Quiz_model->get_question_by_user_quiz_id($this->session->user_quiz_id, $quiz->quiz_id, $quiz->random_question);;
                //پاسخ سوالات
                $question_answer = array();

                $total_score = 0.0;

                foreach ($questions as $question) {
                    $question->checked = false;
                    $question_answer[$question->question_id] = $this->Quiz_model->get_answers($question->question_id, $quiz->random_answer);
                    foreach ($question_answer[$question->question_id] as $answer) {
                        if ($answer->correct == 1) {
                            $total_score += $answer->score;
                        }
                        if (isset($question->answer_id) && $question->answer_id == $answer->answer_id) {
                            $answer->checked = true;
                            $question->checked = true;
                        } else {
                            $answer->checked = false;
                        }
                    }
                }

                $this->session->set_userdata('total_score',$total_score);

                $this->data['questions'] = $questions;
                $this->data['answers'] = $question_answer;
                //set title
                $this->data['page_title'] = 'آزمون';

                $this->data['style'] = '<link rel="stylesheet" href="' . base_url() . 'assets/css/simple-scrollbar.css" type="text/css" />';

                $this->data['script'] = '<script src="' . base_url() . 'assets/js/simple-scrollbar.min.js"></script>';

                //render in ta_controller in core
                $this->renderPanel('take/quiz');
            } else {
                $this->finish();
            }
        }
    }

    public
    function answer()
    {
        $this->verify_auth();

        $this->load->model('Quiz_model');


        $user_quiz = $this->Quiz_model->get_user_quiz($this->session->user_quiz_id);

        $quiz = $this->Quiz_model->get_quiz($this->session->quiz_id);

        $max_time = $quiz->max_time - (strtotime("now") - strtotime($user_quiz->quiz_start));

        if ($max_time <= 0) {
            $this->finish();
            return;
        }

        if (!empty($_POST)) {
            $sp = explode('_', $_POST['value']);

            $value = array('user_quiz_id' => $this->session->user_quiz_id, 'question_id' => $sp[0], 'answer_id' => $sp[1], 'answer_time' => date("Y-m-d H:i:s"));
            if ($this->Quiz_model->set_user_answer($value) != 1) {
                echo 0;
            } else {
                echo 1;
            }
        }
    }

    public
    function clear_answer()
    {
        $this->verify_auth();

        $this->load->model('Quiz_model');

        if (!empty($_POST)) {
            $sp = explode('_', $_POST['value']);

            $value = array('user_quiz_id' => $this->session->user_quiz_id, 'question_id' => $sp[1],'answer_id' => NULL, 'answer_time' => NULL);
            if ($this->Quiz_model->set_user_answer($value) != 1) {
                echo 0;
            } else {
                echo 1;
            }
        }
    }

    public
    function finish()
    {
        $this->verify_auth();

        $this->load->model('Quiz_model');

        if (isset($this->session->user_quiz_id) && isset($this->session->quiz_id)) {

            $quiz = $this->Quiz_model->get_quiz($this->session->quiz_id);

            $result_quiz = $this->Quiz_model->get_user_quiz_result($this->session->user_quiz_id);

            $correct = 0;
            $false = 0;

            $total_score = $this->session->total_score;
            $grade = 0.0;

            foreach ($result_quiz as $row) {
                if ($row->correct == 1) {
                    $correct++;
                    $grade += $row->score;
                } else {
                    $false++;
                    if ($quiz->demerit > 0)
                        $grade -= $row->score / $quiz->demerit;
                }
            }

            $quiz_grade = ($grade / $total_score) * $quiz->max_score;

            $this->Quiz_model->finish_user_quiz($this->session->user_quiz_id, $quiz_grade, $correct, $false);

            $user_quiz_id = $this->session->user_quiz_id;

            $this->session->unset_userdata('user_quiz_id');
            $this->session->unset_userdata('quiz_id');
            $this->session->unset_userdata('total_score');

            $this->result($user_quiz_id);

        } else {
            $this->data['error'] = "آزمون وجود ندارد";
            $this->renderPanel('take/index');
        }
    }

    public
    function result($user_quiz_id)
    {
        $this->verify_auth();

        $this->load->model('Quiz_model');

        $this->data['page_title'] = 'نتیجه آزمون';

        $quiz = $this->Quiz_model->get_quiz_by_user_quiz_id($user_quiz_id, $this->user_id);

        if (isset($quiz)) {

            $this->data['style'] = '<link rel="stylesheet" href="' . base_url() . 'assets/morris/morris.css" type="text/css" />';

            $this->data['style'] .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/simple-scrollbar.css" type="text/css" />';

            $this->data['script'] = '<script src="' . base_url() . 'assets/js/simple-scrollbar.min.js"></script>';

            $quiz_question = $this->Quiz_model->get_question_by_user_quiz_id($user_quiz_id, $quiz->quiz_id);

            $question_answer = array();

            foreach ($quiz_question as $question) {
                $question_answer[$question->question_id] = $this->Quiz_model->get_answers($question->question_id, $quiz->random_answer);
                $question->user_result = null;
                foreach ($question_answer[$question->question_id] as $answer) {
                    if ($question->answer_id == $answer->answer_id) {
                        $answer->checked = true;
                    } else {
                        $answer->checked = false;
                    }
                    if ($answer->checked && $answer->correct) {
                        $question->user_result = 'question-correct';
                    } else if ($answer->checked) {
                        $question->user_result = 'question-false';
                    }
                }
            }

            $this->data["quiz_name"] = $quiz->title;

            $correct = $quiz->quiz_correct;
            $false = $quiz->quiz_false;

            $total = count($quiz_question);

            $answered = $correct + $false;

            $this->data['correct'] = $correct;
            $this->data['false'] = $false;

            $this->data['grade'] = $quiz->quiz_grade;
            $this->data['max_score'] = $quiz->max_score;

            $this->data['percentCorrect'] = ceil($correct / $total * 100);
            $this->data['percentFalse'] = ceil($false / $total * 100);
            $this->data['percentNAnswer'] = ceil(($total - $answered) / $total * 100);

            $this->data['answered'] = $answered;
            $this->data['total'] = $total;

            $this->data['questions'] = $quiz_question;
            $this->data['answers'] = $question_answer;

            $this->data['quiz_id'] = $quiz->quiz_id;

            $this->data['quiz_time'] = gmdate("H:i:s", strtotime($quiz->quiz_end) - strtotime($quiz->quiz_start));

        } else {

            $this->data['error'] = "این آزمون وجود ندارد یا شما امکان مشاهده این آزمون را ندارید";
        }
        $this->renderPanel('take/result');

    }
}

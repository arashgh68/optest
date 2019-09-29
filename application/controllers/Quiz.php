<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Quiz extends TA_Controller
{
    public function index($quiz_id = null)
    {
        $this->verify_auth();

        $this->load->model('Quiz_model');

        if (isset($quiz_id)) {
            $this->data["quiz"] = $this->Quiz_model->get_quiz($quiz_id);
            $this->data["course"] = $this->Quiz_model->get_quiz_course($quiz_id);

            if ($this->ion_auth->logged_in()) {
                $this->load->library('jalaliDate');
                $quizzes = $this->Quiz_model->get_user_quiz_take($this->user_id, $quiz_id,'quiz_end desc');
                if ($quizzes) {
                    $min_quiz = $quizzes[0]->quiz_grade;
                    $max_quiz = $quizzes[0]->quiz_grade;
                }
                else{
                    $min_quiz = 0;
                    $max_quiz = 100;
                }
                $sum = 0;
                foreach ($quizzes as $quiz) {
                    $quiz->time_elapsed = gmdate("H:i:s", strtotime($quiz->quiz_end) - strtotime($quiz->quiz_start));
                    if ($quiz->quiz_grade < $min_quiz) $min_quiz = $quiz->quiz_grade;
                    if ($quiz->quiz_grade > $max_quiz) $max_quiz = $quiz->quiz_grade;
                    $quiz->quiz_date = $this->jalalidate->jdate('Y/m/d',strtotime($quiz->quiz_start));
                    $sum += $quiz->quiz_grade;
                }

                $this->data["avg"] = $sum/count($quizzes);
                $this->data["quizzes"] = $quizzes;
                $this->data["min_quiz"] = $min_quiz;
                $this->data["max_quiz"] = $max_quiz;

            }
            $this->renderPanel('quiz/detail');
        } else {
            $quizzes = $this->Quiz_model->get_quizzes();


            //getting the max/min reports in view
            $UserRecords = array("MaxScore" => "-1", "MinScore" => "-1", "BestScore" =>
                "-1", "FastestScore" => "-1", "SlowestScore" => "-1");
            if ($this->ion_auth->logged_in()) {
                $user_quizes = $this->Quiz_model->get_user_quiz_list($this->user_id);

                //initialization
                $UserRecords['MaxScore'] = $user_quizes[0]->quiz_grade;
                $UserRecords['MinScore'] = $user_quizes[0]->quiz_grade;
                $start = new DateTime($user_quizes[0]->quiz_start);
                $end = new DateTime($user_quizes[0]->quiz_end);
                $time_elapsed = date_diff($start, $end);
                $UserRecords['BestScore'] = $user_quizes[0]->quiz_grade / ($time_elapsed->s);
                $UserRecords['FastestScore'] = $time_elapsed->s;
                $UserRecords['SlowestScore'] = $time_elapsed->s;

                foreach ($user_quizes as $row) {
                    $start = new DateTime($row->quiz_start);
                    $end = new DateTime($row->quiz_end);
                    $time_elapsed = date_diff($start, $end);
                    $latestscore = $row->quiz_grade / $time_elapsed->s;
                    if ($row->quiz_grade > $UserRecords['MaxScore']) { //MaxScore
                        $UserRecords['MaxScore'] = $row->quiz_grade;
                    }
                    if ($row->quiz_grade < $UserRecords['MinScore']) { //MinScore
                        $UserRecords['MinScore'] = $row->quiz_grade;
                    }
                    if ($latestscore > $UserRecords['BestScore']) { //Best Score
                        $UserRecords['BestScore'] = $latestscore;
                    }
                    if ($time_elapsed->s < $UserRecords['FastestScore']) { //Fastest Score
                        $UserRecords['FastestScore'] = $time_elapsed->s;
                    }
                    if ($time_elapsed->s > $UserRecords['SlowestScore']) { //Slowest Score
                        $UserRecords['SlowestScore'] = $time_elapsed->s;
                    }
                }
            }


            $this->data["take_quiz"] = false;
            if ($this->ion_auth->logged_in()) {
                $this->data["take_quiz"] = true;
            }
            $this->data['UserRecords'] = $UserRecords;
            $this->data['quizzes'] = $quizzes;
            $this->data['page_title'] = "آزمون ها";
            $this->render('quiz/index');
        }
    }
}
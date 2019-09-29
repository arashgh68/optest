<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Quiz_model extends CI_Model
{


    public function get_quizzes()
    {
        $this->db->select('*');
        $this->db->from('quiz');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_quiz($quiz_id)
    {
        $this->db->select('*');
        $this->db->from('quiz');
        $this->db->where('quiz_id', $quiz_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_quiz_course($quiz_id){
        $this->db->select('course.course_id, course.title');
        $this->db->from('quiz');
        $this->db->join('part_quiz','quiz.quiz_id = part_quiz.quiz_id');
        $this->db->join('part','part_quiz.part_id = part.part_id');
        $this->db->join('course','course.course_id = part.course_id');
        $this->db->where('quiz.quiz_id', $quiz_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_questions($quiz_id, $rand)
    {

        $this->db->select('*');
        $this->db->from('quiz_question');
        $this->db->join('question', 'quiz_question.question_id = question.question_id');
        $this->db->where('quiz_id', $quiz_id);
        if ($rand) {
            $this->db->order_by('RAND()');
        } else {
            $this->db->order_by('question_order');
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function get_answers($questin_id, $rand)
    {

        $this->db->where('question_id', $questin_id);
        if ($rand) {
            $this->db->order_by('RAND()');
        }

        $query = $this->db->get('answer');

        return $query->result();
    }

    //add row per answer by user
    public function set_user_answer($data)
    {
        return $this->db->replace('user_quiz_answer', $data);
    }

    // public function clear_user_answer($data)
    // {
    //     $this->db->where($data);
    //     $this->db->delete('user_quiz_answer');
    //     return true;
    // }

    public function set_user_quiz($user_id, $quiz_id, $count = 0)
    {
        $data = array('user_id' => $user_id, 'quiz_id' => $quiz_id, 'quiz_start' => date("Y-m-d H:i:s"));
        $this->db->insert('user_quiz', $data);

        $user_quiz_id = $this->db->insert_id();
        if ($count > 0) {
            $sql = "INSERT INTO user_quiz_answer (user_quiz_id,question_id) SELECT " . $user_quiz_id . ",question_id FROM quiz_question WHERE quiz_id = " . $quiz_id . " ORDER BY RAND() LIMIT " . $count;
        } else {
            $sql = "INSERT INTO user_quiz_answer (user_quiz_id,question_id) SELECT " . $user_quiz_id . ",question_id FROM quiz_question WHERE quiz_id = " . $quiz_id;
        }
        $this->db->query($sql);

        return $user_quiz_id;
    }

    public function get_user_quiz($user_quiz_id)
    {
        $this->db->select('*');
        $this->db->from('user_quiz');
        $this->db->where('user_quiz_id', $user_quiz_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function check_user_quiz_time($user_quiz_id)
    {
        $this->db->select('*');
        $this->db->from('user_quiz');
        $this->db->join('quiz', 'user_quiz.quiz_id = quiz.quiz_id');
        $this->db->where('user_quiz.id', $user_quiz_id);
        $query = $this->db->get();

        $uqr = $query->row();
        $time = $uqr->quiz_start;
        $maxt = $uqr->max_time;

        if (strtotime($time) + $maxt > strtotime("now"))
            return true;
        else
            return false;
    }

    public function get_user_quiz_attempt($quiz_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('user_quiz');
        $this->db->where(array('quiz_id' => $quiz_id, 'user_id' => $user_id));

        return $this->db->count_all_results();
    }

    public function finish_user_quiz($user_quiz_id, $quiz_grade, $correct, $false)
    {
        $this->db->where('user_quiz_id', $user_quiz_id);
        $this->db->update('user_quiz', array('quiz_grade' => $quiz_grade, 'quiz_correct' => $correct, 'quiz_false' => $false, 'quiz_end' => date("Y-m-d H:i:s")));
    }

    public function get_user_quiz_result($user_quiz_id)
    {
        $this->db->select('*');
        $this->db->from('user_quiz_answer');
        $this->db->join('answer', 'user_quiz_answer.answer_id = answer.answer_id');
        $this->db->where(array('user_quiz_id' => $user_quiz_id));
        $query = $this->db->get();

        return $query->result();
    }

    public function get_quiz_by_user_quiz_id($user_quiz_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('user_quiz');
        $this->db->join('quiz', 'user_quiz.quiz_id = quiz.quiz_id');
        $this->db->where(array('user_quiz_id' => $user_quiz_id, 'user_id' => $user_id));
        $query = $this->db->get();

        return $query->row();
    }
    public function get_question_by_user_quiz_id($user_quiz_id, $quiz_id, $rand = false)
    {
        //$sql = "SELECT d.question_id,d.question,d.question_type,e.answer_id FROM (SELECT q.question_id,q.question,q.question_type FROM quiz_question qq JOIN question q ON q.question_id = qq.question_id WHERE qq.quiz_id = " . $this->db->escape($quiz_id) . ") d LEFT JOIN (SELECT uqa.answer_id, uqa.question_id FROM user_quiz_answer uqa JOIN question q on q.question_id = uqa.question_id WHERE uqa.user_quiz_id = " . $this->db->escape($user_quiz_id) . ") e on d.question_id = e.question_id";

        $sql = "select * from user_quiz_answer uqa join question q on uqa.question_id = q.question_id  where user_quiz_id =" . $user_quiz_id;

        if ($rand) {
            $sql .= " Order By RAND()";
        }

        $query = $this->db->query($sql);


        return $query->result();
    }

    public function get_user_quiz_take($user_id, $quiz_id, $order_by = null)
    {
        $this->db->select('*');
        $this->db->from('user_quiz');
        $this->db->join('quiz', 'user_quiz.quiz_id = quiz.quiz_id');
        $this->db->where(array('user_quiz.quiz_id' => $quiz_id, 'user_id' => $user_id));
        if ($order_by) {
            $this->db->order_by($order_by);
        }
        $query = $this->db->get();

        return $query->result();
    }

    //get user_quiz_list with quiz description joined
    public function get_user_quiz_list($user_id) //get user quiz with its description
    {
        //$this->db->select('user_quiz.user_quiz_id, user_quiz.quiz_id'.
        //  ', user_quiz.quiz_grade, user_quiz.quiz_correct, user_quiz.quiz_false');
        //.
        //            ' TIMESTAMPDIFF(minute,user_quiz.quiz_start,user_quiz.quiz_end) AS \'quiztime\''
        $this->db->select('*');
        $this->db->from('user_quiz');
        $this->db->where('user_id', $user_id);
        //$this->db->join('quiz','user_quiz.quiz_id=quiz.quiz_id','left');
        $query = $this->db->get();
        return $query->result();
    }
}

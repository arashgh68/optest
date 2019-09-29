<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class quiz_manager_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function listallquestion() //loads questions to show in tables
    {
        $query = $this->db->from('question')->get();
        return $query->result();
    }

    public function quizlist() //loads questions to show in tables
    {
        $query = $this->db->from('quiz')->get();
        return $query->result();
    }

    public function quiz_count($query)
    {
        $this->db->from('quiz');
        $this->db->like('title', $query);
        $this->db->or_like('description', $query);
        return $this->db->count_all_results();
    }

    public function fetch_search_quiz($limit, $start, $query)
    {
        $this->db->limit($limit, $start);
        $this->db->like('title', $query);
        $this->db->or_like('description', $query);
        $rows = $this->db->get('quiz');
        return $rows->result();
    }

    public function savequiz($quizdata, $questionlist)
    {
        $maxtime = (double)$quizdata['time'];
        $maxtime = $maxtime * 60; //convert to seconds
        //new quiz row
        $newrow = array(
            'time_created' => date("Y-m-d H:i:s"),
            'max_time' => $maxtime,
            'max_attempt' => $quizdata['attempt'],
            'max_score' => $quizdata['max_score'],
            'creator_id' => $quizdata['user_id'],
            'title' => $quizdata['title'],
            'question_number' => $quizdata['question_number'],
            'random_answer' => $quizdata['randomoption'],
            'random_question' => $quizdata['randomquestion'],
            'demerit' => $quizdata['demerit'],
        );
        $this->db->insert('quiz', $newrow);

        //add quiz_question list        
        $qid = $this->db->insert_id();

        foreach ($questionlist as $question) {
            $newrow = array(
                'quiz_id' => $qid,
                'question_id' => $question,
                'question_order' => $question,
            );
            $this->db->insert('quiz_question', $newrow);
        }

        //add quiz_part relationship
        $newrow=array(
            'part_id'=>$quizdata['part_id'],
            'quiz_id'=>$qid,
        );
        $this->db->insert('part_quiz',$newrow);
    }

    public function deletequiz($id)
    {
        $options = array('quiz_id' => $id);
        $query = $this->db->get_where('user_quiz', $options);
        if ($query->num_rows() > 0) {
            return false;
        } else {
            $this->db->delete('quiz', array('quiz_id' => $id));
            $this->db->delete('quiz_question', array('quiz_id' => $id));
            return true;
        }
    }

    public function list_user_quiz()
    {
        $this->db->select('user_quiz.user_quiz_id, user_quiz.quiz_start, user_quiz.quiz_end,' .
            ' user_quiz.quiz_grade, users.username, users.first_name, users.last_name, quiz.title');

        $this->db->from('user_quiz')->join('users', 'users.id = user_quiz.user_id')->
        join('quiz', 'user_quiz.quiz_id=quiz.quiz_id');
        $result = $this->db->get();
        return $result->result();
    }

    public function getquiz($qid)
    {
        $result = $this->db->from('quiz')->where('quiz_id', $qid)->get();
        return $result->result();
    }

    public function getquizquestionlist($qid)
    {
        $result = $this->db->select('question_id')->from('quiz_question')->where('quiz_id', $qid)->get();
        return $result->result();
    }

    public function editquiz($quizdata, $questionlist)
    {
        $quizid = $quizdata['quiz_id'];
        //update the quiz table
        $maxtime = (double)$quizdata['max_time'];
        $maxtime = $maxtime * 60; //convert to seconds
        //updated quiz row
        $newrow = array(
            'max_time' => $maxtime,
            'max_attempt' => $quizdata['max_attempt'],
            'title' => $quizdata['title'],
            'question_number' => $quizdata['question_number'],
            'random_answer' => $quizdata['random_answer'],
            'random_question' => $quizdata['random_question'],
        );
        $this->db->where('quiz_id', $quizid);
        $this->db->update('quiz', $newrow);

        //update quiz_question table
        //fisrt delete all question related to this quiz in question_quiz table
        $this->db->delete('quiz_question', array('quiz_id' => $quizid));
        //now add question id list to quiz_question table
        foreach ($questionlist as $question) {
            $newrow = array(
                'quiz_id' => $quizid,
                'question_Id' => $question,
                'question_order' => $question,
            );
            $this->db->insert('quiz_question', $newrow);
        }
    }
}
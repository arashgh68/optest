<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class user_manager_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        }

    function  user_list_count($query) //count user list as query
    {
        $this->db->select('id');
        $this->db->from('users');
        $tempquery=explode('+',$query);
        foreach ($tempquery as $key) {
            $this->db->or_like('username',$key);
            $this->db->or_like('first_name',$key);
            $this->db->or_like('last_name',$key);
        }
        return $this->db->count_all_results();
    }

    function  fetch_user_list($query,$limit,$start) //get user list
    {
        $this->db->limit($limit,$start);
        $this->db->select('username, first_name, last_name, email, id, active');
        $this->db->from('users');
        $tempquery=explode('+',$query);
        foreach ($tempquery as $key) {
            $this->db->or_like('username',$key);
            $this->db->or_like('first_name',$key);
            $this->db->or_like('last_name',$key);
        }
        $res=$this->db->get();
        return $res->result();
    }
    function user_quiz_count($user_id) //these two functions list the user_quiz list in user_quiz controller
    {
        $this->db->select('id');
        $this->db->from('user_quiz');
        $this->db->where('user_id',$user_id);
        return $this->db->count_all_results();
    }
    function fetch_user_quiz($user_id,$limit,$start)
    {
        $this->db->limit($limit,$start);
        $this->db->select('user_quiz.user_quiz_id, user_quiz.quiz_id, user_quiz.quiz_grade,'.
            ' user_quiz.quiz_correct, user_quiz.quiz_false, user_quiz.quiz_start, quiz.title');
        $this->db->from('user_quiz');
        $this->db->join('quiz','quiz.quiz_id=user_quiz.quiz_id');
        $this->db->where('user_quiz.user_id',$user_id);
        $res=$this->db->get();
        return $res->result();
    }

    function get_groups($user_id)
    {
        //SELECT  FROM `` join  on
        $this->db->select('groups.name');
        $this->db->from('users_groups');
        $this->db->join('groups','users_groups.group_id=groups.id');
        $this->db->where('users_groups.user_id',$user_id);
        return $this->db->get()->result();
    }
    function __get_userinfo($user_id)
    {
        $this->db->select('username, first_name, last_name');
        $this->db->from('users');
        $this->db->where('id',$user_id);
        $res=$this->db->get();
        return $res->first_row();
    }

    //there is some function here for getting answer sheet
    function _get_user_quiz_answer_list($user_quiz_id)
    {
        $this->db->select('')->from('user_quiz_answer');
        $this->db->where('user_quiz_id',$user_quiz_id);
        $res=$this->db->get();
        return $res->result();
    }
    function _get_user_quiz_question_chek($question_id,$user_answer_id)
    {
        $user_question_result=array();
        $this->db->select('correct,answer_id')->from('answer')->where('question_id',$question_id);
        $result=$this->db->get();
        $result=$result->result();
        $user_question_result['answer_count']=$this->db->count_all_results();
        $i=1;
        $answer_chek=false;
        $user_question_result['question_id']=$question_id;
        foreach ($result as $answer) {
            if($user_answer_id==$answer->answer_id) {
                if($answer->correct) {
                    $answer_chek=true;
                    $user_question_result['correct_option_num']=$i;
                }
                $user_question_result['user_option_num']=$i;
            }else {
                if ($answer->correct) {
                    $answer_chek=false;
                    $user_question_result['correct_option_num']=$i;
                }
            }
            $i++;
        }
        $user_question_result['answer_chek']=$answer_chek;
        return $user_question_result;
    }
}

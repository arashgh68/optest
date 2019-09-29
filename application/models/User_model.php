<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 12:10 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

    public function get_quizzes($user_id){
        $this->db->select('quiz.quiz_id,quiz.title,course.title as ctitle,user_quiz.quiz_end,user_quiz.quiz_start,avg(user_quiz.quiz_grade) as avg_grade');
        $this->db->from('user_quiz');
        $this->db->join('quiz','user_quiz.quiz_id = quiz.quiz_id','left');
        $this->db->join('part_quiz','part_quiz.quiz_id = quiz.quiz_id','left');
        $this->db->join('part','part_quiz.part_id = part.part_id','left');
        $this->db->join('course','course.course_id = part.course_id','left');
        $this->db->group_by('quiz.quiz_id');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_quizzes_taked($user_id){
        $this->db->select('*');
        $this->db->from('quiz');
        $this->db->join('user_quiz','user_quiz.quiz_id = quiz.quiz_id');
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_courses($user_id,$count=0){
        $this->db->select('*');
        $this->db->from('course');
        $this->db->join('user_course','course.course_id = user_course.course_id');
        $this->db->where('user_id',$user_id);
        if($count>0){
            $this->db->limit($count);
        }
        $query = $this->db->get();
        return $query->result();
    }
}
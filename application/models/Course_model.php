<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Course_model extends CI_Model
{
    public function get_courses($count = 0)
    {
        $this->db->select('*');
        $this->db->from('course');
        if ($count > 0) {
            $this->db->limit($count);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function get_course($course_id)
    {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->where('course_id', $course_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_parts($course_id)
    {
        $this->db->select('*');
        $this->db->from('part');
        $this->db->where('course_id', $course_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_part($part_id)
    {
        $this->db->select('*');
        $this->db->from('part');
        $this->db->where('part_id', $part_id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_part_quiz($part_id)
    {
        $this->db->select('*');
        $this->db->from('part_quiz');
        $this->db->join('quiz', 'quiz.quiz_id = part_quiz.quiz_id');
        $this->db->where('part_id', $part_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_course_quiz($course_id)
    {
        $this->db->select('*');
        $this->db->from('part');
        $this->db->join('part_quiz', 'part.part_id = part_quiz.part_id');
        $this->db->join('quiz', 'quiz.quiz_id = part_quiz.quiz_id');
        $this->db->where('course_id', $course_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function register_course($course_id, $user_id)
    {
        $data = array('user_id' => $user_id, 'course_id' => $course_id);
        $this->db->insert('user_course', $data);

        return $this->db->insert_id();
    }

    public function get_registered_course($user_id)
    {
        $this->db->select('course_id');
        $this->db->from('user_course');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        return $query->result();
    }

    //get part detail from the quiz_id related to some parts
    public function get_quiz_part_course_detail($quiz_id)
    {
        $this->db->select('part.title as part_title, part.description, course.title as course_title');
        $this->db->from('part_quiz');
        $this->db->join('part', 'part.part_id=part_quiz.part_id');
        $this->db->join('course', 'part.course_id = course.course_id');
        $this->db->where('part_quiz.quiz_id', $quiz_id);
        $query = $this->db->get();

        return $query->result();
    }
    
    public function get_search_course($q)
    {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->like('title',$q);
        $query = $this->db->get();

        return $query->result();
    }
}

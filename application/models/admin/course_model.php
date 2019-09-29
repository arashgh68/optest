<?php

defined('BASEPATH') or exit('No direct script access allowed');

class course_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

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

        return $query->result();
    }

    //get course_parts_count
    public function get_course_user_count($course_id)
    {
        $this->db->from('user_course');
        $this->db->where('course_id', $course_id);
        $count = $this->db->count_all_results();

        return $count;
    }

    //uppdate new course
    public function save_course($course_data, $parts = null)
    {
        $data = array('title' => $course_data['title'], 'description' => $course_data['description']);
        $this->db->insert('course', $data);
        if (empty($parts)) {
            return $this->db->insert_id();
        } else { //add parts too
            $course_id = $this->db->insert_id();
            foreach ($parts as $part) {
                $data = array('title' => $part['title'], 'course_id' => $course_id, 'description'->$part['description']);
                $this->db->insert('parts', $data);
            }
        }
    }

    //save new course
    public function update_course($course_data, $course_id)
    {
        $data = array('title' => $course_data['title'], 'description' => $course_data['description']);
        $this->db->where('course_id', $course_id);
        return $this->db->update('course', $data);
    }

    //add parts to existing course
    public function add_course_parts($parts, $course_id)
    {
        $data = array('course_title' => $course_data->title, 'description' => $course_data->description);
        $this->db->insert('course', $data);

        return $this->db->insert_id();
    }

    //get parts list
    public function get_parts($course_id = null)
    {
        $this->db->select('part.title as title, part.description as description, course.title as course_title, part.part_id');
        $this->db->from('part');
        $this->db->join('course', 'course.course_id=part.course_id');
        if (!empty($course_id)) {
            $this->db->where('part.course_id', $course_id);
        }
        $query = $this->db->get();

        return $query->result();
    }

    //get part_quiz_count
    public function get_part_quiz_count($part_id)
    {
        $this->db->from('part_quiz');
        $this->db->where('part_id', $part_id);
        $count = $this->db->count_all_results();

        return $count;
    }
    //delete a course
    public function delete_course($course_id)
    {
        $this->db->where('course_id', $course_id);
        return $this->db->delete('course');
    }
}

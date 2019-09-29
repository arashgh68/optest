<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model
{
    function __construct() {

        parent::__construct();
        $this->load->model('admin/tag_manager_model','tag_model');
        }
    // get all tags that are questions

    public function displayquestion() //loads questions to show in tables
    {
        $query=$this->db->select('*')->from('question')->get();
	    return $query->result();
    }

    public function fetch_paginated_questions($limit,$start)
    {
        $this->db->limit($limit,$start);
        $query=$this->db->get('question');
        return $query->result();
    }
    //search and fetch paginated
    public function fetch_searched_questions($limit,$start,$query)
    {
        $this->db->limit($limit,$start);
        //question search
        $tempquery=explode('+',$query);
        foreach ($tempquery as $key) {
            $this->db->or_like('question', $key);
        }
        $query=$this->db->get('question');
        return $query->result();
    }

    //count records in question table
    public function question_count($query)
    {
        $this->db->from('question');
        $tempquery=explode('+',$query);
        foreach ($tempquery as $key) {
            $this->db->or_like('question', $key);
        }
        return $this->db->count_all_results();
    }

    //search and fetch questions with tag search
    public function fetch_searched_questions_with_tagsearch($limit,$start,$query,$tagquery)
    {
        $this->db->limit($limit,$start);
        $this->db->select('question.question,question.question_id,
            question.question_type,question.question_level,question.description');
        $this->db->from('question');
        $this->db->join('tag','tag.parent_id=question.question_id');
        $this->db->where('tag.tag_type',question_tag_parent);

        $this->db->group_start();
        //question search
        $tempquery=explode('+',$query);
        foreach ($tempquery as $key) {
            $this->db->or_like('question.question', $key);
        }
        $this->db->group_end();
        //tag search
        $tempquery=explode('+',$tagquery);
        foreach ($tempquery as $key) {
            $this->db->like('tag.tag_name',$key);
        }
        $this->db->group_by('question.question_id');
        $result=$this->db->get();
        return $result->result();
    }
    //count records in question table including tag search
    public function question_count_with_tag($query,$tagquery)
    {
        $this->db->from('question');
        $this->db->join('tag','tag.parent_id=question.question_id');
        $this->db->where('tag.tag_type',question_tag_parent);

        $this->db->group_start();
        //question search
        $tempquery=explode('+',$query);
        foreach ($tempquery as $key) {
            $this->db->or_like('question.question', $key);
        }
        $this->db->group_end();
        //tag search
        $tempquery=explode('+',$tagquery);
        foreach ($tempquery as $key) {
            $this->db->like('tag.tag_name',$key);
        }
        $this->db->group_by('question.question_id');
        return $this->db->count_all_results();
    }

    function deleterecords($id)
	{
        $options=array('question_id'=>$id);
        $query =  $this->db->get_where('quiz_question',$options);
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            $this->db->delete('question', array('question_id' => $id));
            $this->db->delete('answer', array('question_id' => $id));
            $this->tag_model->delete_tag($id,question_tag_parent);
            return true;
        }
	}	

    public function saveq($questiondata,$options,$taglist,$parent_type) //inserts new question into db
    {
        //inserting new question into question table
        $newrow = array(
			'question' => $questiondata['text'],
			'question_type' => $questiondata['question_type'],
			'question_level' => $questiondata['question_level'],
			'time_created' => date("Y/m/d"),
        );

        $this->db->insert('question', $newrow);
        
        //inserting answer options
        $qid=$this->db->insert_id();

        $nrows=count($options);
        $chek=false; //save answer correct for each option as temp
        for($i=0;$i<$nrows;$i++)
        {
            $chek=false;
            // kelid g#1#true baraye in tarif shode k pishfarz on minevise va momkene matne ye gozine vagheab on bashe o barname khata kone
            if($options[$i]!=correct_sign) // chek mikone k aya in satr marboot be correct ast ya khode text ast
            {
                $j=$i+1;
                if($i>=($nrows-1)) //satr akhar agar az noe boolean nabashe yani javabe dorost ham naboode
                {
                    $chek=false;
                }
                else
                {
                    if($options[$j]==correct_sign)
                    {
                        $chek=true;
                    }
                }
                $newrow= array(
                    'answer'=> $options[$i],
                    'correct'=>$chek,
                    'question_id'=> $qid,
                    );
                $this->db->insert('answer', $newrow);
            }
        }

        //insert selected tags
        if(count($taglist)>0)
        {
            $this->tag_model->add_to_tag($taglist,$qid,$parent_type); //tagtype=1 for question
        }
    }

    public function getanswerlist($id) //loads answers to show text
    {
        //$options=array('question_id'=>$id);
        $query =  $this->db->select('answer, correct')->from('answer')->where('question_id',$id)->get();
	    return $query->result();
    }
    public function getquestion($id)
    {
        $query =  $this->db->select('question, question_type, question_level')->from('question')->where('question_id',$id);
        return $query->get()->result();
    }
    public function editquestion($id,$options,$questiontext,$taglist,$tagtype)
    {

        //update question text
        $data = array(
                'question'=> $questiontext['text'],
                'question_type' => $questiontext['question_type'],
                'question_level' => $questiontext['question_level'],
                );
        $this->db->where('question_id', $id)->update('question', $data);

        //delete answer records first
        $this->db->delete('answer', array('question_id' => $id));

        //save answers again
        $nrows=count($options);
        $chek=false; //save answer correct for each option as temp
        for($i=0;$i<$nrows;$i++)
        {
            $chek=false;
            // kelid g#1#true baraye in tarif shode k pishfarz on minevise va momkene matne ye gozine vagheab on bashe o barname khata kone
            if($options[$i]!="g#1#true") // chek mikone k aya in satr marboot be correct ast ya khode text ast
            {
                $j=$i+1;
                if($i>=($nrows-1)) //satr akhar agar az noe boolean nabashe yani javabe dorost ham naboode
                {
                    $chek=false;
                }
                else
                {
                    if($options[$j]=="g#1#true")
                    {
                        $chek=true;
                    }
                }
                $newrow= array(
                    'answer'=> $options[$i],
                    'correct'=>$chek,
                    'question_id'=> $id,
                );
                $this->db->insert('answer', $newrow);

            }
        }

        //deletes and saves tags again

        $this->tag_model->delete_tag($id,$tagtype);
        // now adds tags again
        //insert selected tags
        if(count($taglist)>0)
        {
            $this->tag_model->add_to_tag($taglist,$id,$tagtype); //tagtype=1 for question
        }
    }
}
?>
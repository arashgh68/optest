<?php
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 12/18/2018
 * Time: 2:33 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class tag_manager_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function get_tags($parent_id,$tagtype)
    {
        return $this->db->get_where('tag',array('tag_type'=>$tagtype,'parent_id'=>$parent_id))->result();
    }

    public function add_to_tag($taglist, $parentid,$tagtype)
    {
        foreach($taglist as $tag) {
            $newrow = array(
                'parent_id' => $parentid,
                'tag_name' => $tag,
                'tag_type'=>$tagtype,
                'tag_importance' => date("Y/m/d"),
            );
            $this->db->insert('tag', $newrow);
        }
    }
    public function get_taglist($paretnt_id,$tagtype)
    {
        $this->db->select('tag_name');
        $this->db->from('tag');
        $this->db->where('parent_id',$paretnt_id);
        $this->db->where('tag_type',$tagtype);
        $query =  $this->db->get();
        return $query->result();
    }

    public function delete_tag($parent_id,$tagtype) //deletes all tags related to some parent
    {
        $this->db->where('parent_id',$parent_id);
        $this->db->where('tag_type',$tagtype);
        $this->db->delete('tag');
    }

    public function get_all_tags_list($tagtype)
    {
        $this->db->distinct('tag_name');
        $this->db->select('tag_name');
        $this->db->from('tag');
        $this->db->where('tag_type',$tagtype);
        $query=$this->db->get();
        return $query->result();
    }
}

?>
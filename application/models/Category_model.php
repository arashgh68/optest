<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 3/14/2019
 * Time: 9:27 AM
 */

class Category_model extends CI_Model
{
    public function get_categories()
    {
        $this->db->select('*');
        $this->db->from('category');
        $query = $this->db->get();

        return $query->result();
    }
}
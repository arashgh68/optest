<?php

/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 12/15/2018
 * Time: 9:21 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
//pagination
$config = array();
$config['base_url']='';

$config["total_rows"] = 200;
$config['per_page'] = 5;

$config["uri_segment"] = 4;
// custom paging configuration
//pageconfig for bootstrap pagination class integration
$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
$config['full_tag_close'] = '</ul>';
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
$config['cur_tag_close'] = '</a></li>';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tagl_close'] = '</a></li>';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tagl_close'] = '</li>';
$config['first_tag_open'] = '<li class="page-item">';
$config['first_tagl_close'] = '</li>';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tagl_close'] = '</a></li>';
$config['attributes'] = array('class' => 'page-link');

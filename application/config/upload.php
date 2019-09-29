<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 1/24/2019
 * Time: 12:10 PM
 */
//upload configs
$config = array();
$config['upload_path']          = './uploads/';
$config['allowed_types']        = '*';
$config['max_size']             = 1000;
$config['remove_spaces'] = TRUE;
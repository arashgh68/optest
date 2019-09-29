<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:58 PM
 */

//temporary for develop
class Migrate extends CI_Controller
{

    public function index()
    {
        $this->load->library('migration');

        echo "<pre>";
        print_r($this->migration->find_migrations());
        echo "</pre>";
    }

    public function latest()
    {
        $this->load->library('migration');

        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "migration OK";
        }
    }

    public function reset()
    {
        $this->load->library('migration');

        if ($this->migration->version(0) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "migration OK";
        }
    }

    public function ver($version)
    {
        $this->load->library('migration');

        if ($this->migration->version($version) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "migration OK";
        }
    }

}
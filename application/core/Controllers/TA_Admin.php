<?php

class TA_Admin extends CI_Controller
{

    protected $data;
    protected $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->verify_auth();

        $this->data = array();
        $this->data['scripts'] = array();
        $this->data['styles'] = array();
        $this->data['page_title'] = "";
        $this->data['active_menu'] = "";
        $this->data['site_name'] = $this->config->item('site_name');
    }

    //for user verify
    protected function verify_auth($redirect_url = 'auth/login')
    {
        // obtain user data from session; redirect to Login page if not found
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect($redirect_url);
        } else {
            $this->user_id = $this->ion_auth->get_user_id();
        }
    }

    protected function render($view_file)
    {
        //load header for all page site
        $this->load->view('admin/header', $this->data);

        //load page
        $this->load->view('admin/' . $view_file);

        //load footer for all page
        $this->load->view('admin/footer');
    }
}
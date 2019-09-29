<?php

class TA_Controller extends CI_Controller{

	protected $data;
	protected $user_id;
	protected $user;
    public function __construct()
	{
		parent::__construct();

		$this->data = array();
		$this->data['script'] = "";
		$this->data['style'] = "";
		$this->data['page_title'] = "";
        $this->data['active_menu'] = "";
        $this->data['logged'] = false;

		$this->data['site_name'] = $this->config->item('site_name');

        if ($this->ion_auth->logged_in()) {
            $this->user_id = $this->ion_auth->get_user_id();
            $this->user = $this->ion_auth->user()->row();
            $this->data['logged'] = true;
        }
    }
    
    //for user verify
    protected function verify_auth($redirect_url = 'auth/login')
	{
		// obtain user data from session; redirect to Login page if not found
		if ($this->ion_auth->logged_in()) {
            $this->user_id = $this->ion_auth->get_user_id();
            $this->user = $this->ion_auth->user()->row();
        }
		else
			redirect($redirect_url);
    }
    
    protected function render($view_file){
        //load header for all page site
		$this->load->view('header',$this->data);
		
		//load page
		$this->load->view($view_file);

		//load footer for all page
        $this->load->view( 'footer');
    }

    protected function renderPanel($view_file){
        //load header for all page site
		$this->load->view('header-panel',$this->data);
		
		//load page
		$this->load->view($view_file);

        $this->load->view( 'footer-panel');
    }
}

//added temporary for admin in one application remove if move!
require APPPATH."core/controllers/TA_Admin.php";
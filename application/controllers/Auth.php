<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for (all) non logged in users
 */
class Auth extends MY_Controller {	

	public function logged_in_check()
	{
		if ($this->session->userdata("logged_in")) {
			redirect("dashboard");
		}
	}

	public function index()
	{	
		$this->logged_in_check();
		
		$this->load->library('form_validation');
		//$this->_rules();
		$this->form_validation->set_rules("username", "Username", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		
		if ($this->form_validation->run() == true) 
		{
			$this->load->model('auth_model', 'auth');	
			// check the username & password of user
			$status = $this->auth->validate();
			
			if ($status == "ERR_INVALID_USERNAME") {
			//if ($status == "Username") {
				$this->session->set_flashdata("error", "Username is invalid");
			}
			elseif ($status == "ERR_INVALID_PASSWORD") {
			//elseif ($status == "Password") {
				$this->session->set_flashdata("error", "Password is invalid");
			}
			else
			{
				// success
				
				// store the user data to session
				$this->session->set_userdata($this->auth->get_data());
				$this->session->set_userdata("logged_in", true);
				/* $level = $this->auth->get_role($username);
				echo $level;
				$this->session->set_userdata("level",$level); */
				// redirect to dashboard
				redirect("dashboard");
			}
		}
		
		$this->load->view("auth");
	}

		
	public function logout()
	{
		$this->session->unset_userdata("logged_in");
		$this->session->sess_destroy();
		redirect("auth");
	}
 
	public function _rules() 
    {
		$this->form_validation->set_rules('Username', 'username', 'trim|required');
		$this->form_validation->set_rules('Password', 'password', 'trim|required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
    }

	public function forget()
	{
		$this->load->view('forget');
	}

}
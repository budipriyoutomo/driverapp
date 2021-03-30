<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	private $table = "user";
	private $_data = array();

	public function validate()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->where("username", $username);
		$query = $this->db->get($this->table);

		if ($query->num_rows()) 
		{
			// found row by username	
			$row = $query->row_array();

			// now check for the password
			if ($row['password'] == sha1($password)) 
			{
				// we not need password to store in session
				unset($row['password']);
				$this->_data = $row;
				return 'ERR_NONE';
			}

			// password not match
			return "ERR_INVALID_PASSWORD";
			//return "Password";
		}
		else {
			// not found
			return "ERR_INVALID_USERNAME";
			//return "Username";
		}
	}

	public function get_data()
	{
		return $this->_data;
	}
	
	public function get_role($username){

		
		$this->db->where("username", $username);
		$query = $this->db->get($this->table);

		if ($query->num_rows()) 
		{
			$row = $query->row_array();

			if ($row['role'] == 'SuperAdmin') 
			{
				return 1;
			}
			elseif ($row['role'] == 'Admin') 
			{
				return 2;
			}
			else 
			{
				return 3;
				
			}

			
		}
	}
}
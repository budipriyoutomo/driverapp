<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Contact_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $contact = $this->Contact_model->get_all();

        $data = array(
            'contact_data' => $contact
        );
		$this->load->view('header');
        $this->load->view('contact/contact_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Contact_model->json();
    }

    public function read($id) 
    {
        $row = $this->Contact_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'alamat' => $row->alamat,
		'tlp' => $row->tlp,
		'email' => $row->email,
	    );
            
			$this->load->view('header');
            $this->load->view('contact/contact_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('contact'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('contact/create_action'),
	    'id' => set_value('id'),
	    'alamat' => set_value('alamat'),
	    'tlp' => set_value('tlp'),
	    'email' => set_value('email'),
	);

		$this->load->view('header');
		$this->load->view('contact/contact_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'alamat' => $this->input->post('alamat',TRUE),
		'tlp' => $this->input->post('tlp',TRUE),
		'email' => $this->input->post('email',TRUE),
	    );

            $this->Contact_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('contact'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Contact_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('contact/update_action'),
		'id' => set_value('id', $row->id),
		'alamat' => set_value('alamat', $row->alamat),
		'tlp' => set_value('tlp', $row->tlp),
		'email' => set_value('email', $row->email),
	    );
			$this->load->view('header');
			$this->load->view('contact/contact_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('contact'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'alamat' => $this->input->post('alamat',TRUE),
		'tlp' => $this->input->post('tlp',TRUE),
		'email' => $this->input->post('email',TRUE),
	    );

            $this->Contact_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('contact'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Contact_model->get_by_id($id);

			if ($row) {
				$this->Contact_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('contact'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('contact'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('contact'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('tlp', 'tlp', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "contact.xls";
        $judul = "contact";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
	xlsWriteLabel($tablehead, $kolomhead++, "Tlp");
	xlsWriteLabel($tablehead, $kolomhead++, "Email");

	foreach ($this->Contact_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tlp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->email);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=contact.doc");

        $data = array(
            'contact_data' => $this->Contact_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('contact/contact_doc',$data);
    }

}

/* End of file Contact.php */
/* Location: ./application/controllers/Contact.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-06 05:07:42 */
/* http://harviacode.com */
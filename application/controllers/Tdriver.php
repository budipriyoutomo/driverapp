<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tdriver extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tdriver_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $tdriver = $this->Tdriver_model->get_all();

        $data = array(
            'tdriver_data' => $tdriver
        );
		$this->load->view('header');
        $this->load->view('tdriver/tdriver_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tdriver_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tdriver_model->get_by_id($id);
        if ($row) {
            $data = array(
		'iddriver' => $row->iddriver,
		'Nama' => $row->Nama,
		'Activate' => $row->Activate,
	    );
            
			$this->load->view('header');
            $this->load->view('tdriver/tdriver_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tdriver'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tdriver/create_action'),
	    'iddriver' => set_value('iddriver'),
	    'Nama' => set_value('Nama'),
	    'Activate' => set_value('Activate'),
	);

		$this->load->view('header');
		$this->load->view('tdriver/tdriver_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'Nama' => $this->input->post('Nama',TRUE),
		'Activate' => $this->input->post('Activate',TRUE),
	    );

            $this->Tdriver_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tdriver'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tdriver_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tdriver/update_action'),
		'iddriver' => set_value('iddriver', $row->iddriver),
		'Nama' => set_value('Nama', $row->Nama),
		'Activate' => set_value('Activate', $row->Activate),
	    );
			$this->load->view('header');
			$this->load->view('tdriver/tdriver_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tdriver'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('iddriver', TRUE));
        } else {
            $data = array(
		'Nama' => $this->input->post('Nama',TRUE),
		'Activate' => $this->input->post('Activate',TRUE),
	    );

            $this->Tdriver_model->update($this->input->post('iddriver', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tdriver'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Tdriver_model->get_by_id($id);

			if ($row) {
				$this->Tdriver_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('tdriver'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('tdriver'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('tdriver'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('Nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('Activate', 'activate', 'trim|required');

	$this->form_validation->set_rules('iddriver', 'iddriver', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tdriver.xls";
        $judul = "tdriver";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Activate");

	foreach ($this->Tdriver_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Activate);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tdriver.doc");

        $data = array(
            'tdriver_data' => $this->Tdriver_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('tdriver/tdriver_doc',$data);
    }

}

/* End of file Tdriver.php */
/* Location: ./application/controllers/Tdriver.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-05-09 10:54:00 */
/* http://harviacode.com */
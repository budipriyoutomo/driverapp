<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Thpr extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Thpr_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $thpr = $this->Thpr_model->get_all();

        $data = array(
            'thpr_data' => $thpr
        );
		$this->load->view('header');
        $this->load->view('thpr/thpr_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Thpr_model->json();
    }

    public function read($id) 
    {
        $row = $this->Thpr_model->get_by_id($id);
        if ($row) {
            $data = array(
		'docCode' => $row->docCode,
		'date' => $row->date,
		'ETA' => $row->ETA,
		'PIC' => $row->PIC,
		'id' => $row->id,
	    );
            
			$this->load->view('header');
            $this->load->view('thpr/thpr_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thpr'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('thpr/create_action'),
	    'docCode' => set_value('docCode'),
	    'date' => set_value('date'),
	    'ETA' => set_value('ETA'),
	    'PIC' => set_value('PIC'),
	    'id' => set_value('id'),
	);

		$this->load->view('header');
		$this->load->view('thpr/thpr_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'docCode' => $this->input->post('docCode',TRUE),
		'date' => $this->input->post('date',TRUE),
		'ETA' => $this->input->post('ETA',TRUE),
		'PIC' => $this->input->post('PIC',TRUE),
	    );

            $this->Thpr_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('thpr'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Thpr_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('thpr/update_action'),
		'docCode' => set_value('docCode', $row->docCode),
		'date' => set_value('date', $row->date),
		'ETA' => set_value('ETA', $row->ETA),
		'PIC' => set_value('PIC', $row->PIC),
		'id' => set_value('id', $row->id),
	    );
			$this->load->view('header');
			$this->load->view('thpr/thpr_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('thpr'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'docCode' => $this->input->post('docCode',TRUE),
		'date' => $this->input->post('date',TRUE),
		'ETA' => $this->input->post('ETA',TRUE),
		'PIC' => $this->input->post('PIC',TRUE),
	    );

            $this->Thpr_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('thpr'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Thpr_model->get_by_id($id);

			if ($row) {
				$this->Thpr_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('thpr'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('thpr'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('thpr'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('docCode', 'doccode', 'trim|required');
	$this->form_validation->set_rules('date', 'date', 'trim|required');
	$this->form_validation->set_rules('ETA', 'eta', 'trim|required');
	$this->form_validation->set_rules('PIC', 'pic', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "thpr.xls";
        $judul = "thpr";
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
	xlsWriteLabel($tablehead, $kolomhead++, "DocCode");
	xlsWriteLabel($tablehead, $kolomhead++, "Date");
	xlsWriteLabel($tablehead, $kolomhead++, "ETA");
	xlsWriteLabel($tablehead, $kolomhead++, "PIC");

	foreach ($this->Thpr_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->docCode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->date);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ETA);
	    xlsWriteLabel($tablebody, $kolombody++, $data->PIC);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=thpr.doc");

        $data = array(
            'thpr_data' => $this->Thpr_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('thpr/thpr_doc',$data);
    }

}

/* End of file Thpr.php */
/* Location: ./application/controllers/Thpr.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-24 09:49:49 */
/* http://harviacode.com */
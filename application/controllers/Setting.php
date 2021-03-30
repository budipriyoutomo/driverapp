<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $setting = $this->Setting_model->get_all();

        $data = array(
            'setting_data' => $setting
        );
		$this->load->view('header');
        $this->load->view('setting/setting_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Setting_model->json();
    }

    public function read($id) 
    {
        $row = $this->Setting_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'copyright' => $row->copyright,
	    );
            
			$this->load->view('header');
            $this->load->view('setting/setting_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('setting/create_action'),
	    'id' => set_value('id'),
	    'copyright' => set_value('copyright'),
	);

		$this->load->view('header');
		$this->load->view('setting/setting_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'copyright' => $this->input->post('copyright',TRUE),
	    );

            $this->Setting_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('setting'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Setting_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('setting/update_action'),
		'id' => set_value('id', $row->id),
		'copyright' => set_value('copyright', $row->copyright),
	    );
			$this->load->view('header');
			$this->load->view('setting/setting_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('setting'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'copyright' => $this->input->post('copyright',TRUE),
	    );

            $this->Setting_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('setting'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Setting_model->get_by_id($id);

			if ($row) {
				$this->Setting_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('setting'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('setting'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('setting'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('copyright', 'copyright', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "setting.xls";
        $judul = "setting";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Copyright");

	foreach ($this->Setting_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->copyright);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=setting.doc");

        $data = array(
            'setting_data' => $this->Setting_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('setting/setting_doc',$data);
    }

}

/* End of file Setting.php */
/* Location: ./application/controllers/Setting.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-06 05:07:43 */
/* http://harviacode.com */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class About extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('About_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $about = $this->About_model->get_all();

        $data = array(
            'about_data' => $about
        );
		$this->load->view('header');
        $this->load->view('about/about_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->About_model->json();
    }

    public function read($id) 
    {
        $row = $this->About_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'judul' => $row->judul,
		'keterangan' => $row->keterangan,
	    );
            
			$this->load->view('header');
            $this->load->view('about/about_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('about'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('about/create_action'),
	    'id' => set_value('id'),
	    'judul' => set_value('judul'),
	    'keterangan' => set_value('keterangan'),
	);

		$this->load->view('header');
		$this->load->view('about/about_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->About_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('about'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->About_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('about/update_action'),
		'id' => set_value('id', $row->id),
		'judul' => set_value('judul', $row->judul),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
			$this->load->view('header');
			$this->load->view('about/about_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('about'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->About_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('about'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->About_model->get_by_id($id);

			if ($row) {
				$this->About_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('about'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('about'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('about'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "about.xls";
        $judul = "about";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Judul");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

	foreach ($this->About_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->judul);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=about.doc");

        $data = array(
            'about_data' => $this->About_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('about/about_doc',$data);
    }

}

/* End of file About.php */
/* Location: ./application/controllers/About.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-06 05:07:41 */
/* http://harviacode.com */
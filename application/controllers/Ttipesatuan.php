<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ttipesatuan extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ttipesatuan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'ttipesatuan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'ttipesatuan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'ttipesatuan/index.html';
            $config['first_url'] = base_url() . 'ttipesatuan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Ttipesatuan_model->total_rows($q);
        $ttipesatuan = $this->Ttipesatuan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'ttipesatuan_data' => $ttipesatuan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
		
        $this->load->view('ttipesatuan/ttipesatuan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Ttipesatuan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'idsatuan' => $row->idsatuan,
		'nama' => $row->nama,
		'parent' => $row->parent,
		'rumus' => $row->rumus,
		'id' => $row->id,
	    );
            
			$this->load->view('header');
            $this->load->view('ttipesatuan/ttipesatuan_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ttipesatuan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('ttipesatuan/create_action'),
	    'idsatuan' => set_value('idsatuan'),
	    'nama' => set_value('nama'),
	    'parent' => set_value('parent'),
	    'rumus' => set_value('rumus'),
	    'id' => set_value('id'),
	);

		$this->load->view('header');
		$this->load->view('ttipesatuan/ttipesatuan_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'idsatuan' => $this->input->post('idsatuan',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'parent' => $this->input->post('parent',TRUE),
		'rumus' => $this->input->post('rumus',TRUE),
	    );

            $this->Ttipesatuan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ttipesatuan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Ttipesatuan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('ttipesatuan/update_action'),
		'idsatuan' => set_value('idsatuan', $row->idsatuan),
		'nama' => set_value('nama', $row->nama),
		'parent' => set_value('parent', $row->parent),
		'rumus' => set_value('rumus', $row->rumus),
		'id' => set_value('id', $row->id),
	    );
			$this->load->view('header');
			$this->load->view('ttipesatuan/ttipesatuan_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ttipesatuan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'idsatuan' => $this->input->post('idsatuan',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'parent' => $this->input->post('parent',TRUE),
		'rumus' => $this->input->post('rumus',TRUE),
	    );

            $this->Ttipesatuan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ttipesatuan'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Ttipesatuan_model->get_by_id($id);

			if ($row) {
				$this->Ttipesatuan_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('ttipesatuan'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('ttipesatuan'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('ttipesatuan'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('idsatuan', 'idsatuan', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('parent', 'parent', 'trim|required');
	$this->form_validation->set_rules('rumus', 'rumus', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "ttipesatuan.xls";
        $judul = "ttipesatuan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Idsatuan");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Parent");
	xlsWriteLabel($tablehead, $kolomhead++, "Rumus");

	foreach ($this->Ttipesatuan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->idsatuan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->parent);
	    xlsWriteLabel($tablebody, $kolombody++, $data->rumus);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=ttipesatuan.doc");

        $data = array(
            'ttipesatuan_data' => $this->Ttipesatuan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('ttipesatuan/ttipesatuan_doc',$data);
    }

}

/* End of file Ttipesatuan.php */
/* Location: ./application/controllers/Ttipesatuan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-09-20 06:09:40 */
/* http://harviacode.com */
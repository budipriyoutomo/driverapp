<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Titem extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Titem_model');
		$this->load->model('Master');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $titem = $this->Titem_model->get_all();

        $data = array(
            'titem_data' => $titem
        );
		$this->load->view('header');
        $this->load->view('titem/titem_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Titem_model->json();
		//echo $this->Titem_model->json2();
    }

    public function read($id) 
    {
        $row = $this->Titem_model->get_by_id($id);
        if ($row) {
            $data = array(
		'itemcode' => $row->itemcode,
		'nama' => $row->nama,
		'idsatuan' => $row->idsatuan,
		'satuan' => $row->satuan,
		'id' => $row->id,
	    );
            
			$this->load->view('header');
            $this->load->view('titem/titem_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('titem'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('titem/create_action'),
	    'itemcode' => set_value('itemcode'),
	    'nama' => set_value('nama'),
	    'idsatuan' => set_value('idsatuan'),
		'satuan' => set_value('satuan'),
	    'id' => set_value('id'),
	);
		
		$combo['query']= $this->Master->gettipesatuan("");

		$this->load->view('header',$combo);
			
		$this->load->view('titem/titem_form', $data);
        $this->load->view('footer');
        
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'itemcode' => $this->input->post('itemcode',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'idsatuan' => $this->input->post('idsatuan',TRUE),
	    );

            $this->Titem_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('titem'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Titem_model->get_by_id($id);
		
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('titem/update_action'),
				'itemcode' => set_value('itemcode', $row->itemcode),
				'nama' => set_value('nama', $row->nama),
				'idsatuan' => set_value('idsatuan', $row->idsatuan),
				'satuan' => set_value('satuan', $row->satuan),
				'id' => set_value('id', $row->id),
				);
				
			$combo['query']= $this->Master->gettipesatuan($row->idsatuan);
			$this->load->view('header',$combo);
			
			$this->load->view('titem/titem_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('titem'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'itemcode' => $this->input->post('itemcode',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'idsatuan' => $this->input->post('idsatuan',TRUE),
	    );

            $this->Titem_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('titem'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Titem_model->get_by_id($id);

			if ($row) {
				$this->Titem_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('titem'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('titem'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('titem'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('itemcode', 'itemcode', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('idsatuan', 'idsatuan', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "titem.xls";
        $judul = "titem";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Itemcode");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Idsatuan");

	foreach ($this->Titem_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->itemcode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->idsatuan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=titem.doc");

        $data = array(
            'titem_data' => $this->Titem_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('titem/titem_doc',$data);
    }

}

/* End of file Titem.php */
/* Location: ./application/controllers/Titem.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-24 18:22:33 */
/* http://harviacode.com */
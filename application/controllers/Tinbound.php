<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tinbound extends MY_Controller {

	protected $access = array('SuperAdmin','Admin');

    function __construct()
    {
        parent::__construct();
		$this->load->model('Master');
        $this->load->model('Tinbound_model');
        $this->load->library('form_validation');
		$this->load->library('datatables');
    }

    public function index()
    {
	    $tinbound = $this->Tinbound_model->get_all();

        $data = array(
            'tinbound_data' => $tinbound
        );
		$this->load->view('header');
        $this->load->view('tinbound/tinbound_list', $data);
        $this->load->view('footer');


    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->Tinbound_model->json();
    }

    public function read($id)
    {
        $row = $this->Tinbound_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'iddriver' => $row->iddriver,
        'Tanggal' => $row->Tanggal,
        'Tipe' => $row->Tipe,
		'Masuk' => $row->Masuk,
		'Pulang' => $row->Pulang,
	    );

			$this->load->view('header');
            $this->load->view('tinbound/tinbound_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tinbound'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tinbound/create_action'),
	    'id' => set_value('id'),
	    'iddriver' => set_value('iddriver'),
        'Tanggal' => set_value('Tanggal'),
        'Tipe' => set_value('Tipe'),
	    'Masuk' => set_value('Masuk'),
	    'Pulang' => set_value('Pulang'),
	);

	$combo['query']= $this->Master->getdriver("");

	$this->load->view('header',$combo);


		$this->load->view('tinbound/tinbound_form', $data);
        $this->load->view('footer');


    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'iddriver' => $this->input->post('iddriver',TRUE),
        'Tanggal' => date("Y-m-d",strtotime($this->input->post('Tanggal',TRUE))),
        'Tipe' => $this->input->post('tipe',TRUE),
		'Masuk' => date("H:i",strtotime($this->input->post('Masuk',TRUE))),
		'Pulang' => date("H:i",strtotime($this->input->post('Pulang',TRUE))),
	    );

            $this->Tinbound_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tinbound'));
        }
    }

    public function update($id)
    {
		
		  
        $row = $this->Tinbound_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tinbound/update_action'),
		'id' => set_value('id', $row->id),
		'iddriver' => set_value('iddriver', $row->iddriver),
        'namadriver' => set_value('iddriver', $row->Nama),
        'Tanggal' => set_value('Tanggal', $row->Tanggal),
        'Tipe' => set_value('Tipe', $row->tipe),
		'Masuk' => set_value('Masuk', $row->Masuk),
		'Pulang' => set_value('Pulang', $row->Pulang),
	    );
		$combo['query']= $this->Master->getdriver($row->iddriver);

		$this->load->view('header',$combo);


			$this->load->view('tinbound/tinbound_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tinbound'));
        }
	  
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(

		'iddriver' => $this->input->post('iddriver',TRUE),
        'Tanggal' => date("Y-m-d",strtotime($this->input->post('Tanggal',TRUE))),
        'tipe' => $this->input->post('tipe',TRUE),
		'Masuk' => date("H:i",strtotime($this->input->post('Masuk',TRUE))),
		'Pulang' => date("H:i",strtotime($this->input->post('Pulang',TRUE))),
	    );

            $this->Tinbound_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tinbound'));
        }
    }

    public function delete($id)
    {
     	$level = $this->session->userdata('role') ;

		if ($level!='User')
		{
			$row = $this->Tinbound_model->get_by_id($id);

			if ($row) {
				$this->Tinbound_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('tinbound'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('tinbound'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('tinbound'));

		}
    }

    public function _rules()
    {
	$this->form_validation->set_rules('iddriver', 'iddriver', 'trim|required');
	$this->form_validation->set_rules('Tanggal', 'tanggal', 'trim|required');
	$this->form_validation->set_rules('Masuk', 'masuk', 'trim|required');
	$this->form_validation->set_rules('Pulang', 'pulang', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tinbound.xls";
        $judul = "tinbound";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Iddriver");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Masuk");
	xlsWriteLabel($tablehead, $kolomhead++, "Pulang");

	foreach ($this->Tinbound_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->iddriver);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Tanggal);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Masuk);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Pulang);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tinbound.doc");

        $data = array(
            'tinbound_data' => $this->Tinbound_model->get_all(),
            'start' => 0
        );

        $this->load->view('tinbound/tinbound_doc',$data);
    }

}

/* End of file Tinbound.php */
/* Location: ./application/controllers/Tinbound.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-06-01 17:36:16 */
/* http://harviacode.com */

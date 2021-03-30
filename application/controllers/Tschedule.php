<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tschedule extends MY_Controller {

	protected $access = array('SuperAdmin','Admin', 'User');

    function __construct()
    {
        parent::__construct();

		    $this->load->model('Master');
        $this->load->model('Tschedule_model');
        $this->load->library('form_validation');
	      $this->load->library('datatables');
    }

    public function index()
    {

    $row = $this->Tschedule_model->get_bydate(date("Y-m-01"));
    //print_r($row);
    foreach($row as $rowq){
      $this->Tschedule_model->delete($rowq->ID);
    }

		$level = $this->session->userdata('role');

		if ($level!='User'){
			$tschedule = $this->Tschedule_model->get_all();
		}else{
			$tschedule = $this->Tschedule_model->get_byuser();
		}


        $data = array(
            'tschedule_data' => $tschedule
        );
		    $this->load->view('header');
        $this->load->view('tschedule/tschedule_list', $data);
        $this->load->view('footer');
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->Tschedule_model->json();
    }

    public function read($id)
    {
        $row = $this->Tschedule_model->get_by_id($id);
        if ($row) {
        $data = array(
      		'ID' => $row->ID,
      		'Tanggal' => $row->Tanggal,
      		'Jam' => $row->Jam,
      		'Tujuan' => $row->Tujuan,
      		'iddriver' => $row->iddriver,
      		'User' => $row->User,
      		'Status' => $row->Status,
    	    );

			$this->load->view('header');
            $this->load->view('tschedule/tschedule_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tschedule'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tschedule/create_action'),
	    'ID' => set_value('ID'),
	    'Tanggal' => set_value('Tanggal'),
	    'Jam' => set_value('Jam'),
	    'Tujuan' => set_value('Tujuan'),
	    'iddriver' => set_value('iddriver'),
		'namadriver' => set_value('namadriver'),
	    'User' => set_value('User'),
		'Status' => set_value('Status'),
	);
	$combo['query']= $this->Master->getdriver("");

	$this->load->view('header',$combo);

		$this->load->view('tschedule/tschedule_form', $data);
        $this->load->view('footer');

    }

    public function create_action()
    {
		//echo $this->_sekarang();
         $this->_rules();


        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
			$level = $this->session->userdata('role') ;
			if($level!='User'){
			$data = array(
				'Tanggal' => date("Y-m-d",strtotime($this->input->post('Tanggal',TRUE))),
				'Jam' => date("H:i",strtotime($this->input->post('Jam',TRUE))),
				//'Tujuan' => mysql_real_escape_string($this->input->post('Tujuan',TRUE)),
				'Tujuan' => str_replace(array("\r\n", "\n\r", "\n", "\r"), '<br />', $this->input->post('Tujuan',TRUE)),
				'iddriver' => $this->input->post('iddriver',TRUE),
				'User' => $this->input->post('User',TRUE),
				'Status' => $this->input->post('Status',TRUE),
				'createuser' => $this->input->post('User',TRUE),
				'createtime' => date('Y-m-d h:i:s'),
			);
			}else{
				$data = array(
				'Tanggal' => date("Y-m-d",strtotime($this->input->post('Tanggal',TRUE))),
				'Jam' => date("H:i",strtotime($this->input->post('Jam',TRUE))),
				//'Tujuan' => mysql_real_escape_string($this->input->post('Tujuan',TRUE)),
				'Tujuan' => str_replace(array("\r\n", "\n\r", "\n", "\r"), '<br />', $this->input->post('Tujuan',TRUE)),
				'iddriver' => 99,
				'User' => $this->input->post('User',TRUE),
				'Status' => 0,
				'createuser' => $this->input->post('User',TRUE),
				'createtime' => date('Y-m-d h:i:s'),

				);
			}


			//echo $data['Status'];
            $this->Tschedule_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tschedule'));
        }
    }

    public function update($id)
    {
        $row = $this->Tschedule_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tschedule/update_action'),
				'ID' => set_value('ID', $row->ID),
				'Tanggal' => set_value('Tanggal', date("d-m-Y",strtotime($row->Tanggal))),
				'Jam' => set_value('Jam', $row->Jam),
				'Tujuan' => set_value('Tujuan', nl2br($row->Tujuan)),
				'iddriver' => set_value('iddriver', $row->iddriver),
				'namadriver' => set_value('namadriver', $row->namadriver),
				'User' => set_value('User', $row->User),
				'Status' => set_value('Status', $row->Status),
			);

			$combo['query']= $this->Master->getdriver($row->iddriver);

			$this->load->view('header',$combo);

			$this->load->view('tschedule/tschedule_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tschedule'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('ID', TRUE));
        } else {
			$level = $this->session->userdata('role') ;
			if($level!='User'){

			$data = array(
				'Tanggal' => date("Y-m-d",strtotime($this->input->post('Tanggal',TRUE))),
				'Jam' => date("H:i",strtotime($this->input->post('Jam',TRUE))),
				//'Tujuan' => mysql_real_escape_string($this->input->post('Tujuan',TRUE)),
				'Tujuan' => str_replace(array("\r\n", "\n\r", "\n", "\r"), '<br />', $this->input->post('Tujuan',TRUE)),
				'iddriver' => $this->input->post('iddriver',TRUE),
				//'User' => $this->input->post('User',TRUE),
				'Status' => $this->input->post('Status',TRUE),
				'updateuser' => $this->input->post('User',TRUE),
				'updatetime' => date("Y-m-d h:i:s"),

				);
			}else {
			$data = array(
				'Tanggal' => date("Y-m-d",strtotime($this->input->post('Tanggal',TRUE))),
				'Jam' => date("H:i",strtotime($this->input->post('Jam',TRUE))),
				//'Tujuan' => mysql_real_escape_string($this->input->post('Tujuan',TRUE)),
				'Tujuan' => str_replace(array("\r\n", "\n\r", "\n", "\r"), '<br />', $this->input->post('Tujuan',TRUE)),
				'iddriver' => 99,
				//'User' => $this->input->post('User',TRUE),
				'Status' => 0,
				'updateuser' => $this->input->post('User',TRUE),
				'updatetime' => date("Y-m-d h:i:s"),
				);
			}

            $this->Tschedule_model->update($this->input->post('ID', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tschedule'));
        }
    }

    public function delete($id)
    {
     	$level = $this->session->userdata('role') ;

		if ($level!='User')
		{
			$row = $this->Tschedule_model->get_by_id($id);

			if ($row) {
				$this->Tschedule_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('tschedule'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('tschedule'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('tschedule'));

		}
    }


    public function _rules()
    {

		$level = $this->session->userdata('role') ;

		if($level!='User'){
			$this->form_validation->set_rules('Tanggal', 'tanggal', 'trim|required');
			$this->form_validation->set_rules('Jam', 'jam', 'trim|required');
			$this->form_validation->set_rules('Tujuan', 'tujuan', 'trim|required');
			$this->form_validation->set_rules('iddriver', 'iddriver', 'trim|required');
			$this->form_validation->set_rules('User', 'user', 'trim|required');
			$this->form_validation->set_rules('ID', 'ID', 'trim');
			$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		}else{
			$this->form_validation->set_rules('Tanggal', 'tanggal', 'trim|required');
			$this->form_validation->set_rules('Jam', 'jam', 'trim|required');
			$this->form_validation->set_rules('Tujuan', 'tujuan', 'trim|required');
		}

    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tschedule.xls";
        $judul = "tschedule";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
	xlsWriteLabel($tablehead, $kolomhead++, "Jam");
	xlsWriteLabel($tablehead, $kolomhead++, "Tujuan");
	xlsWriteLabel($tablehead, $kolomhead++, "Iddriver");
	xlsWriteLabel($tablehead, $kolomhead++, "User");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");

	foreach ($this->Tschedule_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Tanggal);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Jam);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Tujuan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->iddriver);
	    xlsWriteNumber($tablebody, $kolombody++, $data->User);
		xlsWriteNumber($tablebody, $kolombody++, $data->Status);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tschedule.doc");

        $data = array(
            'tschedule_data' => $this->Tschedule_model->get_all(),
            'start' => 0
        );

        $this->load->view('tschedule/tschedule_doc',$data);
    }

}

/* End of file Tschedule.php */
/* Location: ./application/controllers/Tschedule.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-10 04:19:34 */
/* http://harviacode.com */

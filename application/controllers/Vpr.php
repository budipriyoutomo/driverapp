<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vpr extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin', 'User');
	
    function __construct()
    {
        parent::__construct();
        $this->load->model('Vpr_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
	    $vpr = $this->Vpr_model->get_all();

        $data = array(
            'vpr_data' => $vpr
        );
		$this->load->view('header');
        $this->load->view('vpr/vpr_list', $data);
        $this->load->view('footer');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Vpr_model->json();
    }

    public function read($id) 
    {
        $row = $this->Vpr_model->get_by_id($id);
        if ($row) {
            $data = array(
		'docCode' => $row->docCode,
		'date' => $row->date,
		'ETA' => $row->ETA,
		'PIC' => $row->PIC,
		'source' => $row->source,
		'itemcode' => $row->itemcode,
		'UoM' => $row->UoM,
		'Ord_qty' => $row->Ord_qty,
		'status' => $row->status,
		'balancetodate' => $row->balancetodate,
		'dailyusage' => $row->dailyusage,
		'parstock' => $row->parstock,
	    );
            
			$this->load->view('header');
            $this->load->view('vpr/vpr_read', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('vpr'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('vpr/create_action'),
	    'docCode' => set_value('docCode'),
	    'date' => set_value('date'),
	    'ETA' => set_value('ETA'),
	    'PIC' => set_value('PIC'),
	    'source' => set_value('source'),
	    'itemcode' => set_value('itemcode'),
	    'UoM' => set_value('UoM'),
	    'Ord_qty' => set_value('Ord_qty'),
	    'status' => set_value('status'),
	    'balancetodate' => set_value('balancetodate'),
	    'dailyusage' => set_value('dailyusage'),
	    'parstock' => set_value('parstock'),
	);

		$this->load->view('header');
		$this->load->view('vpr/vpr_form', $data);
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
		'source' => $this->input->post('source',TRUE),
		'itemcode' => $this->input->post('itemcode',TRUE),
		'UoM' => $this->input->post('UoM',TRUE),
		'Ord_qty' => $this->input->post('Ord_qty',TRUE),
		'status' => $this->input->post('status',TRUE),
		'balancetodate' => $this->input->post('balancetodate',TRUE),
		'dailyusage' => $this->input->post('dailyusage',TRUE),
		'parstock' => $this->input->post('parstock',TRUE),
	    );

            $this->Vpr_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('vpr'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Vpr_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('vpr/update_action'),
		'docCode' => set_value('docCode', $row->docCode),
		'date' => set_value('date', $row->date),
		'ETA' => set_value('ETA', $row->ETA),
		'PIC' => set_value('PIC', $row->PIC),
		'source' => set_value('source', $row->source),
		'itemcode' => set_value('itemcode', $row->itemcode),
		'UoM' => set_value('UoM', $row->UoM),
		'Ord_qty' => set_value('Ord_qty', $row->Ord_qty),
		'status' => set_value('status', $row->status),
		'balancetodate' => set_value('balancetodate', $row->balancetodate),
		'dailyusage' => set_value('dailyusage', $row->dailyusage),
		'parstock' => set_value('parstock', $row->parstock),
	    );
			$this->load->view('header');
			$this->load->view('vpr/vpr_form', $data);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('vpr'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('', TRUE));
        } else {
            $data = array(
		'docCode' => $this->input->post('docCode',TRUE),
		'date' => $this->input->post('date',TRUE),
		'ETA' => $this->input->post('ETA',TRUE),
		'PIC' => $this->input->post('PIC',TRUE),
		'source' => $this->input->post('source',TRUE),
		'itemcode' => $this->input->post('itemcode',TRUE),
		'UoM' => $this->input->post('UoM',TRUE),
		'Ord_qty' => $this->input->post('Ord_qty',TRUE),
		'status' => $this->input->post('status',TRUE),
		'balancetodate' => $this->input->post('balancetodate',TRUE),
		'dailyusage' => $this->input->post('dailyusage',TRUE),
		'parstock' => $this->input->post('parstock',TRUE),
	    );

            $this->Vpr_model->update($this->input->post('', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('vpr'));
        }
    }
    
    public function delete($id) 
    {
     	$level = $this->session->userdata('role') ; 
	
		if ($level!='User') 
		{
			$row = $this->Vpr_model->get_by_id($id);

			if ($row) {
				$this->Vpr_model->delete($id);
				$this->session->set_flashdata('message', 'Delete Record Success');
				redirect(site_url('vpr'));
			} else {
				$this->session->set_flashdata('message', 'Record Not Found');
				redirect(site_url('vpr'));
			}
		}else{
			$this->session->set_flashdata('message', 'Access Denied');
			redirect(site_url('vpr'));
			
		}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('docCode', 'doccode', 'trim|required');
	$this->form_validation->set_rules('date', 'date', 'trim|required');
	$this->form_validation->set_rules('ETA', 'eta', 'trim|required');
	$this->form_validation->set_rules('PIC', 'pic', 'trim|required');
	$this->form_validation->set_rules('source', 'source', 'trim|required');
	$this->form_validation->set_rules('itemcode', 'itemcode', 'trim|required');
	$this->form_validation->set_rules('UoM', 'uom', 'trim|required');
	$this->form_validation->set_rules('Ord_qty', 'ord qty', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('balancetodate', 'balancetodate', 'trim|required');
	$this->form_validation->set_rules('dailyusage', 'dailyusage', 'trim|required');
	$this->form_validation->set_rules('parstock', 'parstock', 'trim|required');

	$this->form_validation->set_rules('', '', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "vpr.xls";
        $judul = "vpr";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Source");
	xlsWriteLabel($tablehead, $kolomhead++, "Itemcode");
	xlsWriteLabel($tablehead, $kolomhead++, "UoM");
	xlsWriteLabel($tablehead, $kolomhead++, "Ord Qty");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Balancetodate");
	xlsWriteLabel($tablehead, $kolomhead++, "Dailyusage");
	xlsWriteLabel($tablehead, $kolomhead++, "Parstock");

	foreach ($this->Vpr_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->docCode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->date);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ETA);
	    xlsWriteLabel($tablebody, $kolombody++, $data->PIC);
	    xlsWriteLabel($tablebody, $kolombody++, $data->source);
	    xlsWriteLabel($tablebody, $kolombody++, $data->itemcode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->UoM);
	    xlsWriteNumber($tablebody, $kolombody++, $data->Ord_qty);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status);
	    xlsWriteNumber($tablebody, $kolombody++, $data->balancetodate);
	    xlsWriteNumber($tablebody, $kolombody++, $data->dailyusage);
	    xlsWriteNumber($tablebody, $kolombody++, $data->parstock);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=vpr.doc");

        $data = array(
            'vpr_data' => $this->Vpr_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('vpr/vpr_doc',$data);
    }

}

/* End of file Vpr.php */
/* Location: ./application/controllers/Vpr.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-24 06:55:22 */
/* http://harviacode.com */
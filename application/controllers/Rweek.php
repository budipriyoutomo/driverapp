<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rweek extends MY_Controller {
	
	protected $access = array('SuperAdmin','Admin');
	
    function __construct()
    {
        parent::__construct();
		
		
		$this->load->model('Master');
        $this->load->model('Rweek_model');
        $this->load->library('form_validation');        
		//$this->load->library('datatables');
		//$this->load->library('M_pdf');
		
		
			
    }

    public function index()
    {
	
		$data = array(
            'button' => 'Generate',
            'action' => site_url('rweek/calc'),
			'generator' =>set_value('')
		);
		
		//$combo['query']= $this->Master->getdriver("");
		
		$this->load->view('header');
        $this->load->view('Rweek/Rweek_head',$data);
		$this->load->view('Rweek/Rweek_list');
        $this->load->view('footer'); 
		
		
		//$this->hitung();
    } 
	
	public function hitung(){
		$filename = time()."_order.pdf";
		
		$arg = array(
			'dari' => date("Y-m-d",strtotime(substr($this->input->post('tanggal',TRUE),0,10))),
			'sampai' => date("Y-m-d",strtotime(substr($this->input->post('tanggal',TRUE),13,10))),
		);
		
		$this->session->set_flashdata('tanggal', $arg);
		
		$data['query'] = $this->Rweek_model->getjadwal($arg);   
		
		$this->load->view('header');
		$this->load->view('Rweek/Rweek_head',$arg);
		$this->load->view('Rweek/Rweek_list',$data);
		$this->load->view('footer'); 

		
	 	$view = base_url()."temp/bootstrap/css/bootstrap.min.css";
        $stylesheet = file_get_contents($view);
		
		//$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
		//	$this->m_pdf->pdf->WriteHTML($html);
		
		
		//$this->m_pdf->pdf->Output($filename , "D"); 
		
	}
	

public function pdf(){
	
		$filename = time()."_jadwal.pdf";
		ob_start();
		//$htmlhead = $this->load->view('header');
		//$htmlRhead = $this->load->view('Rweek/Rweek_head');
		$html = $this->load->view('Rweek/rweek_list','',true);
		//$htmlRlist = $this->load->view('Rweek/rweek_list');
		//$htmlfooter = $this->load->view('footer'); 
		ob_end_clean();
		//$this->load->library('M_pdf');
		//$pdf = $this->pdf->load();
		$this->m_pdf->pdf->WriteHTML($html);
		$this->m_pdf->pdf->Output($filename, 'D'); 
		
		//$view = base_url()."temp/bootstrap/css/bootstrap.min.css";
        //$stylesheet = file_get_contents($view);
		
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML("<table class='table table-bordered table-striped' id='mytable'><thead><tr><th>Tanggal</th><th>Jam</th><th>Tujuan</th><th>Driver</th><th>Pengguna</th></tr></thead><tr><td>2018-05-14</td><td>06:00:00</td><td>engkel-loading frozen& dry all PVJ Loading jerigen FB</td><td>Nunuy</td><td>System Administrator</td></tr><tr><td>2018-05-14</td><td>09:00:00</td><td>sisil - bank</td><td>Yoni</td><td>System Administrator</td></tr><tr><td>2018-05-15</td><td>01:00:00</td><td>Barat</td><td>Yoni</td><td>System Administrator</td></tr><tr><td>2018-05-14</td><td>06:00:00</td><td>engkel-loading frozen& dry all PVJ\r\nLoading jerigen FB</td><td>Nunuy</td><td>System Administrator</td></tr><tr><td>2018-05-23</td><td>01:00:00</td><td>http://200.100.100.30/pRoMiSesystem6/login.aspx?ReturnUrl=/promisesystem6/default.aspx</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-16</td><td>01:00:00</td><td>asas</td><td>Nunuy</td><td>System Administrator</td></tr><tr><td>2018-05-16</td><td>01:00:00</td><td>Bandung</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-28</td><td>01:00:00</td><td>Bandun</td><td>Nunuy</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>Bandung</td><td>Soleh</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>CDE</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>qwqwq</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>za</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>Banduf</td><td>Soleh</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>qaa</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>lk</td><td>Indra</td><td>System Administrator</td></tr><tr><td>2018-05-31</td><td>01:00:00</td><td>asas</td><td>Indra</td><td>System Administrator</td></tr></table>");
		
		//$this->m_pdf->pdf->Output($filename , "I"); 
		
	
}
   
    public function json() {
        header('Content-Type: application/json');
        echo $this->Rweek_model->json();
    }

   

    public function excel()
    {
		$myVar = $this->session->flashdata('tanggal');
				
        $this->load->helper('exportexcel');
        $namaFile = "Rweek.xls";
        $judul = "Rweek";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Driver");
	xlsWriteLabel($tablehead, $kolomhead++, "Pengguna");

	foreach ($this->Rweek_model->getjadwal($myVar) as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Tanggal);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Jam);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Tujuan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->Driver);
	    xlsWriteLabel($tablebody, $kolombody++, $data->pengguna);
		

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit(); 
    }

    public function word()
    {
		if(isset($var)){
			echo "isset";
		}else{
			echo "no isset";
		}
      /*   header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Rweek.doc");

        $data = array(
            'Rweek_data' => $this->Rweek_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('Rweek/Rweek_doc',$data); */
    }

}

/* End of file Rweek.php */
/* Location: ./application/controllers/Rweek.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-10 04:19:34 */
/* http://harviacode.com */
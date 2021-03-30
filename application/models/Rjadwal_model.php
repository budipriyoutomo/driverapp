<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rjadwal_model extends CI_Model
{

    public $table = 'tschedule';
	//public $query = 'tschedule';
	public $query = "select Tanggal,Jam,Tujuan,Tdriver.Nama as driver, user.nama as pengguna from Tschedule,Tdriver,user where Tschedule.iddriver=Tdriver.iddriver and Tschedule.User = user.id and Tschedule.status=1";
    public $id = 'ID';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
	
	function getschedule($data){
		
		//$this->db->select('tschedule.Tanggal as Tanggal, tschedule.Jam as Jam, tschedule.Tujuan as Tujuan, tdriver.Nama as Driver,  tinbound.masuk as Masuk , tinbound.Pulang as Pulang, tinbound.tipe as Tipe');
		//$this->db->from('Tinbound');
		//$this->db->join('Tdriver','Tschedule.iddriver = Tdriver.iddriver');
		//$this->db->join('Tschedule','Tschedule.iddriver = Tinbound.iddriver and Tschedule.Tanggal = Tinbound.Tanggal','left');

		$select="select tinbound.tanggal as tanggal,ifnull(tschedule.jam,'N/A') as jam, ifnull(tschedule.tujuan,'N/A') as tujuan, tdriver.nama as Driver,tinbound.masuk as Masuk , tinbound.Pulang as Pulang, tinbound.tipe as Tipe ";
		$from = " from tinbound ";
		$join = " JOIN tdriver on tinbound.iddriver = tdriver.iddriver LEFT JOIN tschedule on tschedule.iddriver = tinbound.iddriver and tschedule.tanggal = tinbound.tanggal ";
		$where = " WHERE tinbound.Tanggal >= '". $data['dari'] . "' and tinbound.Tanggal <= '" . $data['sampai'] ."'";
		$order = " ORDER BY tdriver.iddriver, tinbound.Tanggal";
		$query = $select . $from . $join . $where . $order; 
		//print_r($query);
		$query = $this->db->query($query);

		//$query = $this->db->query("YOUR QUERY");

		//$this->db->where('Tinbound.Tanggal = ','Tschedule.Tanggal');
		//$where = "`Tschedule`.`Tanggal` = `Tinbound`.`Tanggal`" ; 
		//$this->db->where($where);

		//$this->db->where('Tschedule.Tanggal >=',$data['dari']);
		//$this->db->where('Tschedule.Tanggal <=',$data['sampai']);
		//$this->db->order_by('Tdriver.iddriver','ASC');
		//$this->db->order_by('Tschedule.Tanggal','ASC');
		
		//$query = $this->db->get();
		 //print_r($query->result());
		 return $query->result();
		
	}

	function getdayschedule($data){
		$this->db->distinct();
		$this->db->select('Tanggal');
		$this->db->from('Tinbound');
		$this->db->where('Tanggal >=',$data['dari']);
		$this->db->where('Tanggal <=',$data['sampai']);
		
		//$this->db->order_by('Tschedule.iddriver',DESC);
		$query = $this->db->get();
		 
		 return $query->result();
		
	}
	
	function getdriver($driver,$tanggal){
		
		$query = $this->db->query("select Tanggal,Jam,Tujuan,Tdriver.Nama as driver, user.nama as pengguna from Tschedule,Tdriver,user where Tschedule.iddriver=Tdriver.iddriver and Tschedule.User = user.id and Tschedule.status=1 and Tschedule.iddriver=".$driver." and Tschedule.tanggal='".$tanggal."'");
		return $query->result();
		
	}
	
    // datatables
    function json() {
        $this->datatables->select('DATE_FORMAT(Tanggal, "%d-%m-%Y") as Tanggal,Jam,Tujuan,Tdriver.nama as driver,User.nama as pengguna');
        $this->datatables->from('tschedule');
        //add this line for join
        $this->datatables->join('tdriver', 'tschedule.iddriver = tdriver.iddriver');
		$this->datatables->join('user', 'tschedule.user = user.id');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $query = $this->db->query("select Tanggal,Jam,Tujuan,Tdriver.Nama as driver, user.nama as pengguna from Tschedule,Tdriver,user where Tschedule.iddriver=Tdriver.iddriver and Tschedule.User = user.id and Tschedule.status=1 ");
		return $query->result();
    }

    // generate report 
    function get_by_drivertanggal($data)
    { 
	
     $Tanggal = $data['Tanggal'];
	 $iddriver = $data['iddriver'];
	 
	 if ($Tanggal!=null and $iddriver!=null){
		 $kondisi = " and Tschedule.iddriver=".$iddriver." and Tschedule.tanggal='".$Tanggal."'";
	 }else if ($Tanggal==null and $iddriver!=null){
		 $kondisi = " and Tschedule.iddriver=".$iddriver ;
	 }else if ($Tanggal!=null and $iddriver==null){
		 $kondisi = " and Tschedule.tanggal='".$Tanggal."'";
	 } else {
		 $kondisi = "";
	 }
		
		$query = $this->db->query("select Tanggal,Jam,Tujuan,Tdriver.Nama as driver, user.nama as pengguna from Tschedule,Tdriver,user where Tschedule.iddriver=Tdriver.iddriver and Tschedule.User = user.id and Tschedule.status=1 ".$kondisi);
		return $query->result();
		
		
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('ID', $q);
	$this->db->or_like('Tanggal', $q);
	$this->db->or_like('Jam', $q);
	$this->db->or_like('Tujuan', $q);
	$this->db->or_like('iddriver', $q);
	$this->db->or_like('User', $q);
	$this->db->or_like('Status', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('ID', $q);
	$this->db->or_like('Tanggal', $q);
	$this->db->or_like('Jam', $q);
	$this->db->or_like('Tujuan', $q);
	$this->db->or_like('iddriver', $q);
	$this->db->or_like('User', $q);
	$this->db->or_like('Status', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

   
   

}

/* End of file Rdriver_model.php */
/* Location: ./application/models/Rdriver_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-10 04:19:34 */
/* http://harviacode.com */
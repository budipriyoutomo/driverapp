<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

	function getdriver($iddriver){
		if($iddriver!=null){
			$kondisi =" where iddriver and iddriver <>".$iddriver;
		}else{
			$kondisi="  where iddriver ";
		}

		$query = $this->db->query("select iddriver,Nama  from tdriver".$kondisi);


		return $query->result();

	}
	function getcalendar(){

		$query = $this->db->query("select tschedule.id as id , Tanggal,Jam,Tujuan,tdriver.Nama as driver, user.nama as pengguna , tschedule.status as status from tschedule,tdriver,user where tschedule.iddriver=tdriver.iddriver and tschedule.User = user.id");
		return $query->result();

	}

	function getjadwal($driver,$tanggal){

		$query = $this->db->query("select Tanggal,Jam,Tujuan,tdriver.Nama as driver, user.nama as pengguna from tschedule,tdriver,user where tschedule.iddriver=tdriver.iddriver and tschedule.User = user.id and tschedule.status=1 and tschedule.iddriver=".$driver." and tschedule.tanggal='".$tanggal."'");
		return $query->result();

	}

	function getnotif(){
		$query = $this->db->query("select tschedule.ID as ID , Tanggal, user.nama as pengguna from tschedule,user where tschedule.User = user.id and tschedule.status=0 ");
		return $query->result();
	}

	function getcountnotif(){
		$query = $this->db->query("select user.nama from tschedule,user where tschedule.User = user.id and tschedule.status=0 ");
		return $query->num_rows();
	}
	function getinbound($data){
		$this->db->select('Nama, Tanggal, Masuk, Pulang,Tipe');
		$this->db->from('tinbound');
		$this->db->join('tdriver', 'tdriver.iddriver = tinbound.iddriver');
		$this->db->where('Tanggal >=',$data['dari']);
		$this->db->where('Tanggal <=',$data['sampai']);
		$this->db->order_by('Tanggal');
		$query = $this->db->get();
		return $query->result();

	}
}

/* End of file Titem_model.php */
/* Location: ./application/models/Titem_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-24 18:22:33 */
/* http://harviacode.com */
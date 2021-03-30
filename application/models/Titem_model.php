<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Titem_model extends CI_Model
{

    public $table = 'titem';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('titem.itemcode as itemcode,titem.nama as nama,Ttipesatuan.nama as satuan,titem.id as id');
        $this->datatables->from('titem');
		$this->datatables->join('Ttipesatuan', 'titem.idsatuan = Ttipesatuan.idsatuan ');
        //add this line for join
        //$this->datatables->join('table2', 'titem.field = table2.field');
        $this->datatables->add_column('action', anchor(site_url('titem/read/$1'),'Read')." | ".anchor(site_url('titem/update/$1'),'Update')." | ".anchor(site_url('titem/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }
	
   function json2() {
        $this->datatables->select('idsatuan, nama as satuan');
        $this->datatables->from('ttipesatuan');
		//add this line for join
        //$this->datatables->join('table2', 'titem.field = table2.field');
        //$this->datatables->add_column('action', anchor(site_url('titem/read/$1'),'Read')." | ".anchor(site_url('titem/update/$1'),'Update')." | ".anchor(site_url('titem/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }
	
    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        //$this->db->where($this->id, $id);
		$query = $this->db->query("select i.id,i.itemcode, i.nama,i.idsatuan,s.nama as satuan from Titem i, Ttipesatuan s where i.idsatuan=s.idsatuan and i.id=".$id);
		$row = $query->row();
        //return $this->db->get($this->table)->row();
		
		//$this->db->query->row();
		return $row;
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('itemcode', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('idsatuan', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('itemcode', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('idsatuan', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Titem_model.php */
/* Location: ./application/models/Titem_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-05-24 18:22:33 */
/* http://harviacode.com */
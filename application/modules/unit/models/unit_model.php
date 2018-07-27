<?php 
class Unit_model extends CI_Model{
	function __construct(){
		parent::__construct();
		// $this->load->database();
	}

	function insert_unit($data) {
		return $this->db->insert('unit',$data);
	}
	function insert_unit_hist($unit_id) {
		$data_input=$this->db->select("*")->from("unit")->where("unit_id",$unit_id)->get()->row();
		return $this->db->insert('unit_hist',$data_input);
	}
	function insert_unit_hist_delete($data,$unit_id) {
		$data_input=$this->db->select("*")->from("unit")->where("unit_id",$unit_id)->get()->row_array();
		$data_input=array_merge($data_input,$data);	
		return $this->db->insert('unit_hist',$data_input);
	}
	function fetch_units($data){
		$array = array('comp_id' => $data,'is_active' => 'Y' );
		$this->db->select("unit_id,unit")->from("unit")->where($array);
		return $this->db->get()->result();		
	}
	function update_unit($data,$unit_id) {
		$array = array('unit_id' => $unit_id,'is_active' => 'Y' );
		$this->db->set($data)->where($array)->update("unit");
		return $this->db->trans_complete();
	}
	function delete_unit($unit_id) {
		$array = array('unit_id' => $unit_id,'is_active' => 'Y' );
		$this->db->where($array);
		return $this->db->delete('unit');
	}
}
?>
<?php 
class android_voucher_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function insert_sv_exp($data) {
		return $this->db->insert('sv_daily_expenditure',$data);
	}

	function fetch_sv_exp($data){
		$this->db->select("*")->from("sv_daily_expenditure")->where($data)->order_by("doa");
		return $this->db->get()->result();		
	}
}
?>
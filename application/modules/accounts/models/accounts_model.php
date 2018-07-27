<?php 
class accounts_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function fetch_sv_exp($data){
		$this->db->select("*")->from("sv_daily_expenditure")->where($data)->order_by("doa");
		return $this->db->get()->result();		
	}
	function update_sv_exp($data,$sv_daily_exp_id){
		$array=array('sv_daily_exp_id'=>$sv_daily_exp_id);
		$this->db->set($data)->where($array)->update('sv_daily_expenditure');
		return $this->db->affected_rows();
	}
}
?>
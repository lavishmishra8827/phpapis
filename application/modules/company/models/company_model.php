<?php 
class Company_model extends CI_Model{
	function __construct(){
		parent::__construct();
		 $this->load->database();
	}

	function insert_company($data) {
		return $this->db->insert('company_master',$data);
	}
	function insert_company_hist($data) {
		$data_input=$this->db->select("*")->from("company_master")->where("comp_id",$data)->get()->row();
		return $this->db->insert('company_master_hist',$data_input);
	}
	function update_company($data,$comp_id)
	{
		$array = array('comp_id' => $comp_id,'is_active' => 'Y' );
		$this->db->set($data)->where($array)->update("company_master");
		return $this->db->trans_complete();
	}
	function get_all_company(){
		$this->db->select("*")->from("company_master");
		return $this->db->get()->result();		
	}
    
	function get_company($data){
		$array = array('comp_id' => $data,'is_active' => 'Y' );
		$this->db->select("*")->from("company_master")->where($array);
		return $this->db->get()->row();		
	}
}
?>
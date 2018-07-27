<?php 
class Role_model extends CI_Model{
	function __construct(){
		parent::__construct();
	 $this->load->database();
	}
	function insert_role($data) {
		return $this->db->insert('user_roles',$data);
	}
	function fetch_roles($data){
		$array = array('comp_id' => $data['comp_id'],'is_active' => 'Y' );
		$this->db->select("role_id,role,user_rights")->from("user_roles")->where($array);
		return $this->db->get()->result();		
	}
	function delete_role($data)
	{
		return $this->db->where($data)->delete('user_roles');
		
	}
	function delete_insert_hist($table1,$array,$table2,$data)
	{

		$data_input=$this->db->select("*")->from($table1)->where($array)->get()->row_array();
		//return $data_input;
		if($data_input)
		{
		$data_input=array_merge($data_input,$data);
		 $this->db->insert($table2,$data_input);
		 return $this->db->insert_id();
		}
		else
		{
			return -1;
		}

	}
}

?>
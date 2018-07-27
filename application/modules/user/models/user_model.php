<?php 
class User_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function fetch_user_id($person_id){
		$array = array('person_id' => $person_id,'is_active' => 'Y' );
		$this->db->select("user_id")->from("person")->where($array);
		return $this->db->get()->row();		
	}
	function fetch_user_password($user_id){
		$array = array('user_id' => $user_id,'is_active' => 'Y' );
		$this->db->select("password")->from("user_master")->where($array);
		return $this->db->get()->row();		
	}

	function fetch_comp_user($data){
		$array=array('p.comp_id'=>$data['comp_id'],'p.is_active'=>'Y');
		$this->db->select('p.person_id as pid,p.name as name,p.mob as mobile,q.name as add_name,u.username as username,c.cluster_name as cname,o.role as role',false);
		$this->db->from('person as p')->join('person as q','q.person_id=p.added_by')
				->join('user_master as u','p.user_id=u.user_id',"left")
				->join("user_roles as o","p.role_id=o.role_id")
				->join("cluster as c","p.cluster_id=c.cluster_id");
		$this->db->where($array);
		return $this->db->get()->result();
	}

	function fetch_person_profile($data){
		$array = array('person.comp_id'=>$data['comp_id'],'person_id'=>$data['person_id']);
		$this->db->select('*')->from('person');
		$this->db->join('user_roles','person.role_id=user_roles.role_id');
		$this->db->where($array);
		return $this->db->get()->row();
	}

	function fetch_person($data){
		$array = array('p.comp_id'=>$data['comp_id'],'p.person_id'=>$data['person_id']);
		$this->db->select('p.*,u.username',false)->from('person as p');
		$this->db->join('user_master as u','p.user_id=u.user_id');
		$this->db->where($array);
		return $this->db->get()->row();
	}

	function fetch_comp_supervisor($data){
		// $array=array('comp_id'=>$comp_id);
		$this->db->select('*')->from('person')->where($data);
		return $this->db->get()->result();
	}

	function insert_user_master_hist($id) {
		$data_input=$this->db->select("*")->from("user_master")->where("user_id",$id)->get()->row();
		return $this->db->insert('user_master_hist',$data_input);
	}
	function insert_person_hist($id) {
		$data_input=$this->db->select("*")->from("person")->where("person_id",$id)->get()->row();
		return $this->db->insert('person_hist',$data_input);
	}

	function update_user($id,$data){
		$array=array('user_id'=>$id,'is_active'=>'Y');
		$this->db->set($data)->where($array);
		$this->db->update('user_master');
		return $this->db->trans_complete();
	}

	function update_person($id,$data){
		$array=array('person_id'=>$id,'is_active'=>'Y');
		$this->db->set($data)->where($array);
		$this->db->update('person');
		return $this->db->trans_complete();
	}

	function fetch_all_supervisors($table,$data)
	{
		$this->db->select("*")->from($table)->where($data);
		return $this->db->get()->result();
	}
	function delete_supervisor($table,$data)
	{
		 $this->db->where($data)->delete($table);
		 //$this->db->trans_complete();
		 return $this->db->affected_rows();
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
	function update($table,$data,$array)
	{
		 $this->db->set($data)->where($array)->update($table);
		 return $this->db->affected_rows();
	}
	
}
?>
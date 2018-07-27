<?php 
class Registration_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	 function fetch_supervisor($data){
		$array=array('username'=>$data['username'],'password'=>$data['password']);
		$this->db->select('*')->from('user_master');
		$this->db->where($array);
		return $this->db->get()->row();
	}
	function insert_log_details($data){
		$this->db->insert('login_log',$data);
		return $this->db->insert_id();

	}
	function check_login($data_input){
		$this->db->select('*')->from('user_master')->where($data_input);
		return $this->db->get()->row();
	}
	function insert_user_master_data($data_user){
		$this->db->insert('user_master',$data_user);
		return $this->db->insert_id();
	}
	function insert_supervisor_data($data_input){
		$this->db->insert('supervisor',$data_input);
		return $this->db->insert_id();
	}
	function insert_person_data($data_input){
		$this->db->insert('person',$data_input);
		return $this->db->insert_id();
	}
	function fetch_person_id($user_id){
		$array = array('user_id'=>$user_id);
		$this->db->select('person_id')->from('person')->where($array);
		return $this->db->get()->row();
	}
	function insert_data($table,$log_input){
		$this->db->insert($table,$log_input);
		return $this->db->insert_id();
	}
	function fetch_all_usernames(){
		$this->db->select('username')->from('user_master');
		return $this->db->get()->result();
	}
	function check_unique($table,$data){
		$this->db->select('*')->from($table);
		$this->db->where($data);
		return $this->db->get()->row();
	}
}
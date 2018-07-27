<?php 
class Apiformer_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	/*
	give all the names you want.
	$selection:- comma seperated string of fields you want from the table for ex:-'name,id' or 'value,name,cluster_id,site_name' or '*'
	$table:-table from which you want to select values
	$where_conditions:-this should be an associative array of fields and corresponding values you want to put in the where clause for ex:- $where_conditions['user_id']=1;$where_conditions['comp_id']=2;$where_conditions['user_name']='abc'; and pass from controller to be stored in the $where_conditions
	*/
	function select($selection,$table,$where_conditions)
	{
		$this->db->select($selection)->from($table)->where($where_conditions);
		return $this->db->get()->result();
	}
	/*
		give all the names you want.
		$table:-table from which you want to delete the data
		$where_conditions:-this should be an associative array of fields and corresponding values you want to put in the where clause for ex:- $where_conditions['user_id']=1;$where_conditions['comp_id']=2;$where_conditions['user_name']='abc'; and pass from controller to be stored in the $where_conditions
	*/
	function delete($table,$where_conditions)
	{
		return $this->db->where($where_conditions)->delete($table);
	}
	/*
		$table:-table in which you want to update the data
		$data:-full row of data which is to be updated.this should also be an associative array which contains keys as column names and values as corresponding column values.
		$where_conditions:-this should be an associative array of fields and corresponding values you want to put in the where clause for ex:- $where_conditions['user_id']=1;$where_conditions['comp_id']=2;$where_conditions['user_name']='abc'; and pass from controller to be stored in the $where_conditions
	*/
	function update($table,$data,$where_conditions)
	{
		 $this->db->set($data)->where($where_conditions)->update($table);
		 return $this->db->affected_rows();
	}
	/*
		$table:-table in which you want to update the data
		$data:-full row of data which is to be inserted.this should also be an associative array which contains keys as column names and values as corresponding column values.
	*/

	function insert($table,$data)
	{
		return $this->db->insert($table,$data);
	}
	/*
		$table1:-the table from which data will go in the history table
		$table2:-corresponding history table
		$where_conditions:-this should be an associative array of fields and corresponding values you want to put in the where clause for ex:- $where_conditions['user_id']=1;$where_conditions['comp_id']=2;$where_conditions['user_name']='abc'; and pass from controller to be stored in the $where_conditions
		$data:-extra data like dod or deleted by which is to be appended to the data from $table1 and then inserted in the $table2.this should also be an associative array which contains columnnames as key values and their values as corresponding values.


	*/
	function insert_hist($table1,$where_conditions,$table2,$data)
	{

		$data_input=$this->db->select("*")->from($table1)->where($where_conditions)->get()->row_array();
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
	/*
		$tables is a an array which is 
	*/
	/*function select_with_join($tables,$join_conditions,$where_conditions)
	{
		$tables_size=sizeof($tables);
		//return $tables_size;
		// $result=" ";
		// for($i=0;$i<$tables_size;$i++)
		// {
		// 	$result=$result.$tables[$i];
		// }
		$join_conditions_size=$sizeof_
		return $result;
	}*/

}
?>
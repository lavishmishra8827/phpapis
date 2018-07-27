<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Apiformer extends MY_Controller {
    var $table1='cluster';
    var $table2='cluster_hist';
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //$this->auth();
        $this->load->model("apiformer_model");
    }
    public function get_post()
    {
    	$selection="*";
    	$table1=$this->table1;
    	$where_conditions=$this->post('where_conditions');
    	$this->check_post_values($where_conditions);
    	//$this->print_array($where_conditions);
    	$result=$this->apiformer_model->select($selection,$table1,$where_conditions);
    	if($result)
    	{
    		$data_response['status']=1;
    		$data_response['msg']='success';
    		$data_response['data']=$result;
    		$this->response($data_response);
    	}
    	else
    	{
    		$data_response['status']=0;
    		$data_response['msg']='couldnot select from table'.$table1;
    		$data_response['data']=$result;
    		$this->response($data_response);
    	}

    }
    public function delete_post()
    {
    	$table1=$this->table1;
    	$table2=$this->table2;
    	$time=date("Y-m-d H:i:s");
    	$where_conditions=$this->post('where_conditions');
    	$this->check_post_values($where_conditions);
    	$data_to_be_appended=$this->post('data_to_be_appended');
    	$extra_data['dod']=$time;
    	$extra_data['is_active']='N';

    	//you can add your own extra data here

    	$data_to_be_appended=array_merge($data_to_be_appended,$extra_data);
    	$this->check_post_values($data_to_be_appended);
    	$result=$this->apiformer_model->insert_hist($table1,$where_conditions,$table2,$data_to_be_appended);
    	if($result)
    	{
    		$data_response['status']=1;
    		$data_response['msg']='inserted data into table '.$table2;
    		//$this->response($data_response);
    		$result=$this->apiformer_model->delete($table1,$where_conditions);
    		if($result)
    		{
    			$data_response['status']=1;
    			$data_response['msg']='deleted data from '.$table1;
    			$this->response($data_response);
    		}
    		else
    		{
    			$data_response['status']=0;
	    		$data_response['msg']='inserted data into '.$table1." but couldnot delete from ".$table2;
	    		$this->response($data_response);
    		}
    	}
    	else
    	{
    		$data_response['status']=0;
    		$data_response['msg']='couldnot insert data into table '.$table2;
    		$this->response($data_response);
    	}

    	
    }
    public function insert_post()
    {
            	
    }
    public function check_post_values($array)
    {
    	$array_keys=array_keys($array);
    	$size=sizeof($array_keys);
    	$result="";
    	
    	for($i=0;$i<$size;$i++)
    	{
    		if(empty($array[$array_keys[$i]]))
    		{
    			$data_response['status']=0;
    			$data_response['msg']=$array_keys[$i].' not received';
    			$this->response($data_response);	
    		}
    	}
    	 //$this->response($result);
    }
    public function print_array($array)
    {
    	$data_response['status']=0;
    	$data_response['msg']='displaying the object of values received';
    	$data_response['data']=$array;
    	$this->response($data_response);
    }
   /* public function check_post()
    {
        $tables=array("table1","table2","table3");
        $join_conditions=array(
                    array('cluster_id',)
        )
        $result=$this->apiformer_model->select_with_join($tables,3,3);
        $this->response($result);
    }
    */
}
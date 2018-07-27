<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cluster extends MY_Controller {
var $table1="cluster";
var $table2="cluster_hist";
var $model_name="Cluster_model";
function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //$this->auth();
        $model_name=$this->model_name;
        $this->load->model($model_name);
    }



//ENTER THE OTHER FUNCTIONS HERE

    public function delete_post()
    {   
        $where_condition_fields=array('cluster_id');
        $data_to_be_appended_fields=array('deleted_by');
        $table1=$this->table1;
        $table2=$this->table2;
        $time=date("Y-m-d H:i:s");
        $model_name=$this->model_name;
        $where_conditions=$this->get_post_values($where_condition_fields);
        $this->check_post_values($where_conditions);
        //$this->print_array($where_conditions);
        $data_to_be_appended=$this->get_post_values($data_to_be_appended_fields);
        $extra_data['dod']=$time;
        $extra_data['is_active']='N';
        $data_to_be_appended=array_merge($data_to_be_appended,$extra_data);
        $this->check_post_values($data_to_be_appended);
        //$this->print_array($data_to_be_appended);
        $result=$this->$model_name->insert_hist($table1,$where_conditions,$table2,$data_to_be_appended);
        if($result)
        {
            $data_response['status']=1;
            $data_response['msg']='inserted data into table '.$table2;
            //$this->response($data_response);
            $result=$this->$model_name->delete($table1,$where_conditions);
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
    public function create_where_conditions($where_condition_fields,$where_condition_values)
    {
        $size=sizeof($where_condition_fields);
        for($i=0;$i<$size;$i++)
        {
            $where_conditions[$where_condition_fields[$i]]=$where_condition_values[$i];
        }
        return $where_conditions;
    }
    public function get_post_values($fields)
    {
        $size=sizeof($fields);
        for($i=0;$i<$size;$i++)
        {
            $data[$fields[$i]]=$this->post($fields[$i]);
        }
        return $data;
    }
}
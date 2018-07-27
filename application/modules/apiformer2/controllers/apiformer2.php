<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Apiformer2 extends MY_Controller {
    var $table1='cluster';
    var $table2='cluster_hist';
    var $model_name='apiformer2_model';
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //$this->auth();
        $model_name=$this->model_name;
        $this->load->model($model_name);
    }
    public function get_post()
    {
        $where_condition_fields=array('cluster_id');
        $selection_fields=array('*');
        $selection=implode(",",$selection_fields);
        $table1=$this->table1;
        $model_name=$this->model_name;               
        $where_conditions=$this->get_post_values($where_condition_fields);
        $this->check_post_values($where_conditions);
        //$this->print_array($where_conditions);        
        $result=$this->$model_name->select($selection,$table1,$where_conditions);
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
        $data_to_be_appended_fields=array('deleted_by');
        $where_condition_fields=array('cluster_id','organiser_id','comp_id');
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
    public function insert_post()
    {
        $data_fields=array('cluster_name','organiser_id','comp_id','state','country');
        $table1=$this->table1;
        $time=date("Y-m-d H:i:s");
        $model_name=$this->model_name;        
        $data=$this->get_post_values($data_fields);
        $this->check_post_values($data);
        //$this->print_array($data);
        $data['doa']=$time;
        $data['is_active']='Y';        
        $result=$this->$model_name->insert($table1,$data);
        if($result)
        {
            $data_response['status']=1;
            $data_response['msg']="inserted the data into table ".$table1;
            $data_response['data']=$result;
            $this->response($data_response);
        }
        else
        {
            $data_response['status']=0;
            $data_response['msg']="could not insert the data into table ".$table1;
            $data_response['data']=$result;
            $this->response($data_response);
        }
    }
    public function update_post()
    {
        $data_fields=array('cluster_name','organiser_id','comp_id','state','country');
        $where_condition_fields=array('cluster_id');
        $data_to_be_appended_fields=array('deleted_by');
        $table1=$this->table1;
        $table2=$this->table2;
        $time=date("Y-m-d H:i:s");
        $model_name=$this->model_name;
        $data=$this->get_post_values($data_fields);
        $this->check_post_values($data);
        //$this->print_array($data);
        $where_conditions=$this->get_post_values($where_condition_fields);
        $this->check_post_values($where_conditions);
        //$this->print_array($where_conditions);
        $data_to_be_appended=$this->get_post_values($data_to_be_appended_fields);
        $data_to_be_appended['dod']=$time;
        $data_to_be_appended['is_active']='Y';
        $this->check_post_values($data_to_be_appended);
        //$this->print_array($data_to_be_appended);
        $selection="*";
        $result=$this->$model_name->select($selection,$table1,$where_conditions);
        if(!$result)
        {
            $data_response['status']=1;
            $data_response['msg']="no data of this where_conditions present";
            $data_response['where_conditions']=$where_conditions;
            $this->response($data_response);
        }
        $result=$this->$model_name->insert_hist($table1,$where_conditions,$table2,$data_to_be_appended);
        if($result)
        {
            $data_response['status']=1;
            $data_response['msg']='inserted data into table '.$table2;
            //$this->response($data_response);
            $result=$this->$model_name->update($table1,$data,$where_conditions);
            if($result)
            {
                $data_response['status']=1;
                $data_response['msg']='updated data in '.$table1;
                $this->response($data_response);
            }
            else
            {
                $data_response['status']=0;
                $data_response['msg']='inserted data into '.$table1." but couldnot update in ".$table2;
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
        $data;
        for($i=0;$i<$size;$i++)
        {
            $data[$fields[$i]]=$this->post($fields[$i]);
        }
        return $data;
    }
}
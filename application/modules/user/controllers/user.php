<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model("user_model");
    }
	
    public function reset_password_post(){
        $old_password = sha1($this->post('old_password'));
        $data_input['password'] = sha1($this->post('password'));

        $user_id=$this->user_model->fetch_user_id($this->post('person_id'));
        // $this->response($user_id->user_id);
        if($user_id->user_id){
            $password=$this->user_model->fetch_user_password($user_id->user_id);
            // $this->response($password);
            if ($password->password===$old_password) {
            $result=$this->user_model->update_user($user_id->user_id,$data_input);
            $data_response['status']=1;
            $data_response['msg']="Password updated Successfull";
            $this->response($data_response);
 
            }
            else {
            $data_error['status'] = 0;
            $data_error['msg'] = "Password does not match";
            $this->response($data_error);
            }
        }else{
            $data_error['status'] = 0;
            $data_error['msg'] = "Failed. Try Again";
            $this->response($data_error);
        }

    }

    public function view_user_post(){
        $data_input['comp_id']=$this->post('comp_id');
        $result=$this->user_model->fetch_comp_user($data_input);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['data']=$result;
            $this->response($data_response);
        }
        else{
            $data_error['status'] = 0;
            $data_error['msg'] = "Failed. Try Again";
            $this->response($data_error);
        }
    }

    public function fetch_profile_post(){
        $data['person_id'] = $this->post('person_id');
        $data['comp_id'] = $this->post('comp_id');
        $result = $this->user_model->fetch_person_profile($data);
        if($result){
            $data_response['status'] = 1;
            $data_response['msg'] = "Success";
            $data_response['result'] = $result;
            $this->response($data_response);
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = "Failed";
            $data_response['result'] = null;
            $this->response($data_response);
        }
    }
    public function get_person_post(){
        $data['person_id'] = $this->post('person_id');
        $data['comp_id'] = $this->post('comp_id');
        $result = $this->user_model->fetch_person($data);
        if($result){
            $data_response['status'] = 1;
            $data_response['msg'] = "Success";
            $data_response['data'] = $result;
            $this->response($data_response);
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = "Failed";
            $data_response['data'] = null;
            $this->response($data_response);
        }
    }
    public function get_comp_supervisor_post(){
        $comp_id=$this->post('comp_id');
        $result=$this->user_model->fetch_comp_supervisor($comp_id);
        if($result){
            $data_response['data']=$result;
            $data_responsep['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        }else{
            $data_responsep['status']=0;
            $data_response['msg']="Sorry Unable to fetch";
            $this->response($data_response);
        }
    }
    public function update_person_post(){
        // $data_input['comp_id'] = $this->post('company_name');
        $data_input['cluster_id'] = $this->post('cluster_id');
        $data_input['role_id'] = $this->post('role_id');
        $data_input['name'] = $this->post('name');
        $data_input['father_name'] = $this->post('father_name');
        $data_input['dob'] = '0000-00-00';
        $data_input['mob'] = $this->post('mob');
        $data_input['mob2'] = $this->post('mob2');
        $data_input['email'] = $this->post('email');
        // $data_input['gender'] = $this->post('gender');
        $data_input['addl1'] = $this->post('addl1');
        $data_input['addl2'] = $this->post('addl2');
        $data_input['village_or_city'] = $this->post('village_or_city');
        $data_input['mandal_or_tehsil'] = $this->post('mandal_or_tehsil');
        $data_input['district'] = $this->post('district');
        $data_input['state'] = $this->post('state');
        $data_input['country'] = $this->post('country');
        $data_input['doa'] = date('Y-m-d H:i:s');
        $data_input['added_by'] = $this->post('added_by');
        $user['username'] = $this->post('username');
        $user['role_id'] = $this->post('role_id');
        // $data_user['comp_id'] = 1;
        $user['doa'] = date('Y-m-d H:i:s');
        // $data_user['password'] = $this->encrypt->sha1($data_user['password']);
        $result1 = $this->user_model->insert_user_master_hist($this->post("user_id"));
        $result2 = $this->user_model->insert_person_hist($this->post("person_id"));
                
        if($result1&&$result2){
            $result3 = $this->user_model->update_user($this->post("user_id"),$user);

            $result4 = $this->user_model->update_person($this->post("person_id"),$data_input);
         
            if($result3&&$result4){
                $data_response['status'] = 1;
                $data_response['msg'] = "Success";
                $this->response($data_response);
            }else{
                $data_response['status'] = 0;
                $data_response['msg'] = "Failed";
                $this->response($data_response);
            }
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = 'Failed to add history data';
            $this->response($data_response);
        }   
    }

    public function display_all_supervisors_post(){
        $data['role_id']=0;
        $data['comp_id !=']=0;    
        $table="user_master";    
        $result=$this->user_model->fetch_all_supervisors($table,$data);
        if($result){
            $data_response['data']=$result;
            $data_response['msg']="success";
            $data_response['status']=1;
            $this->response($data_response);
        }
        else{
            //$data_response['data']=$result;
            $data_response['msg']="failure";
            $data_response['status']=0;
            $this->response($data_response);
        }
    }
    public function delete_user_post()
    {
        $data['user_id']=$this->post('user_id');
        $table1="user_master";
        $table2="user_master_hist";
        $array=$data;
        $data1['user_id']=$this->post('user_id');
        $data1['deleted_by']=$this->post('deleted_by');
        $data1['dod']=date("Y-m-d H:i:s");
        $data1['is_active']='N';
        $result=$this->user_model->delete_insert_hist($table1,$array,$table2,$data1);
        if($result==-1)
        {
            $data_response['msg']="no record of this id  found ".$data['user_id'];
            $data_response['status']=0;
            $this->response($data_response);
        }
        else 
        {       
                $data_response['msg']="entered into the history table";
                $data_response['status']=1;
                //$this->response($data_response);
                
                $result=$this->user_model->delete_supervisor($table1,$data);
                if($result==1)
                {
                    $data_response['status']=1;
                    $data_response['msg']="deleted supervisor with id ".$data['user_id'];
                    $this->response($data_response);
                }
                else if($result==0)
                {
                    $data_response['status']=1;
                    $data_response['msg']="no user of this id ".$data['user_id'];
                    $this->response($data_response);
                }
        
                else
                {
                    $data_response['status']=0;
                    $data_response['msg']="couldnot delete some error occured";
                    $this->response($data_response);
                }
        }
    }
    public function update_user_post()
    {
        $data['user_id']=$this->post('user_id');
        if(empty($data['user_id']))
        {
            $data_response['msg']="user_id not received ";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $table1="user_master";
        $table2="user_master_hist";
        $array['user_id']=$this->post('user_id');
        $data1['user_id']=$this->post('user_id');
        $data1['deleted_by']=$this->post('deleted_by');
        if(empty($data1['deleted_by']))
        {
            $data_response['msg']="deleted_by not received ";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $data1['dod']=date("Y-m-d H:i:s");
        $data1['is_active']='Y';
        $result=$this->user_model->delete_insert_hist($table1,$array,$table2,$data1);
        if($result==-1)
        {
            $data_response['msg']="no record of this id  found ".$data['user_id'];
            $data_response['status']=0;
            $this->response($data_response);
        }
        else 
        {       
            $data_response['msg']="entered into the history table";
            $data_response['status']=1;
            //$this->response($data_response);
            $data_user['username'] = $this->post('username');
            if(empty($data_user['user_name']))
            {
                $data_response['msg']="user_name not received ";
                $data_response['status']=0;
                $this->response($data_response);
            }

            $data_user['password'] = $this->post('password');
            if(empty($data_user['password']))
            {
                $data_response['msg']="password not received ";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $data_user['password']=sha1($data_user['password']);
            
            $data_user['role_id'] = $this->post('role_id');
            if(empty($data_user['role_id']))
            {
                $data_response['msg']="role_id not received ";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $data_user['comp_id'] = $this->post('comp_id');
            if(empty($data_user['comp_id']))
            {
                $data_response['msg']="comp_id not received ";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $data_user['doa'] = date('Y-m-d H:i:s');
            $data_array['user_id']=$this->post('user_id');
            $result=$this->user_model->update($table1,$data_user,$data_array);
            if($result)
            {
                $data_response['status']=1;
                $data_response['msg']="updated ".$table1." table also";
                //$this->response($data_response);
                $table1="person";
                $table2="person_hist";
                $result=$this->user_model->delete_insert_hist($table1,$array,$table2,$data1);
                if($result==-1)
                {
                    $data_response['msg']="no record of this id  found ".$data['user_id'];
                    $data_response['status']=0;
                    $data_response['data']=$result;
                    $this->response($data_response);
                }
                else
                {               
                    $data_response['msg']='updated the data of id '.$data['user_id'];
                    $data_response['status']=1;
                    //$this->response($data_response);
                    $data_input['comp_id'] = $this->post('company_name');
                    if(empty($data_user['comp_id']))
                    {
                        $data_response['msg']="comp_id(company_name) not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['cluster_id'] = $this->post('cluster_id');
                    if(empty($data_user['cluster_id']))
                    {
                        $data_response['msg']="cluster_id not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['user_id']=$this->post('user_id');
                    $data_input['role_id'] = $this->post('role_id');
                    if(empty($data_user['role_id']))
                    {
                        $data_response['msg']="role_id not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['name'] = $this->post('name');
                    if(empty($data_user['name']))
                    {
                        $data_response['msg']="name not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['father_name'] = $this->post('father_name');
                    if(empty($data_user['father_name']))
                    {
                        $data_response['msg']="father_name not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['mob'] = $this->post('mob');
                    if(empty($data_user['mob']))
                    {
                        $data_response['msg']="mob not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['mob2'] = $this->post('mob2');
                    if(empty($data_user['mob2']))
                    {
                        $data_response['msg']="mob2 not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['email'] = $this->post('email');
                    if(empty($data_user['email']))
                    {
                        $data_response['msg']="email not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['dob'] = '1000-01-01';
                    $data_input['gender'] = $this->post('gender');
                    if(empty($data_user['user_id']))
                    {
                        $data_response['msg']="user_id not received ";
                        $data_response['status']=0;
                        $this->response($data_response);
                    }
                    $data_input['addl1'] = $this->post('addl1');
                    $data_input['addl2'] = $this->post('addl2');
                    $data_input['village_or_city'] = $this->post('village_or_city');
                    $data_input['mandal_or_tehsil'] = $this->post('mandal_or_tehsil');
                    $data_input['district'] = $this->post('district');
                    $data_input['state'] = $this->post('state');
                    $data_input['country'] = $this->post('country');
                    $data_input['doa'] = date('Y-m-d H:i:s');
                    $data_input['added_by'] = $this->post('added_by');
                    $result=$this->user_model->update($table1,$data_input,$array);
                    if($result)
                    {
                        $data_response['status']=1;
                        $data_response['msg']='updated the table '.$table1." also";
                        $data_response['data']=$result;
                        $this->response($data_response);
                    }
                            
                }
            }
            else
            {
                $data_response['status']=0;
                $data_response['msg']="updated user_master_hist but couldnot update user_master table";
                $this->response($data_response);   
            }
        }
    }
}


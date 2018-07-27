<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //$this->auth();
        $this->load->model("role_model");
    }
	

    public function add_role_post()
    {
        $data['role']=$this->post("role");
        $data['comp_id']=0;
        $data['user_rights']=$this->post("user_rights");
        $data['added_by']=$this->post("added_by");
        $data['doa']=date('Y-m-d H:i:s');
            
        $result=$this->role_model->insert_role($data);

        if ($result) {
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        } else {
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }
        
    }
    public function get_roles_post()
    {
        $data['comp_id']=0;

        $result=$this->role_model->fetch_roles($data);

        if ($result) {
            $data_response['data']=$result;
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        } else {
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }
        
    }
    public function delete_role_post()
    {
        $data['role_id']=$this->post('role_id');
        $table1="user_roles";
        $table2="user_roles_hist";
        $data['deleted_by']=$this->post('deleted_by');
        $array['role_id']=$this->post('role_id');
        $result=$this->role_model->delete_insert_hist($table1,$array,$table2,$data);
         if($result==-1)
        {
            $data_response['status']=-1;
            $data_response['msg']="record not present in the table";
            $this->response($data_response);
        }
        if($result)
        {
            $data_response['status']=1;
            $data_response['msg']="inserted into delete history";
            //$this->response($data_response);
            $result=$this->role_model->delete_role($array);
            if($result)
            {
                $data_response['data']=$result;
                $data_response['status']=1;
                $data_response['msg']="deleted";
                $this->response($data_response);
            }
            else
            {
                $data_response['status']=0;
                $data_response['msg']="couldnot delete";
                $this->response($data_response);
            }    

        }
        else
        {
            $data_response['status']=0;
            $data_response['msg']="couldnot insert into delete history".$table1;
            $this->response($data_response);
        }
        
    }
public function update_post()
    {
        $data['role_id']=$this->post('role_id');
        $table1="user_roles";
        $table2="user_roles_hist";

         $result=$this->role_model->delete_insert_hist($table1,$data,$table2,$data);
         if($result==-1)
        {
            $data_response['status']=-1;
            $data_response['msg']="record not present in the table";
            $this->response($data_response);
        }
        if($result)
        {
            $data_response['status']=1;
            $data_response['msg']="inserted into delete history";
            $this->response($data_response);
            /*$result=$this->role_model->delete_role($array);
            if($result)
            {
                $data_response['data']=$result;
                $data_response['status']=1;
                $data_response['msg']="deleted";
                $this->response($data_response);
            }
            else
            {
                $data_response['status']=0;
                $data_response['msg']="couldnot delete";
                $this->response($data_response);
            } */   
            

        }
        else
        {
            $data_response['status']=0;
            $data_response['msg']="couldnot insert into delete history".$table1;
            $this->response($data_response);
        }
    }


}

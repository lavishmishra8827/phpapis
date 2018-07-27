<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // $this->auth();
        $this->load->model("accounts_model");
    }
    public function get_sv_exp_post(){
        $data['comp_id']=$this->post('comp_id');
        $data['person_id']=$this->post("sv_id");

        $result=$this->accounts_model->fetch_sv_exp($data);

        if($result){
            $data_response['data']=$result;
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }    
    }
    public function verify_sv_exp_post(){
        $sv_daily_exp_id=$this->post('sv_daily_exp_id');
        $data['verified_by']=$this->post('person_id');
        $data['verified_on']=date('Y-m-d H:i:s');
        //$this->response($data);
        $result=$this->accounts_model->update_sv_exp($data,$sv_daily_exp_id);
        if($result==1){
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
         }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to verify";
            $this->response($data_response);
        }
    }
}

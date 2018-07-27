<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Visitreport extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model("visitreport_model");
    }
    public function add_vr_activity_template_post(){
        $data_input['comp_id']=$this->post('comp_id');
        $data_input['name']=$this->post('name');
        $data_input['seq_num']=$this->post('seq_num');
        $data_input['value_type']="varchar";
        $result=$this->visitreport_model->insert_vr_activity_template($data_input);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Inserted Successfully";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to insert data";
            $this->response($data_response);
        }

    }
    public function get_activity_template_data_post(){
        $comp_id=$this->post('comp_id');
        $result=$this->visitreport_model->fetch_activity_template_data($comp_id);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="succesful";
            $data_response['result']=$result;
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to fethch";
            $data_response['result']=$result;
            $this->response($data_response);
        }
    }
    public function add_activity_template_material_post(){
        $data_input['activity_template_id']=$this->post('activity_template_id');
        $data_input['name']=$this->post('name');
        $data_input['comp_id']=$this->post('comp_id');
        $data_input['doa']=date('Y-m-d h:i:s');
         //$this->response($data_input);
        $result=$this->visitreport_model->insert_activity_template_material($data_input);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Inserted Successfully";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to insert";
            $this->response($data_response);
        }
    }
    public function get_visit_report_details_post(){
        $data_input['comp_id']=$this->post('comp_id');
        $data_input['farm_id']=$this->post('farm_id');
        $visit_report_id=$this->visitreport_model->fetch_visit_report_id($data_input);
        $i=0;
        // $this->response($visit_report_id);   
        foreach($visit_report_id as $vr){
            $vr_id=$vr->visit_report_id;
            //$this->response($vr_id);   
            $result[$i]=$this->visitreport_model->fetch_visit_report_details($vr_id);
            $i++;
        }
        if($result){
           $data_response['status']=1;
           $data_response['msg']="Successfully";
           $data_response['result']=$result;
           $this->response($data_response);
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = "Failed";
            $data_response['result'] = NULL;
            $this->response($data_response);
        } 
    } 
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Android_vr extends MY_Controller {
    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->load->model("android_vr_model");
    }
    
    public function farm_visit_reports_post(){
        $data_input['farm_id'] = $this->post('farm_id');
        $data_input['comp_id'] = $this->post('comp_id');
        $visit_report_id=$this->android_vr_model->fetch_visit_report_id($data_input);
        $i=0;
        // $this->response($visit_report_id);   
        foreach($visit_report_id as $vr){
            $vr_id=$vr->visit_report_id;
            //$this->response($vr_id);   
            $result[$i]=$this->android_vr_model->fetch_visit_report_details($vr_id);
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
    
    
    public function insert_visit_report_post(){
        
        $data['farm_id']=$this->post('farm_id');
        if(empty($data['farm_id']))
        {
            $response_final['status']=0;
            $response_final['msg']="Farm id not received";
            $this->response($response_final);
        }
        $data['comp_id']=$this->post('comp_id');
        if(empty($data['comp_id']))
        {
            $response_final['status']=0;
            $response_final['msg']="comp_id not received";
            $this->response($response_final);
        }
        $data['approved_method']=$this->post('approved_method');
        if(empty($data['approved_method']))
        {
            $response_final['status']=0;
            $response_final['msg']="approved_method not received";
            $this->response($response_final);
        }
        $data['visit_date']=$this->post('visit_date');
        if(empty($data['visit_date']))
        {
            $response_final['status']=0;
            $response_final['msg']="visit_date not received";
            $this->response($response_final);
        }
        $data['visit_number']=$this->post('visit_number');
        if(empty($data['visit_number']))
        {
            $response_final['status']=0;
            $response_final['msg']="visit_number not received";
            $this->response($response_final);
        }
        $data['effective_area']=$this->post('effective_area');
        if(empty($data['effective_area']))
        {
            $response_final['status']=0;
            $response_final['msg']="effective_area not received";
            $this->response($response_final);
        }
        $data['added_by']=$this->post('added_by');
        if(empty($data['added_by']))
        {
            $response_final['status']=0;
            $response_final['msg']="added_by not received";
            $this->response($response_final);
        }
        $time=date('Y-m-d H:i:s');
        $data['fapp_timestamp']=$time;
        $data['svapp_timestamp']=$time;
        $data['doa']=$time;
        $data['is_active']='y';
        {
            $table="visit_report";
            $visit_report_id = $this->android_vr_model->insert($table,$data);
        }
        if(!empty($visit_report_id))
        {
            $data_second['visit_report_id']=$visit_report_id;
            $data_second['comp_id']=$this->post('comp_id');
            if(empty($data_second['comp_id']))
            {
                $response_final['status']=0;
                $response_final['msg']="comp_id not received";
                $this->response($response_final);
            }
            $activity_template_id=$this->post('activity_template_id');
            if(empty($activity_template_id))
            {
                $response_final['status']=0;
                $response_final['msg']="activity_template_id not received";
                $this->response($response_final);
            }
            $material_id=$this->post('material_id');
            if(empty($material_id))
            {
                $response_final['status']=0;
                $response_final['msg']="material_id not received";
                $this->response($response_final);
            }
            
            $comment=$this->post('comment');
            if(empty($comment))
            {
                $response_final['status']=0;
                $response_final['msg']="comment not received";
                $this->response($response_final);
            }
            $qty=$this->post('qty');
            if(empty($qty))
            {
                $response_final['status']=0;
                $response_final['msg']="qty not received";
                $this->response($response_final);
            }
            $unit_id=$this->post('unit_id');
            if(empty($unit_id))
            {
                $response_final['status']=0;
                $response_final['msg']="unit_id not received";
                $this->response($response_final);
            }
            $done_date=$this->post('done_date');
            if(empty($done_date))
            {
                $response_final['status']=0;
                $response_final['msg']="done_date not received";
                $this->response($response_final);
            }
            $is_prescribed=$this->post('is_prescribed');
            if(empty($is_prescribed))
            {
                $response_final['status']=0;
                $response_final['msg']="is_prescribed not received";
                $this->response($response_final);
            }
            $table="visit_activity";
            $size=sizeof($activity_template_id);
            for($i=0;$i<$size;$i++){
                $data_second['activity_template_id']=$activity_template_id[$i];
                $data_second['material_id']=$material_id[$i];
                $data_second['comment']=$comment[$i];
                $data_second['qty']=$qty[$i];
                $data_second['unit_id']=$unit_id[$i];
                $data_second['done_date']=$done_date[$i];
                $data_second['is_prescribed']=$is_prescribed[$i];

                $visit_activity_id = $this->android_vr_model->insert($table,$data_second);
                $responsedata[$i]=$visit_activity_id;
            }
            if(sizeof($responsedata)==$size){
                $response_final['status']=1;
                $response_final['msg']="success";
                $response_final['responsedata']=$responsedata;
                $this->response($response_final);
            }
            else{
                $response_final['status']=0;
                $response_final['msg']="failure";
                $this->response($response_final);
            }
        }
        else{
            $response_final['status']=0;
            $response_final['msg']="Failed";
            $this->response($response_final);
        }
    }
}
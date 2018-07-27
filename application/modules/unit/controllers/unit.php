<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model("unit_model");
    }
	

    public function add_unit_post()
    {
        $data['unit']=$this->post("unit");
        $data['comp_id']=$this->post("comp_id");
        $data['doa']=date('Y-m-d H:i:s');

        $result=$this->unit_model->insert_unit($data);

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
    public function get_units_post()
    {
        $data['comp_id']=0;

        $result=$this->unit_model->fetch_units($data['comp_id']);

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
    public function update_unit_post()
    {
        $data["unit"]=$this->post('unit');
        $data['doa']=date('Y-m-d H:i:s');
        $unit_id=$this->post('unit_id');

        $result=$this->unit_model->insert_unit_hist($unit_id);

        if ($result) {
            $result=$this->unit_model->update_unit($data,$unit_id);
            if ($result) {
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
            } else {
            $data_response['status']=0;
            $data_response['msg']="error. Can not update";
            $this->response($data_response);
            }
            
        } else {
            $data_response['status']=0;
            $data_response['msg']="error. can not insert history";
            $this->response($data_response);
        }
        
    }
    public function delete_unit_post()
    {
        $unit_id=$this->post('unit_id');
        $data["deleted_by"]=$this->post('deleted_by');
        $data['dod']=date('Y-m-d H:i:s');

        $result=$this->unit_model->insert_unit_hist_delete($data,$unit_id);

        if ($result) {
            $result=$this->unit_model->delete_unit($unit_id);
            if ($result) {
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
            } else {
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
            }
            
        } else {
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }
        
    }


}
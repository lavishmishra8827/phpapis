<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Android_voucher extends MY_Controller {
    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->load->model("android_voucher_model");
    }

    public function add_sv_exp_post(){
       $img_link=NULL;
       $today_date_time = date("Ymd_His");
       $comp_id=$this->post("comp_id");
       $userDir = 'sv_'.$this->post('sv_id');
       $path ='./uploads/company_'.$comp_id.'/'.$userDir;
       // $this->response($path);
       //  // $path = 'http://localhost/rent/company_'.$comp_id.'/uploads/'.$userDir;
        if(!is_dir($path)) //create the folder if it's not already exists
        {
            mkdir($path,0777,TRUE);
        } 
        $imgName = 'img_'.$today_date_time;
        $config['upload_path']          = $path;
        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|pdf';
        $config['max_size']             = 1500000;
        $config['max_width']            = 20000;
        $config['max_height']           = 10000;
        $config['file_name']            = $imgName;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('img_url'))
        {
        // $error = array('error' => $this->upload->display_errors());
            $img_link = 'http://35.154.153.223/fcmsci/uploads/company/default.jpg';
        }
        else
        {
        $data = array('upload_data' => $this->upload->data());
        $imgType = $data['upload_data']['file_ext'];
        $img_link = 'http://35.154.153.223/fcmsci/uploads/company_'.$comp_id.'/'.$userDir.'/'.$imgName.$imgType;
        }

        $data_input['img_url'] = $img_link;
        $data_input['comp_id']=$this->post("comp_id");
        $data_input['person_id']=$this->post("sv_id");
        $data_input['exp_date']=$this->post("exp_date");
        $data_input['comment']=$this->post("comment");
        $data_input['amount']=$this->post("amount");
        $data_input['category_id']=$this->post("category_id");
        $data_input['doa']=date('Y-m-d H:i:s');

        $result=$this->android_voucher_model->insert_sv_exp($data_input);
        
        if ($result) {
            $data_response['img_url']=$img_link;
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        } else {
            $data_response['img_url']=$img_link;
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }
    // $data['img_url']=$this->post("img_url");
    }

    public function get_sv_exp_post(){
        $data['comp_id']=$this->post('comp_id');
        $data['person_id']=$this->post("sv_id");

        $result=$this->android_voucher_model->fetch_sv_exp($data);

        if($result){
            $data_response['data']=$result;
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        }else{
            $data_response['data']=NULL;
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }    
    }

}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
        $this->load->model("company_model");
    }
	

    public function add_company_post()
    {

       $img_link=NULL;
       $today_date_time = date("Ymd_His");
       $path ='./uploads/company';
       if(!is_dir($path)) //create the folder if it's not already exists
        {
            mkdir($path,0777,TRUE);
        } 
        $imgName = 'img_'.$today_date_time.'_icon';
        $config['upload_path']          = $path;
        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPEG|pdf';
        $config['max_size']             = 1500000;
        $config['max_width']            = 20000;
        $config['max_height']           = 10000;
        $config['file_name']            = $imgName;

        $this->load->library('upload', $config,"iconUpload");
        $this->iconUpload->initialize($config);
        if(!$this->iconUpload->do_upload('iconimg'))
        {
        //    $error = array('error' => $this->iconUpload->display_errors());
        $img_link_icon = 'http://13.232.96.172/fcmsci/uploads/company/default_icon.jpg';
        }
        else
        {
        $da = array('upload_data' => $this->iconUpload->data());
        $imgType = $da['upload_data']['file_ext'];
        $img_link_icon = 'http://13.232.96.172/fcmsci/uploads/company/'.$imgName.$imgType;
        }

        $today_date_time2 = date("Ymd_His");
        $imgName2 = 'img_'.$today_date_time2.'_banner';
        $config2['upload_path']          = $path;
        $config2['allowed_types']        = 'gif|jpg|png|jpeg|JPEG';
        $config2['max_size']             = 50240;
        $config2['max_width']            = 7000;
        $config2['max_height']           = 5000;
        $config2['file_name']            = $imgName2;

        $this->load->library('upload', $config2,'bannerUpload');
        $this->bannerUpload->initialize($config2);
        if(!$this->bannerUpload->do_upload('bannerimg'))
        {
        //    $error = array('error' => $this->bannerUpload->display_errors());
        $img_link_banner = 'http://13.232.96.172/fcmsci/uploads/company/default_banner.jpg';
        }
        else
        {
        $da = array('upload_data' => $this->bannerUpload->data());
        $imgType = $da['upload_data']['file_ext'];
        $img_link_banner = 'http://13.232.96.172/fcmsci/uploads/company/'.$imgName2.$imgType;
        }

        $data['company_name']=$this->post('company_name');
        $data['company_code']=$this->post("company_code");
        $data['email']=$this->post("email");
        $data['phone1']=$this->post("phone1");
        $data['phone2']=$this->post("phone2");
        $data['addl1']=$this->post("addl1");
        $data['addl2']=$this->post("addl2");
        $data['city_or_village']=$this->post("city_or_village");
        $data['state']=$this->post("state");
        $data['country']=$this->post("country");
        $data['taxation_id1']=$this->post("taxation_id1");
        $data['taxation_id2']=$this->post("taxation_id2");
        $data['icon_img']=$img_link_icon;
        $data['banner_img']=$img_link_banner;
        $data['doa']=date('Y-m-d H:i:s');
        $data['added_by']=$this->post("added_by");

        $result=$this->company_model->insert_company($data);

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

    public function update_company_post()
    {   
        $comp_id=$this->post("comp_id");
        $data['company_name']=$this->post("company_name");
        $data['company_code']=$this->post("company_code");
        $data['email']=$this->post("email");
        $data['phone1']=$this->post("phone1");
        $data['phone2']=$this->post("phone2");
        $data['addl1']=$this->post("addl1");
        $data['addl2']=$this->post("addl2");
        $data['city_or_village']=$this->post("city_or_village");
        $data['state']=$this->post("state");
        $data['country']=$this->post("country");
        $data['taxation_id1']=$this->post("taxation_id1");
        $data['taxation_id2']=$this->post("taxation_id2");
        // $data['icon_img']=$this->post("icon_img");
        // $data['banner_img']=$this->post("banner_img");
        $data['doa']=date('Y-m-d H:i:s');
        // $data['added_by']=$this->post("added_by");
    
        $result=$this->company_model->insert_company_hist($comp_id);

        if ($result) {
            $result=$this->company_model->update_company($data,$comp_id);
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

    public function fetch_all_company_get()
    {
            
        $result=$this->company_model->get_all_company();

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
    public function get_company_post()
    {
        $data['comp_id']=$this->post('comp_id');
        $result=$this->company_model->get_company($data['comp_id']);

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
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Android extends MY_Controller {
    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->load->model("android_model");
    }

    public function supervisor_login_post(){
        $data_input['password'] = sha1($this->post('password'));
        $data_input['username'] = $this->post('username');
        $data['gps']=$this->post('gps');
        $data['ip']=$this->input->ip_address();
        $result=$this->android_model->fetch_supervisor($data_input);
        $data['user_id']=$result->user_id;
        if($result){
            $log=$this->android_model->insert_log_details($data);
            $result_person=$this->android_model->fetch_person($data['user_id']);
            if($result_person){
                $data_response['data']=$result_person;
                $data_response['status']=1;
                $data_response['msg']="Login Successfull";
                $this->response($data_response);
            }else{
                $data_response['data']=null;
                $data_response['status']=0;
                $data_response['msg']="Unable To fetch";
                $this->response($data_response);
            }
        }else{
            $data_error['status'] = 0;
            $data_response['data']=null;
            $data_error['msg'] = "Incorrect Credentials";
            $this->response($data_error);
        }   
        
    }

    public function get_clusters_post(){
        $data['comp_id']=$this->post('comp_id');
        $result=$this->android_model->fetch_clusters($data);
        if($result){
            $data_response['data'] = $result;
            $data_response['msg'] = "Success";
            $data_response['status'] = 1;
            $this->response($data_response);
        }else{
            $data_response['data'] = null;
            $data_response['msg'] = "Failed";
            $data_response['status'] = 0;
            $this->response($data_response);
        } 
    }

    /*public function add_sv_exp_post(){
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

        $result=$this->android_model->insert_sv_exp($data_input);
        
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

        $result=$this->android_model->fetch_sv_exp($data);

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
    }*/

   /* public function view_cluster_farms_post(){
        $data_input['cluster_id']=$this->post('cluster_id');
        $data_input['comp_id']=$this->post('comp_id');
        $result=$this->android_model->fetch_cluster_farms($data_input);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['result']=$result;
            $this->response($data_response);
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = "Failed";
            $data_response['result'] = null;
            $this->response($data_response);
        }
    }*/

    /*public function edit_farm_post(){
        $data['comp_id']=$this->post('comp_id');
        $data['farm_id']=$this->post('farm_id');
        $data_input['actual_area']=$this->post('actual_area');
        $data_input['irrigation_source']=$this->post('irrigation_source');
        $data_input['irrigation_type']=$this->post('irrigation_type');
        $data_input['soil_type']=$this->post('soil_type');
        $data_input['previous_crop']=$this->post('previous_crop');
        $data_input['sowing_date']=$this->post('sowing_date');
        $data_input['exp_harvest_date']=$this->post('exp_harvest_date');
        $data_input['exp_flowering_date']=$this->post('exp_flowering_date');
        $result=$this->android_model->update_farm($data_input,$data);
        if($result==1){
            $data_response['status']=1;
            $data_response['msg']="Farm Updated Succesfully";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to update farm";
            $this->response($data_response);
        }
    }*/

    /*public function view_all_farms_post(){
        $comp_id=$this->post('comp_id');
        $result=$this->android_model->fetch_all_farms($comp_id);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['data']=$result;
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to fetch farm";
            $this->response($data_response);
        }
    }*/

    /*public function farm_gps_submit_post(){
        $area=$this->post("area");
        $farm_id=$this->post("farm_id");
        $comp_id=$this->post("comp_id");
        $latArray=$this->post('lat');
        $longArray=$this->post('lng');

        $lat=count($latArray);
        $lon=count($longArray);
        if ($lat>=$lon) {
            $min=$lon;
        } else {
            $min=$lat;
        }

        $data_input =array();
        for($i=0; $i<$min; $i++) {
        $data_input[$i] = array(
                   'comp_id' => $comp_id, 
                   'farm_id' => $farm_id,
                   'latitude' => $latArray[$i],
                   'longitude' => $longArray[$i],
                   'doa' => date('Y-m-d H:i:s')
                   );
        } 
        // $this->response($data_input);
        $result=$this->android_model->insert_farm_gps($data_input);
        if($result){
        $result=$this->android_model->update_farm_area($area,$farm_id);
            if ($result) {
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
            } else {
            $data_response['status']=0;
            $data_response['msg']="GPS inserted but Unable to update Farm area";
            $this->response($data_response);
            }        
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to insert GPS";
            $this->response($data_response);
        }
    }*/

    /*public function get_farm_gps_post(){
        $comp_id=$this->post('comp_id');
        $farm_id=$this->post('farm_id');

        $result=$this->android_model->fetch_all_farm_gps($comp_id,$farm_id);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['data']=$result;
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to fetch farm GPS";
            $this->response($data_response);
        }
    }*/

    public function get_roles_post(){
        $data['comp_id']=0;
        $result=$this->android_model->fetch_roles($data);
        if ($result) {
            $data_response['data']=$result;
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        }else {
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }
    }
    public function get_units_post(){
        $data['comp_id']=0;
        $result=$this->android_model->fetch_units($data['comp_id']);
        if ($result) {
            $data_response['data']=$result;
            $data_response['status']=1;
            $data_response['msg']="Success";
            $this->response($data_response);
        }else {
            $data_response['data']=null;
            $data_response['status']=0;
            $data_response['msg']="error";
            $this->response($data_response);
        }
    }
    /*public function farm_visit_reports_post(){
        $data_input['farm_id'] = $this->post('farm_id');
        $data_input['comp_id'] = $this->post('comp_id');
        $visit_report_id=$this->android_model->fetch_visit_report_id($data_input);
        $i=0;
        // $this->response($visit_report_id);   
        foreach($visit_report_id as $vr){
            $vr_id=$vr->visit_report_id;
            //$this->response($vr_id);   
            $result[$i]=$this->android_model->fetch_visit_report_details($vr_id);
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
    }*/

    /*public function update_farm_post(){
        $data['comp_id']=$this->post('comp_id');
        $data['farm_id']=$this->post('farm_id');
        
        $data_input['irrigation_source']=$this->post('irrigation_source');
        $data_input['irrigation_type']=$this->post('irrigation_type');
        $data_input['soil_type']=$this->post('soil_type');
        $data_input['previous_crop']=$this->post('previous_crop');
        $data_input['sowing_date']=$this->post('sowing_date');
        $data_input['exp_harvest_date']=$this->post('exp_harvest_date');
        $data_input['exp_flowering_date']=$this->post('exp_flowering_date');
        $result=$this->android_model->update_farm($data_input,$data);
        if($result==1){
            $data_response['status']=1;
            $data_response['msg']="Farm Updated Succesfully";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to update farm";
            $this->response($data_response);
        }
    }*/

    public function fetch_profile_post(){
        $data['person_id'] = $this->post('person_id');
        $data['comp_id'] = $this->post('comp_id');
        $result = $this->android_model->fetch_person_profile($data);
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

    /*public function insert_post(){
        
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
            $visit_report_id = $this->android_model->insert($table,$data);
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

                $visit_activity_id = $this->android_model->insert($table,$data_second);
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
    }*/

    /*public function update_actual_flowering_date_post()
    {
        //$this->response("this is a string");
        $data['actual_flowering_date']=$this->post('actual_flowering_date');
        $array['farm_id']=$this->post('farm_id');
        $array['is_active']='Y';
        $table='farm';
        $result=$this->android_model->update($table,$data,$array);
        if($result)
        {
            $response_final['status']=1;
                $response_final['msg']="success";
                $this->response($response_final);
        }
        else
        {
            $response_final['status']=0;
                $response_final['msg']="failure";
                $this->response($response_final);
        }
    }


    public function update_actual_harvest_date_post()
    {
        //$this->response("this is a string");
        $data['actual_harvest_date']=$this->post('actual_harvest_date');
        $array['farm_id']=$this->post('farm_id');
        $array['is_active']='Y';
        $table='farm';
        $result=$this->android_model->update($table,$data,$array);
        if($result)
        {
            $response_final['status']=1;
                $response_final['msg']="success";
                $this->response($response_final);
        }
        else
        {
            $response_final['status']=0;
                $response_final['msg']="failure";
                $this->response($response_final);
        }
    }*/

    public function insert_crop_density_samples_post(){
        $data_second['farm_id']=$this->post('farm_id');
        
        $configured_area=$this->post('configured_area');
        
        $spacing_ptp=$this->post('spacing_ptp');
        
        $spacing_rtr=$this->post('spacing_rtr');
        
        $ideal_pop=$this->post('ideal_pop');
        
        $actual_pop=$this->post('actual_pop');
        
        $ideal_total_population=$this->post('ideal_total_population');
        
        $data_second["added_by"]=$this->post('added_by');
        $time=date('Y-m-d H:i:s');
        $data_second["doa"]=$time;
        $data_second["is_active"]='Y';
        $table="crop_density_samples";
        $size=sizeof($configured_area);
        for($i=0;$i<$size;$i++){
            $data_second['configured_area']=$configured_area[$i];
            $data_second['spacing_ptp']=$spacing_ptp[$i];
            $data_second['spacing_rtr']=$spacing_rtr[$i];
            $data_second['ideal_pop']=$ideal_pop[$i];
            $data_second['actual_pop']=$actual_pop[$i];
            $data_second['ideal_total_population']=$ideal_total_population[$i];
            

            $cd_sample_id = $this->android_model->insert($table,$data_second);
            $responsedata[$i]=$cd_sample_id;
        }
        if(sizeof($responsedata)==$size){
            
            //add spacing germination and population in farm table
            $data['germination']=$this->post('avg_germination');
            $data['population']=$this->post('avg_population');
            $data['spacing_rtr']=$this->post('avg_spacing_rtr');
            $data['spacing_ptp']=$this->post('avg_spacing_ptp');
            $table='farm';
            $array['farm_id']=$this->post('farm_id');
            $response=$this->android_model->update($table,$data,$array);
            if($response)
            {
            $response_final['status']=1;
            $response_final['msg']="success";
            $this->response($response_final);
            }
            else
            {
                $response_final['status']=0;
                $response_final['msg']="problem in updating farm table";
                $this->response($response_final);
            }
        }
        else{
            $response_final['status']=0;
            $response_final['msg']="failure";
            $this->response($response_final);
        }
    }
}
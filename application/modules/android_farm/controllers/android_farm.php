<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Android_farm extends MY_Controller {
    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->load->model("android_farm_model");
    }

    public function view_cluster_farms_post(){
        $data_input['cluster_id']=$this->post('cluster_id');
        $data_input['comp_id']=$this->post('comp_id');
        $result=$this->android_farm_model->fetch_cluster_farms($data_input);
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
    }
    public function edit_farm_post(){
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
        $result=$this->android_farm_model->update_farm($data_input,$data);
        if($result==1){
            $data_response['status']=1;
            $data_response['msg']="Farm Updated Succesfully";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to update farm";
            $this->response($data_response);
        }
    }
    public function view_all_farms_post(){
        $comp_id=$this->post('comp_id');
        $result=$this->android_farm_model->fetch_all_farms($comp_id);
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
    }

    public function farm_gps_submit_post(){
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
        $result=$this->android_farm_model->insert_farm_gps($data_input);
        if($result){
        $result=$this->android_farm_model->update_farm_area($area,$farm_id);
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
    }

    public function get_farm_gps_post(){
        $comp_id=$this->post('comp_id');
        $farm_id=$this->post('farm_id');

        $result=$this->android_farm_model->fetch_all_farm_gps($comp_id,$farm_id);
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
    }
    public function update_farm_post(){
        $data['comp_id']=$this->post('comp_id');
        $data['farm_id']=$this->post('farm_id');
        
        $data_input['irrigation_source']=$this->post('irrigation_source');
        $data_input['irrigation_type']=$this->post('irrigation_type');
        $data_input['soil_type']=$this->post('soil_type');
        $data_input['previous_crop']=$this->post('previous_crop');
        $data_input['sowing_date']=$this->post('sowing_date');
        $data_input['exp_harvest_date']=$this->post('exp_harvest_date');
        $data_input['exp_flowering_date']=$this->post('exp_flowering_date');
        $result=$this->android_farm_model->update_farm($data_input,$data);
        if($result==1){
            $data_response['status']=1;
            $data_response['msg']="Farm Updated Succesfully";
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to update farm";
            $this->response($data_response);
        }
    }
    public function update_actual_flowering_date_post()
    {
        //$this->response("this is a string");
        $data['actual_flowering_date']=$this->post('actual_flowering_date');
        $array['farm_id']=$this->post('farm_id');
        $array['is_active']='Y';
        $table='farm';
        $result=$this->android_farm_model->update($table,$data,$array);
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
        $result=$this->android_farm_model->update($table,$data,$array);
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

    public function insert_crop_density_samples_post(){
        $data_second['farm_id']=$this->post('farm_id');
        if(empty($data_second['farm_id']))
        {
            $data_response['msg']="farm_id not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $configured_area=$this->post('configured_area');
        if(empty($configured_area))
        {
            $data_response['msg']="configured_area not received";
            $data_response['status']=0;
            $this->response($data_response);
        }

        $spacing_ptp=$this->post('spacing_ptp');
        if(empty($spacing_ptp))
        {
            $data_response['msg']="spacing_ptp not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
        
        $spacing_rtr=$this->post('spacing_rtr');
        if(empty($spacing_rtr))
        {
            $data_response['msg']="spacing_rtr not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $ideal_pop=$this->post('ideal_pop');
        if(empty($ideal_pop))
        {
            $data_response['msg']="ideal_pop not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $actual_pop=$this->post('actual_pop');
        if(empty($actual_pop))
        {
            $data_response['msg']="actual_pop not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $actual_total_population=$this->post('actual_total_population');
        if(empty($actual_total_population))
        {
            $data_response['msg']="actual_total_population not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
        $data_second["added_by"]=$this->post('added_by');
        if(empty($data_second["added_by"]))
        {
            $data_response['msg']="added_by not received";
            $data_response['status']=0;
            $this->response($data_response);
        }
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
            $data_second['actual_total_population']=$actual_total_population[$i];
            

            $cd_sample_id = $this->android_farm_model->insert($table,$data_second);
            $responsedata[$i]=$cd_sample_id;
        }
        if(sizeof($responsedata)==$size){
            
            //add spacing germination and population in farm table
            $data['germination']=$this->post('avg_germination');
            if(empty($data['germination']))
            {
                $data_response['msg']="avg_germination not received";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $data['population']=$this->post('avg_population');
            if(empty($data['population']))
            {
                $data_response['msg']="avg_population not received";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $data['spacing_rtr']=$this->post('avg_spacing_rtr');
            if(empty($data['spacing_rtr']))
            {
                $data_response['msg']="avg_spacing_rtr not received";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $data['spacing_ptp']=$this->post('avg_spacing_ptp');
            if(empty($data['spacing_ptp']))
            {
                $data_response['msg']="avg_spacing_ptp not received";
                $data_response['status']=0;
                $this->response($data_response);
            }
            $table='farm';
            $array['farm_id']=$this->post('farm_id');
            $response=$this->android_farm_model->update($table,$data,$array);
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
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Farm extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    //    $this->auth();
        $this->load->model("farm_model");
    }
	

    public function add_new_farm_post()
    {
        $comp_id=$this->post('comp_id');
        $data_input_farmer['comp_id']=$comp_id;
        $data_input_farmer['user_id']=0;
        $data_input_farmer['name']=$this->post('name');
        $data_input_farmer['father_name']=$this->post('father_name');
        // $data_input_farmer['addL1']=$this->post('addL1');
        // $data_input_farmer['addL2']=$this->post('addL2');
        $data_input_farmer['mob']=$this->post('mob');
        // $data_input_farmer['village_or_city']=$this->post('village_or_city');
        // $data_input_farmer['mandal_or_tehsil']=$this->post('mandal_or_tehsil');
        // $data_input_farmer['district']=$this->post('district');
        // $data_input_farmer['state']=$this->post('state');
        // $data_input_farmer['country']=$this->post('country');
        $data_input_farmer['doa']=date('Y-m-d h:i:s');
        // $data_input_farmer['gender']=$this->post('gender');
        $data_input_farmer['aadhaar_no']=$this->post('aadhaar_no');
        $data_input_farmer['PAN']=$this->post('PAN');
        $data_input_farmer['bank_name']=$this->post('bank_name');
        $data_input_farmer['bank_account_no']=$this->post('bank_account_no');
        $data_input_farmer['bank_account_holder']=$this->post('bank_account_holder');
        $data_input_farmer['bank_branch']=$this->post('bank_branch');
        $data_input_farmer['bank_ifsc']=$this->post('bank_ifsc');
        $data_input_farmer['agreed_rate']=$this->post('agreed_rate');
        $data_input_farmer['payment_mode']=$this->post('payment_mode');
        // $data_input_farmer['dob']=$this->post('dob');
        $data_input['addL1']=$this->post('farm_addL1');
        $data_input['addL2']=$this->post('farm_addL2');
        $data_input['village_or_city']=$this->post('farm_village_or_city');
        $data_input['mandal_or_tehsil']=$this->post('farm_mandal_or_tehsil');
        $data_input['district']=$this->post('farm_district');
        $data_input['state']=$this->post('farm_state');
        $data_input['country']=$this->post('farm_country');
        $data_input['lot_no']=$this->post('lot_no');
        $data_input['comp_id']=$comp_id;
        $data_input['cluster_id']=$this->post('cluster_id');
        $data_input['exp_area']=$this->post('exp_area');
        $data_input['doa']=date('Y-m-d H:i:s');
        $data_input['seed_provided_on']=$this->post('seed_provided_on');
        $data_input['qty_seed_provided']=$this->post('qty_seed_provided');
        $data_input['seed_unit_id']=$this->post('seed_unit_id');
        $data_input['farmer_id']=$this->farm_model->insert_farmer($data_input_farmer);
        if($data_input['farmer_id']){
            $result=$this->farm_model->insert_farm($data_input);
            if($result){
                $data_response['status']=1;
                $data_response['msg']="Farm Added Succesfully";
                $this->response($data_response);
            }else{
                $data_response['status']=0;
                $data_response['msg']="Unable to add farm";
                $this->response($data_response);
            }
        }else{
            $data_response['status']=0;
            $data_response['msg']="Unable to add farmer";
            $this->response($data_response);
        }
    }

    public function view_cluster_farms_post(){
        $data_input['cluster_id']=$this->post('cluster_id');
        $data_input['comp_id']=$this->post('comp_id');
        $result=$this->farm_model->fetch_cluster_farms($data_input);
        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['result']=$result;
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
        $result=$this->farm_model->update_farm($data_input,$data);
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
        $result=$this->farm_model->fetch_all_farms($comp_id);
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

    public function view_farm_initial_details_post(){
        $comp_id=$this->post('comp_id');
        $farm_id=$this->post('farm_id');
        $result=$this->farm_model->fetch_farm_initial_details($comp_id,$farm_id);
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
        $result=$this->farm_model->insert_farm_gps($data_input);
        if($result){
        $result=$this->farm_model->update_farm_area($area,$farm_id);
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

        $result=$this->farm_model->fetch_all_farm_gps($comp_id,$farm_id);
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

    public function edit_farmer_detail_post()
    {
        $farmer_id=$this->post('farmer_id');
        $data_input_farmer['name']=$this->post('name');
        $data_input_farmer['father_name']=$this->post('father_name');
        $data_input_farmer['mob']=$this->post('mob');
        $data_input_farmer['doa']=date('Y-m-d H:i:s');
        $data_input_farmer['aadhaar_no']=$this->post('aadhaar_no');
        $data_input_farmer['PAN']=$this->post('PAN');
        $data_input_farmer['bank_name']=$this->post('bank_name');
        $data_input_farmer['bank_account_no']=$this->post('bank_account_no');
        $data_input_farmer['bank_account_holder']=$this->post('bank_account_holder');
        $data_input_farmer['bank_branch']=$this->post('bank_branch');
        $data_input_farmer['bank_ifsc']=$this->post('bank_ifsc');
        $data_input_farmer['agreed_rate']=$this->post('agreed_rate');
        $data_input_farmer['payment_mode']=$this->post('payment_mode');
        $array = array('farmer_id' => $farmer_id,'is_active' => "Y" );
        $data['dod']=date("Y-m-d H:i:s");
        $data['deleted_by']=$this->post("person_id");

        $result = $this->farm_model->insert_hist("farmer",$array,"farmer_hist",$data);

        if($result){
            $result = $this->farm_model->update("farmer",$data_input_farmer,$array);

            if($result){
                $data_response['status']=1;
                $data_response['msg']="Succesfull";
                $this->response($data_response);
            }else{
                $data_response['status']=0;
                $data_response['msg']="Sorry Unable to update";
                $this->response($data_response);
            }
        }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to insert history data";
            $this->response($data_response);
        }

    }    

    public function get_farmer_post()
    {
        $data["farmer_id"]=$this->post("farmer_id");
        $data["is_active"]="Y";

        $result = $this->farm_model->fetch_farmer($data);

        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['data']=$result;
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to fetch data";
            $this->response($data_response);
        }
    }

    public function edit_farm_detail_post()
    {
        $farm_id=$this->post('farm_id');
        $data_input=$this->post("data");
        $data_input['doa']=date("Y-m-d H:i:s");
        $array = array('farm_id' => $farm_id,'is_active' => "Y" );
        $data['dod']=date("Y-m-d H:i:s");
        $data['deleted_by']=$this->post("person_id");

        $result = $this->farm_model->insert_hist("farm",$array,"farm_hist",$data);

        if($result){
            $result = $this->farm_model->update("farm",$data_input,$array);

            if($result){
                $data_response['status']=1;
                $data_response['msg']="Succesfull";
                $this->response($data_response);
            }else{
                $data_response['status']=0;
                $data_response['msg']="Sorry Unable to update";
                $this->response($data_response);
            }
        }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to insert history data";
            $this->response($data_response);
        }

    }    

    public function get_farm_post()
    {
        $data["farm_id"]=$this->post("farm_id");
        $data["is_active"]="Y";

        $result = $this->farm_model->fetch_farm($data);

        if($result){
            $data_response['status']=1;
            $data_response['msg']="Succesfull";
            $data_response['data']=$result;
            $this->response($data_response);
        }else{
            $data_response['status']=0;
            $data_response['msg']="Sorry Unable to fetch data";
            $this->response($data_response);
        }
    }

}

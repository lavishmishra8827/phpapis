<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
use \Firebase\JWT\JWT;
class Registration extends MY_Controller{

	public function __construct(){
		parent::__construct();
        $this->load->library('session');
		$this->load->model('registration_model');
        date_default_timezone_set("Asia/Kolkata");
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 200; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
	}

	public function login_post(){
        $data_input['username'] = $this->post('username'); //Username Posted
        $data_input['password'] = sha1($this->post('password')); //Pasword Posted
        $kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid
        $login_result = $this->registration_model->check_login($data_input);
        if($login_result){
            $person_result = $this->registration_model->fetch_person_id($login_result->user_id);
            if($person_result){
                $token['id'] = $login_result->user_id;
                $token['username'] = $data_input['username'];
                $date = new DateTime();
                $token['iat'] = $date->getTimestamp();
                $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
                $data_object['token'] = JWT::encode($token,$kunci ); //This is the output token
                $data_object['comp_id'] = $login_result->comp_id;
                $data_object['person_id'] = $person_result->person_id;
                $log_input['user_id'] = $login_result->user_id;
                $log_input['ip'] = $this->input->ip_address();
                $log_input['gps'] = '0_0';
                $login_result = $this->registration_model->insert_data('login_log',$log_input);
                $data_response['object'] = $data_object;
                $data_response['status'] = 1;
                $data_response['msg'] = "Login Successful";
                $this->response($data_response);
            }else{
                $data_response['status'] = 0;
                $data_response['msg'] = "Error Occurred. Please Try Again.";
                $this->response($data_response);
            } 
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = "Incorrect Credentials";
            $this->response($data_response);
        }
    }

    public function add_supervisor_post(){
        $this->auth();
        $data_input['comp_id'] = $this->post('company_name');;
        $data_input['cluster_id'] = $this->post('cluster_id');
        $data_input['name'] = $this->post('name');
        $data_input['father_name'] = $this->post('father_name');
        $data_input['dob'] = '0000-00-00';

        $data_input['mob'] = $this->post('mob');
        $data_input['mob2'] = $this->post('mob2');
        $data_input['email'] = $this->post('email');
        // $data_input['gender'] = $this->post('gender');
        $data_input['addl1'] = $this->post('addl1');
        $data_input['addl2'] = $this->post('addl2');
        $data_input['village_or_city'] = $this->post('village_or_city');
        $data_input['mandal_or_tehsil'] = $this->post('mandal_or_tehsil');
        $data_input['district'] = $this->post('district');
        $data_input['state'] = $this->post('state');
        $data_input['country'] = $this->post('country');
        $data_input['doa'] = date('Y-m-d H:i:s');
        $data_user['username'] = $this->post('username');
        $data_user['password'] = $this->post('password');
        $data_user['comp_id'] = 1;
        $data_user['doa'] = date('Y-m-d H:i:s');
        // $data_user['password'] = $this->encrypt->sha1($data_user['password']);
        $hash = sha1($data_user['password']);
        $data_user['password'] = $hash;
        $user_result = $this->registration_model->insert_user_master_data($data_user);
        if($user_result){
            $data_input['user_id'] = $user_result;
            $supervisor_result = $this->registration_model->insert_supervisor_data($data_input);
            if($supervisor_result){
                $this->response('Success');
            }else{
                $this->response('Failed');
            }
        }else{
            $this->response('No user data');
        }   
    }

    public function add_person_post(){
        $this->auth();
        $data_input['comp_id'] = $this->post('company_name');
        $data_input['cluster_id'] = $this->post('cluster_id');
        $data_input['role_id'] = $this->post('role_id');
        $data_input['name'] = $this->post('name');
        $data_input['father_name'] = $this->post('father_name');
        $data_input['dob'] = '1000-01-01';
        $data_input['mob'] = $this->post('mob');
        $data_input['mob2'] = $this->post('mob2');
        $data_input['email'] = $this->post('email');
        // $data_input['gender'] = $this->post('gender');
        $data_input['addl1'] = $this->post('addl1');
        $data_input['addl2'] = $this->post('addl2');
        $data_input['village_or_city'] = $this->post('village_or_city');
        $data_input['mandal_or_tehsil'] = $this->post('mandal_or_tehsil');
        $data_input['district'] = $this->post('district');
        $data_input['state'] = $this->post('state');
        $data_input['country'] = $this->post('country');
        $data_input['doa'] = date('Y-m-d H:i:s');
        $data_input['added_by'] = $this->post('added_by');
        $data_user['username'] = $this->post('username');
        $data_user['password'] = $this->post('password');
        $data_user['role_id'] = $this->post('role_id');
        $data_user['comp_id'] = $data_input['comp_id'];
        $data_user['doa'] = date('Y-m-d H:i:s');
        // $data_user['password'] = $this->encrypt->sha1($data_user['password']);
        $hash = sha1($data_user['password']);
        $data_user['password'] = $hash;
        $data_unique['username'] = $data_user['username'];
        $unique_username = $this->registration_model->check_unique('user_master',$data_unique);
        if(!$unique_username){
            $user_result = $this->registration_model->insert_user_master_data($data_user);
            if($user_result){
                $data_input['user_id'] = $user_result;
                $supervisor_result = $this->registration_model->insert_person_data($data_input);
                if($supervisor_result){
                    $data_response['status'] = 1;
                    $data_response['msg'] = "Success";
                    $data_response['result'] = $supervisor_result;
                    $this->response($data_response);
                }else{
                    $data_response['status'] = 0;
                    $data_response['msg'] = "Failed";
                    $data_response['result'] = NULL;
                    $this->response($data_response);
                }
            }else{
                $data_response['status'] = 0;
                $data_response['msg'] = "Failed";
                $data_response['result'] = NULL;
                $this->response($data_response);
            }
        }else{
            $data_response['status'] = 2;
            $data_response['msg'] = "Username already exist";
            $data_response['result'] = NULL;
            $this->response($data_response);
        }   
    }
    public function controller_login_post(){
        $data_input['username'] = $this->post('username'); //Username Posted
        $data_input['password'] = sha1($this->post('password')); //Pasword Posted
        $data_input['role_id'] = 0;
        $data_input['comp_id'] = 0;
        $kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid
        $login_result = $this->registration_model->check_login($data_input);
        if($login_result){
            $person_result = $this->registration_model->fetch_person_id($login_result->user_id);
            if($person_result){
                $token['id'] = $login_result->user_id;
                $token['username'] = $data_input['username'];
                $date = new DateTime();
                $token['iat'] = $date->getTimestamp();
                $token['exp'] = $date->getTimestamp() + 60*60*5; //To here is to generate token
                $data_object['token'] = JWT::encode($token,$kunci ); //This is the output token
                $data_object['comp_id'] = $login_result->comp_id;
                $data_object['person_id'] = $person_result->person_id;
                $log_input['user_id'] = $login_result->user_id;
                $log_input['ip'] = $this->input->ip_address();
                $log_input['gps'] = '0_0';
                $login_result = $this->registration_model->insert_data('login_log',$log_input);
                $data_response['object'] = $data_object;
                $data_response['status'] = 1;
                $data_response['msg'] = "Login Successful";
                $this->response($data_response);
            }else{
                $data_response['status'] = 0;
                $data_response['msg'] = "Error Occurred. Please Try Again.";
                $this->response($data_response);
            } 
        }else{
            $data_response['status'] = 0;
            $data_response['msg'] = "Incorrect Credentials";
            $this->response($data_response);
        }
    }

    public function fetch_all_usernames_post(){
        $usernames = $this->registration_model->fetch_all_usernames();
        if($usernames){
            $data_response['result'] = $usernames;
            $data_response['status'] = 1;
            $data_response['msg'] = "Success";
            $this->response($data_response);
        }else{
            $data_response['result'] = NULL;
            $data_response['status'] = 0;
            $data_response['msg'] = "Failed";
            $this->response($data_response);
        }
    }
}

<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class MY_Controller extends REST_Controller {

	public function __construct(){
		
		parent::__construct();
		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
	       header('Content-type: application/json');
	       header("Access-Control-Allow-Origin: *");
	       header("Access-Control-Allow-Methods: GET");
	       header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
	       header("Access-Control-Allow-Headers: Content-Type, Content-Length,Accept-Encoding,Access-Control-Allow-Origin,Authorization");
	        exit;
	    }
	    header('Content-type: application/json');
	    header("Access-Control-Allow-Origin: *");
	    header("Access-Control-Allow-Methods: GET");
	    header("Access-Control-Allow-Methods: GET,POST, OPTIONS");
	    header("Access-Control-Allow-Headers: Content-Type, Content-Length,Accept-Encoding,Access-Control-Allow-Origin,Authorization");

	}

    private $user_credential;

    public function auth(){
	    // Configure limits on our controller methods
	    // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
	    $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
	    $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
	    $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
	    //JWT Auth middleware
	    $headers = $this->input->get_request_header('Authorization');
	    $kunci = $this->config->item('thekey'); //secret key for encode and decode
	    $token= "token";
	   	if (!empty($headers)) {
	    	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
	        $token = $matches[1];
	    	}
		}
	    try{
	       $decoded = JWT::decode($token, $kunci, array('HS256'));
	       $this->user_data = $decoded;
	    }catch (Exception $e){
	        $invalid = ['status' => $e->getMessage()]; //Respon if credential invalid
	        $this->response($invalid, 401);//401
	    }
	}
}

?>
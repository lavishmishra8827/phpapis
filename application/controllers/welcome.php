<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
      parent::__construct();
      //$this->load->library('session');
    }
	public function index()
	{	
        //return "hello"
        //this->return('hello world');
		// $data['string'] = 'Thank You For visiting us..!!';
		$this->load->view('welcome_message');
	}
    // public function account()
    // {
    // 	$account = $this->input->post('account');
    // 	if($account==1)
    // 	{
    // 		$newdata = array(
    //              'username'  => 'global_multimedia',
    //              'this->db' => $this->load->database('global_multimedia', true)
    //              );
    //         $this->session->set_userdata($newdata);
    // 	}
    //     else
    //     {	
    // 		$newdata = array(
    //              'username'  => 'global_multimedia',
    //              'this->db' => $this->load->database('comet_busters', true)
    //              );
    //         $this->session->set_userdata($newdata);
    //     }
    // }
}
?>


<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Android_app extends MY_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model("android_app");
    }

}
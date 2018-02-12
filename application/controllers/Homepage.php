<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Application
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('presetscsv');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/
     * 	- or -
     * 		http://example.com/welcome/index
     *
     * So any other public methods not prefixed with an underscore will
     * map to /welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
            $this->data['pagetitle'] = 'Path of Exile - Home';
            $this->data['pagebody'] = 'homepage';

            $parts = $this->presetscsv->all();
            $this->data['parts'] = $parts;
            $this->render(); 
    }


}

//use this to debug
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

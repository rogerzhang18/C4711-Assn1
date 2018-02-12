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
	public function index($preset = "")
	{
		$this->data['pagetitle'] = 'Fan-Made Path of Exile Inventory Simulator';
		$this->data['pagebody'] = 'homepage';
		
		if ( $preset != "" )
		{
        	$img = $this->presetscsv->some('name', $preset);
        	$imgName = $img[0]->name;
        	$this->data['preset'] = $imgName;
		}
		else
		{
			$this->data['preset'] = 'background';
		}
		$this->render(); 
	}

	public function console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}
}

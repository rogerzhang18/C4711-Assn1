<?php
 
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class EquipmentsController extends Application
 {
	function __construct()
	{
        parent::__construct();
        $this->load->model('assetscsv');
        $this->data['pagetitle'] = 'Equipments build';
        $this->data['pagebody'] = 'assembly';
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
            /*
 		$this->data['pagetitle'] = 'Equipments build';
 		$this->data['pagebody'] = 'assembly';
            
 		$parts = array();
 
 		$source = $this->equipments->all();
 		foreach ($source as $record)
 		{
 			$parts[] = array('equip_code' => $record['equip_code']);
 		}
 		$this->data['parts'] = $parts;
 		$this->render();
             */
        $this->data['page_category'] = " all-equipments";        
        $items = $this->assetscsv->all();
        $this->data['items'] = $items;
        $this->render();
 	}
        
    public function category($key)
    {
        $this->data['page_category'] = " ".$key;        
        $items = $this->assetscsv->some('category', $key);
        $this->data['items'] = $items;
        $this->render();
    }
 }
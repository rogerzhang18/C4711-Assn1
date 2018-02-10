<?php
 
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class EquipmentsController extends Application
 {
 
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
 	}
 }
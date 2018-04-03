<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class EquipmentsController extends Application
{
    /**
     * Constructor for EquipmentsController.
     * 
     * It loads the assetscsv model, and sets the page title and page body.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('AssetsCsv');
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
        $this->data['page_category'] = " all-equipments";        
        $items = $this->AssetsCsv->all();
        $this->data['items'] = $items;
        $this->render();
    }
        
    public function category($key)
    {
        if($key == "all")
        {
            $items = $this->AssetsCsv->all();
            header("Content-type: application/json");
            echo json_encode($items);
            return;
        }
        if($key == "slots")
        {
            $this->load->model('SlotsCsv');
            $items = $this->SlotsCsv->all();
            header("Content-type: application/json");
            echo json_encode($items);
            return;
        }
        $this->data['page_category'] = " ".$key;        
        $items = $this->AssetsCsv->some('category', $key);
        $this->data['items'] = $items;
        $this->render();
    }

    public function singleItem($key)
    {
        $item = $this->AssetsCsv->some('id', $key);
        header("Content-type: application/json");
        echo json_encode($item);
    }
}

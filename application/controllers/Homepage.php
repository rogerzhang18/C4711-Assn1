<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Application
{
    /**
     * Constructor for Homepage controller.
     * 
     * It loads the presetscsv model.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('PresetsCsv');
    }

    /**
     * Index Page for Homepage controller.
     *
     * It grabs all the data from presetscsv and renders it on specified view.
     */
    public function index()
    {
            $this->data['pagetitle'] = 'Path of Exile - Home';
            $this->data['pagebody'] = 'homepage';

            $parts = $this->PresetsCsv->all();
            $this->data['parts'] = $parts;
            $this->render(); 
    }
}

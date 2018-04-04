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
        $role = $this->session->userdata('userrole');
        // dropdown used as indicator of current role
        if ($role == "")
            $role = "User Role";
        $this->data['userrole'] = $role;

        if ($role == ROLE_OWNER)
        {
            $this->data['savingcontrols'] = '
            <div id="savingControls">
                <div class="container">
                    <div class="row">                   
                        <h3 class="col-sm-2">Edit Presets</h3 >
                    </div>
                    <div class="row">                   
                        <input class="col-sm-2" type="text" id="newPresetName" placeholder="new preset name">
                    </div>
                    <div class="row">                   
                        <button class="col-sm-2" onClick="updatePreset()">Update Existing</button>
                        <button class="col-sm-2" onClick="createPreset()">Create New</button>
                    </div>
                </div>
            </div> ';
        }
        else 
        {
            $this->data['savingcontrols'] = '';
        }

        $presets = $this->PresetsCsv->all();
        $this->data['presets'] = $presets;
        $this->render(); 
    }

}

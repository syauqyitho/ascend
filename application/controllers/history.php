<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $models = array(
            'model_history'
        );
        $this->load->model($models);
        $this->load->library('slice');
    }

    public function index() {
        if (isset($_POST['submit'])) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $name = $this->input->post('name');
            // var_dump($start_date, $end_date, $name);
            // exit();
            $data['reservations'] = $this->model_history->filter_history($start_date, $end_date, $name);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['name'] = $name;
            $this->slice->view('history.index', $data);
        } else {
            $data['reservations'] = $this->model_history->index();
            $this->slice->view('history.index', $data);
        }
        
    }
}
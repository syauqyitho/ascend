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
        // $date_time = new DateTimeImmutable('Asia/Jakarta');
        // $currently = $date_time->format('Y-m-d');
        // var_dump($currently);
        // exit();
        $data['reservations'] = $this->model_history->index();
        $this->slice->view('history.index', $data);
    }

    public function date() {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        // var_dump($start_date, $end_date);
        // exit();
        $data['reservations'] = $this->model_history->filter_by_date($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $this->slice->view('history.index', $data);
    }
}
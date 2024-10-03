<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $models = array(
            'model_report'
        );
        $this->load->model($models);
        $this->load->library('slice');
        $this->load->helper('generate_pdf');
    }

    public function index() {
        if (isset($_POST['submit'])) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $name = $this->input->post('name');
            // var_dump($start_date, $end_date, $name);
            // exit();
            $data['reservations'] = $this->model_report->report_filter($start_date, $end_date, $name);
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $this->slice->view('report.index', $data);
        } else {
            $data['reservations'] = $this->model_report->index();
            $this->slice->view('report.index', $data);
        }
        
    }

    public function pdf() {
        $start_date = $this->uri->segment('3');
        $end_date = $this->uri->segment('4');

        $data['reservations'] = $this->model_report->report_filter($start_date, $end_date);
        $html = $this->slice->view('report.pdf', $data, true);
        generate_pdf($html, 'Laporan Reservasi');
    }
}
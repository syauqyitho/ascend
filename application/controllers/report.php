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
    }

    public function index() {
        if (isset($_POST['submit'])) {
            $id = $this->session->user_id;
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            // var_dump($start_date, $end_date);
            // exit();
            $raw_data = $this->model_activity->user_report($id, $start_date, $end_date);
            $data['activity_details'] = $this->model_activity_detail->list_detail($id)->result();
            $activities = [];

            // Group details by jasa_id
            foreach ($raw_data as $row) {
                $activity_id = $row['activity_id'];

                // Initialize activity if not already present
                if (!isset($activities[$activity_id])) {
                    $activities[$activity_id] = [
                        'user_name' => $row['user_name'],
                        'status' => $row['status'],
                        'activity_category' => $row['activity_category'],
                        'constrain_category' => $row['constrain_category'],
                        'urgency' => $row['urgency'],
                        'constrain' => $row['constrain'],
                        'constrain_description' => $row['constrain_description'],
                        'created_at' => $row['created_at'],
                        'details' => [] // Initialize details array
                    ];
                }
                
                // Check if detail already exists before adding
                $detail_exists = false;
                foreach ($activities[$activity_id]['details'] as $existing_detail) {
                    if ($existing_detail['activity_detail_id'] == $row['activity_detail_id']) {
                        $detail_exists = true;
                        break;
                    }
                }

                // Add the detail to the activity if it doesn't already exist
                if (!$detail_exists) {
                    $activities[$activity_id]['details'][] = [
                        'activity_detail_id' => $row['activity_detail_id'],
                        'tech_name' => $row['tech_name'],
                        'activity_tech_id' => $row['activity_tech_id'],
                        'action_description' => $row['action_description'],
                        'level' => $row['level'],
                        'analyze' => $row['analyze'],
                        'troubleshooting' => $row['troubleshooting'],
                        'reason' => $row['reason']
                    ];
                }
            }
            
            // var_dump($data);
            // exit();
            $data['activity_grouped'] = $activities;
            $data['start_date'] = $this->input->post('start_date');
            $data['end_date'] = $this->input->post('end_date');
            $this->slice->view('user.report.index', $data);
        } else {
            $id = $this->session->user_id;
            // Fetch the data from the model 
            $raw_data = $this->model_activity->user_report($id);
            // Prepare an array to group details by activity_id
            $activities = [];

            // Group details by jasa_id
            foreach ($raw_data as $row) {
                $activity_id = $row['activity_id'];

                // Initialize activity if not already present
                if (!isset($activities[$activity_id])) {
                    $activities[$activity_id] = [
                        'user_name' => $row['user_name'],
                        'status' => $row['status'],
                        'activity_category' => $row['activity_category'],
                        'constrain_category' => $row['constrain_category'],
                        'urgency' => $row['urgency'],
                        'constrain' => $row['constrain'],
                        'constrain_description' => $row['constrain_description'],
                        'created_at' => $row['created_at'],
                        'details' => [] // Initialize details array
                    ];
                }
                
                // Check if detail already exists before adding
                $detail_exists = false;
                foreach ($activities[$activity_id]['details'] as $existing_detail) {
                    if ($existing_detail['activity_detail_id'] == $row['activity_detail_id']) {
                        $detail_exists = true;
                        break;
                    }
                }

                // Add the detail to the activity if it doesn't already exist
                if (!$detail_exists) {
                    $activities[$activity_id]['details'][] = [
                        'activity_detail_id' => $row['activity_detail_id'],
                        'tech_name' => $row['tech_name'],
                        'activity_tech_id' => $row['activity_tech_id'],
                        'action_description' => $row['action_description'],
                        'level' => $row['level'],
                        'analyze' => $row['analyze'],
                        'troubleshooting' => $row['troubleshooting'],
                        'reason' => $row['reason']
                    ];
                }
            }

            $data['activity_grouped'] = $activities;
            $data['start_date'] = date('Y-m-d');
            $data['end_date'] = date('Y-m-d');

            // var_dump($data);
            // exit();
            $this->slice->view('user.report.index', $data);
        }
    }
}
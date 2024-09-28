<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $models = array(
            'model_room',
            'model_room_type',
            'model_room_status'
        );
        $this->load->model($models);
        $this->load->library('slice');
    }
    
    public function index() {
        $data['rooms'] = $this->model_room->index();
        $this->slice->view('room.index', $data);
    }
    
    public function show($id) {
        $data['rooms'] = $this->model_room->show($id);
        $data['room_type'] = $this->model_room_type->index();
        $data['room_status'] = $this->model_room_status->index();
        // var_dump($data);
        // exit();
        $this->slice->view('room.show', $data);
    }
    
    public function update($id) {
        $data = array(
            'room_status_id' => $this->input->post('room_status')
        );

        // var_dump($data);
        // exit();
        $this->model_room->update($id, $data);
        redirect('room');
    }
}
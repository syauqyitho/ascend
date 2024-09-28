<?php

class Model_room_status extends CI_Model {
    
    public function index() {
        return $this->db->get('room_status')->result();
    }
}
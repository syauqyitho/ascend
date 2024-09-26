<?php

class Model_reservation_status extends CI_Model {
    public function index() {
        $query = $this->db->get('reservation_status');
        return $query->result();
    }
}

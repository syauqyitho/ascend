<?php

class Model_reservation_type extends CI_Model {
    public function index() {
        return $this->db->get('reservation_type')->result();
    }
}

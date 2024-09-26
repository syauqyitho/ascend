<?php

class Model_room_type extends CI_Model {

    public function index() {
        $query = $this->db->get('room_type');
        return $query->result();
    }

    public function find_available_room($id) {
        $this->db->select('*');
        $this->db->from('room_type rt');
        $this->db->join('room r', 'rt.room_type_id = r.room_type_id', 'left');
        $this->db->join('room_status rs', 'rs.room_status_id = r.room_status_id', 'left');
        $this->db->where('rs.room_status_id', 1);
        $this->db->where('rt.room_type_id', $id);
        
        
        $query = $this->db->get();
        return $query->row();
    }
}

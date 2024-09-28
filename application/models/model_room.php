<?php

class Model_room extends CI_Model {
    
    public function index() {
        $this->db->select('
            r.room_id,
            rt.room_type_name AS room_type,
            rs.room_status_name AS room_status
        ');
        $this->db->from('room r');
        $this->db->join('room_type rt', 'r.room_type_id = rt.room_type_id', 'left');
        $this->db->join('room_status rs', 'r.room_status_id = rs.room_status_id', 'left');
        return $this->db->get()->result();
    }
    
    public function show($id) {
        return $this->db->get_where('room', array('room_id' => $id))->row();
    }
    
    public function update($id, $data) {
        $this->db->trans_start();

        // Check is status change or not
        $room_status = $this->db->get_where('room', array('room_id' => $id))->row();

        // Check room_type availability
        $this->db->select('');
        $this->db->from('room_type rt');
        $this->db->join('room r', 'rt.room_type_id = r.room_type_id', 'left');
        $this->db->join('room_status rs', 'r.room_status_id = rs.room_status_id', 'left');
        $this->db->where('r.room_status_id', 1);
        $this->db->where('r.room_type_id', $data['room_type_id']);
        $room_type = $this->db->get()->row();
        
        if ($data['room_status_id'] != $room_status->room_status_id) {
            // Change status
            $change_status = array(
                'room_status_id' => $data['room_status_id']
            );
            
            $this->db->where('room_id', $id);
            $this->db->update('room', $change_status);
        }

        $this->db->trans_complete();
    }
}
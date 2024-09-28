<?php

class Model_room extends CI_Model {
    
    public function index() {
        $this->db->select('
            r.room_id,
            r.room_number,
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
        
        if ($data['room_status_id'] != $room_status->room_status_id) {
            if ($data['room_status_id'] == 1) {
                // Change status
                $change_status = array(
                    'room_status_id' => $data['room_status_id']
                );

                $this->db->where('room_id', $id);
                $this->db->update('room', $change_status);

                // Increment Room Type Availability 
                $this->db->set('available_room', 'available_room + 1', FALSE);
                $this->db->where('room_type_id', $room_status->room_type_id);
                $this->db->update('room_type');
            } elseif ($room_status->room_status_id != 1) {
                // Change status
                $change_status = array(
                    'room_status_id' => $data['room_status_id']
                );
                
                $this->db->where('room_id', $id);
                $this->db->update('room', $change_status);
            } else {
                // Change status
                $change_status = array(
                    'room_status_id' => $data['room_status_id']
                );
                
                $this->db->where('room_id', $id);
                $this->db->update('room', $change_status);

                // Decrement Room Type Availability 
                $this->db->set('available_room', 'available_room - 1', FALSE);
                $this->db->where('room_type_id', $room_status->room_type_id);
                $this->db->update('room_type');
            }
        }

        $this->db->trans_complete();
    }
}
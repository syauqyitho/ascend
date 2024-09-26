<?php

class RoomHelper {
    protected $db;

    public function __construct($db) {
        $this->db = $db; // Injecting the database instance
    }

    // Get an available room of a specific type
    public function get_available_room($room_type_id) {
        $this->db->select('room_id');
        $this->db->where('room_type_id', $room_type_id);
        $this->db->where('room_status_id', 1); // Assuming 1 is the status for Available
        return $this->db->get('room')->row();
    }

    // Update room availability
    public function update_room_availability($room_type_id) {
        $this->db->set('total_available', 'total_available - 1', FALSE);
        $this->db->where('room_type_id', $room_type_id);
        $this->db->update('room_type');

        // Check if this was the last room
        $this->db->select('total_available');
        $this->db->where('room_type_id', $room_type_id);
        $room_type = $this->db->get('room_type')->row();

        if ($room_type && $room_type->total_available == 0) {
            // Change the last room's status to Out of Order
            $this->db->set('room_status_id', /* ID for Out of Order */);
            $this->db->where('room_type_id', $room_type_id);
            $this->db->where('room_status_id', 1); // Update only available rooms
            $this->db->update('room');
        }
    }

    // Change the room type
    public function change_room_type($room_id, $new_room_type_id) {
        $this->db->set('room_type_id', $new_room_type_id);
        $this->db->where('room_id', $room_id);
        $this->db->update('room');
    }
}

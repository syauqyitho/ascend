<?php

class Model_reservation extends CI_Model {

    public function index() {
        $this->db->select('
            rsv.reservation_id,
            rsv.first_name,
            rsv.last_name,
            rsvd.room_id,
            rsv.created_at,
            rsvs.reservation_status_name,
            rt.room_type_name
        ');
        $this->db->from('reservation rsv');
        $this->db->join('reservation_detail rsvd', 'rsv.reservation_id = rsvd.reservation_id', 'left');
        $this->db->join('room r', 'rsvd.room_id = r.room_id', 'left');
        $this->db->join('room_type rt', 'r.room_type_id = rt.room_type_id', 'left');
        $this->db->join('reservation_status rsvs', 'rsv.reservation_status_id = rsvs.reservation_status_id', 'left');
        return $this->db->get()->result();
    }
    
    public function store($data) {
        // Assuming $data contains: 
        // $data['room_type_id'], $data['room_id'] 

        $this->db->trans_start();

        $data_reservation = array(
            'reservation_status_id' => $data['reservation_status_id'],
            'reservation_type_id' => $data['reservation_type_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'address' => $data['address'],
            'arrival' => $data['arrival'],
            'departure' => $data['departure'],
            'child' => $data['child'],
            'adult' => $data['adult'],
            'created_at' => $data['created_at']
        );

        try {
            // // 1. Check Room Availability (You'll need a separate function for this)
            // if (!$this->check_room_availability($data['room_id'], $data['arrival'], $data['departure'])) { 
            //     $this->db->trans_rollback();
            //     return false; // Room is not available
            // }

            // 2. Insert Reservation 
            $this->db->insert('reservation', $data_reservation);
            
            // Get reservation_id
            $reservation_id = $this->db->insert_id();
            $data_reservation_detail = array(
                'reservation_id' => $reservation_id,
                'room_type_id' => $data['room_type_id'],
                'room_id' => $data['room_id']
            );
            
            $this->db->insert('reservation_detail', $data_reservation_detail);

            // 3. Update Room Status to 'Reserved'
            $reserved_status_id = 3/* ID for 'Reserved' status */;
            $this->db->set('room_status_id', $reserved_status_id);
            $this->db->where('room_id', $data_reservation_detail['room_id']);
            $this->db->update('room');

            // 4. Decrement Room Type Availability 
            $this->db->set('available_room', 'available_room - 1', FALSE);
            $this->db->where('room_type_id', $data_reservation_detail['room_type_id']);
            $this->db->update('room_type');

            $this->db->trans_complete();
            return ($this->db->trans_status() === FALSE) ? false : true; 

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', "Reservation creation failed: " . $e->getMessage());
            return false; 
        }
    }

    public function show($id) {
        $reservation = $this->db->get_where('reservation', array('reservation_id' => $id))->row();
        // Find reservatoin_detail
        $reservation_detail = $this->db->get_where('reservation_detail', array('reservation_id' => $id))->row();

        return $data = array(
            'reservation_status_id' => $reservation->reservation_status_id,
            'reservation_type_id' => $reservation->reservation_type_id,
            'room_type_id' => $reservation_detail->room_type_id,
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'phone_number' => $reservation->phone_number,
            'email' => $reservation->email,
            'address' => $reservation->address,
            'arrival' => $reservation->arrival,
            'departure' => $reservation->departure,
            'child' => $reservation->child,
            'adult' => $reservation->adult
        );
    }
    public function update($data) {
        $this->db->trans_start();

        $data_reservation = array(
            'reservation_status_id' => $data['reservation_status_id'],
            'reservation_type_id' => $data['reservation_type_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'address' => $data['address'],
            'arrival' => $data['arrival'],
            'departure' => $data['departure'],
            'child' => $data['child'],
            'adult' => $data['adult'],
            'created_at' => $data['created_at']
        );

        $data_reservation_detail = array(
            'room_type_id' => $data['reservation_status_id'],
        );

        $this->db->where('reservation_id', $id);
        $this->db->update('reseravation', $data_reservation);
        
        // Update reservation_detail
        $reservation_detail = $this->db->get_where('reservation_detail', array('reservation_id' => $id))->row_array();
        $this->db->where('reservation_detail_id', $reservation_detail['reservation_detail_id']);
        $this->db->update('reservation_detail', $data_reservation_detail);
        
        // Update room availability
        $this->db->set('total_available', 'total_available - 1', FALSE);
        $this->db->where('room_type_id', $data['room_type_id']);
        $this->db->update('room_type');

        // Check if this was the last room
        $this->db->select('total_available');
        $this->db->where('room_type_id', $data['room_type_id']);
        $room_type = $this->db->get('room_type')->row();

        if ($room_type && $room_type->total_available == 0) {
            // Change the last room's status to Out of Order
            $this->db->set('room_status_id', /* ID for Out of Order */);
            $this->db->where('room_type_id', $data['room_type_id']);
            $this->db->where('room_status_id', 1); // Update only available rooms
            $this->db->update('room');
        }

        // Change toom type
        $this->db->set('room_type_id', $new_room_type_id);
        $this->db->where('room_id', $room_id);
        $this->db->update('room');
        $this->db->trans_complete();
    }
}
// <?php

// class ReservationModel {
//     protected $db;

//     public function __construct($db) {
//         $this->db = $db; // Injecting the database instance
//     }

//     public function store($data) {
//         // Start a transaction for data integrity
//         $this->db->trans_start();

//         $roomHelper = new RoomHelper($this->db); // Create instance of the helper

//         // Retrieve available room
//         $room = $roomHelper->getAvailableRoom($data['room_type_id']);
        
//         if (!$room) {
//             return false; // Handle case where no room is available
//         }

//         // Insert the reservation data
//         $data['room_id'] = $room->room_id; // Assign the room_id
//         $this->db->insert('reservation', $data);

//         // Update room availability
//         $roomHelper->updateRoomAvailability($data['room_type_id']);

//         // Optionally change the room type if a new room type is provided
//         if (isset($data['new_room_type_id'])) {
//             $roomHelper->changeRoomType($room->room_id, $data['new_room_type_id']);
//         }

//         // Complete the transaction
//         $this->db->trans_complete();

//         // Return success status
//         return $this->db->trans_status() !== FALSE;
//     }
// }

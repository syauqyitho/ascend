<?php

class Model_reservation extends CI_Model {

    public function index() {
        $this->db->select('
            rsv.reservation_id,
            rsv.first_name,
            rsv.last_name,
            rsv.phone_number,
            rsv.arrival,
            rsv.departure,
            rsvs.reservation_status_name,
            rt.room_type_name
        ');
        $this->db->from('reservation rsv');
        $this->db->join('room r', 'rsv.room_id = r.room_id', 'left');
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
            'room_id' => $data['room_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'child' => $data['child'],
            'adult' => $data['adult'],
            'arrival' => $data['arrival'],
            'departure' => $data['departure'],
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
            
            // 3. Update Room Status to 'Reserved'
            $reserved_status_id = 3/* ID for 'Reserved' status */;
            $this->db->set('room_status_id', $reserved_status_id);
            $this->db->where('room_id', $data['room_id']);
            $this->db->update('room');

            // 4. Decrement Room Type Availability 
            $this->db->set('available_room', 'available_room - 1', FALSE);
            $this->db->where('room_type_id', $data['room_type_id']);
            $this->db->update('room_type');

            $this->db->trans_complete();
            return ($this->db->trans_status() === FALSE) ? false : true; 

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', "Reservation creation failed: " . $e->getMessage());
            return $e->getMessage(); 
        }
    }

    public function show($id) {
        $reservation = $this->db->get_where('reservation', array('reservation_id' => $id))->row();
        // Find room_type of room_id
        $room_type = $this->db->get_where('room', array('room_id' => $reservation->room_id))->row();

        return $data = array(
            'reservation_id' => $reservation->reservation_id,
            'reservation_status_id' => $reservation->reservation_status_id,
            'reservation_type_id' => $reservation->reservation_type_id,
            'room_type_id' => $room_type->room_type_id,
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'phone_number' => $reservation->phone_number,
            'email' => $reservation->email,
            'child' => $reservation->child,
            'adult' => $reservation->adult,
            'arrival' => $reservation->arrival,
            'departure' => $reservation->departure,
            'check_out' => $reservation->check_in,
            'check_in' => $reservation->check_out
        );
    }

    public function update($id, $data) {
        $this->db->trans_start();
        
        // Check room_type availability
        $this->db->select('
            r.room_id,
            r.room_type_id,
            r.room_status_id
        ');
        $this->db->from('room_type rt');
        $this->db->join('room r', 'rt.room_type_id = r.room_type_id', 'left');
        $this->db->join('room_status rs', 'r.room_status_id = rs.room_status_id', 'left');
        $this->db->where('rs.room_status_id', 1);
        $this->db->where('rt.room_type_id', $data['room_type_id']);
        $is_available = $this->db->get()->row();

        // Check if room_type is not same
        $this->db->select('
            r.room_id,
            r.room_type_id,
            r.room_status_id
        ');
        $this->db->from('room r');
        $this->db->join('reservation rsv', 'r.room_id = rsv.room_id', 'left');
        $this->db->where('rsv.reservation_id', $id);
        $room = $this->db->get()->row();
        

        // $room_type = $this->db->get_where('room`', array('reservation_id' => $id))->row_array();
        
        if ($data['room_type_id'] != $room->room_type_id) {
            // $data = '2';
            $data_reservation = array(
                'reservation_status_id' => $data['reservation_status_id'],
                'reservation_type_id' => $data['reservation_type_id'],
                'room_id' => $is_available->room_id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'child' => $data['child'],
                'adult' => $data['adult'],
                'arrival' => $data['arrival'],
                'departure' => $data['departure'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out']
            );

            $this->db->where('reservation_id', $id);
            $this->db->update('reservation', $data_reservation);
            
            // Update Room Status to 'Reserved'
            $reserved_status_id = 3/* ID for 'Reserved' status */;
            $this->db->set('room_status_id', $reserved_status_id);
            $this->db->where('room_id', $is_available->room_id);
            $this->db->update('room');

            // Decrement Room Type Availability 
            $this->db->set('available_room', 'available_room - 1', FALSE);
            $this->db->where('room_type_id', $is_available->room_type_id);
            $this->db->update('room_type');

            // Set Room Status to 'available'
            $clean_status_id = 5/* ID for 'Available' status */;
            $this->db->set('room_status_id', $clean_status_id);
            $this->db->where('room_id', $room->room_id);
            $this->db->update('room');

            // Decrement Room Type Availability 
            $this->db->set('available_room', 'available_room + 1', FALSE);
            $this->db->where('room_type_id', $room->room_type_id);
            $this->db->update('room_type');
        } else {
            // $data = '3';
            $data_reservation = array(
                'reservation_status_id' => $data['reservation_status_id'],
                'reservation_type_id' => $data['reservation_type_id'],
                'room_id' => $room->room_id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'child' => $data['child'],
                'adult' => $data['adult'],
                'arrival' => $data['arrival'],
                'departure' => $data['departure'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
            );

            $this->db->where('reservation_id', $id);
            $this->db->update('reservation', $data_reservation);
        }
        
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

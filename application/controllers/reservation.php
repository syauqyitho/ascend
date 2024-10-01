<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $models = array(
            'model_reservation',
            'model_reservation_status',
            'model_reservation_type',
            'model_room_type'
        );
        $this->load->library('slice');
        $this->load->model($models);
    }
    
    public function index() {
        $data['reservations'] = $this->model_reservation->index();
        $this->slice->view('reservation.index', $data);
    }
    
    public function create() {
        $data['reservation_status'] = $this->model_reservation_status->index();
        $data['reservation_type'] = $this->model_reservation_type->index();
        $data['room_type'] = $this->model_room_type->index();

        // var_dump($data['room_type']);
        // exit();
        $this->slice->view('reservation.create', $data);
    }
    
    public function store() {
        $dt = new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta'));
        $created_at = $dt->format('Y-m-d H:i:s');
        // $available_room = $this->model_room_type->find_available_room(1); 
        $available_room = $this->model_room_type->find_available_room($this->input->post('room_type')); 
        
        // var_dump($available_room);
        // exit();

        if ($available_room) {
            // $data = array(
            //     'reservation_status_id' => 1, 
            //     'reservation_type_id' => 1, 
            //     'room_id' => $available_room->room_id, 
            //     'first_name' => 'Bob',
            //     'last_name' => 'Williams',
            //     'phone_number' => '085566778899', 
            //     'email' => 'bob.williams@example.com',
            //     'child' => 0, 
            //     'adult' => 2,
            //     'arrival' => '2024-09-22',
            //     'departure' => '2024-09-25',
            //     'created_at' => $created_at
            // );
            
            // Sample data
            // [
            //     'reservation_status_id' => 2, 
            //     'reservation_type_id' => 2, 
            //     'room_id' => $available_room->room_id, 
            //     'first_name' => 'John',
            //     'last_name' => 'Doe',
            //     'phone_number' => '081234567890',
            //     'email' => 'john.doe@example.com',
            //     'child' => 1, 
            //     'adult' => 2,
            //     'arrival' => '2024-09-05',
            //     'departure' => '2024-09-08',
            //     'created_at' => $created_at 
            // ],
            // [
            //     'reservation_status_id' => 1, 
            //     'reservation_type_id' => 1, 
            //     'room_id' => $available_room->room_id,
            //     'first_name' => 'Jane',
            //     'last_name' => 'Smith',
            //     'phone_number' => '089876543210', 
            //     'email' => 'jane.smith@example.com',
            //     'child' => 2, 
            //     'adult' => 2,
            //     'arrival' => '2024-09-10', 
            //     'departure' => '2024-09-15', 
            //     'created_at' => $created_at 
            // ],
            // [
            //     'reservation_status_id' => 1,
            //     'reservation_type_id' => 3,
            //     'room_id' => $available_room->room_id, 
            //     'first_name' => 'Alice',
            //     'last_name' => 'Johnson',
            //     'phone_number' => '087788990011', 
            //     'email' => 'alice.johnson@example.com',
            //     'child' => 0,
            //     'adult' => 1,
            //     'arrival' => '2024-09-18',
            //     'departure' => '2024-09-20',
            //     'created_at' => $created_at
            // ],
            // [
            //     'reservation_status_id' => 1, 
            //     'reservation_type_id' => 1, 
            //     'room_id' => $available_room->room_id, 
            //     'first_name' => 'Bob',
            //     'last_name' => 'Williams',
            //     'phone_number' => '085566778899', 
            //     'email' => 'bob.williams@example.com',
            //     'child' => 0, 
            //     'adult' => 2,
            //     'arrival' => '2024-09-22',
            //     'departure' => '2024-09-25',
            //     'created_at' => $created_at
            // ],


            $data = array(
                'reservation_status_id' => $this->input->post('reservation_status'),
                'reservation_type_id' => $this->input->post('reservation_type'),
                'room_type_id' => $available_room->room_type_id,
                'room_id' => $available_room->room_id,
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone_number' => $this->input->post('phone_number'),
                'email' => $this->input->post('email'),
                'child' => $this->input->post('child'),
                'adult' => $this->input->post('adult'),
                'arrival' => $this->input->post('arrival'),
                'departure' => $this->input->post('departure'),
                'created_at' => $created_at
            );

            // var_dump($data);
            // exit();
            $this->model_reservation->store($data);
            $error_message = $this->model_reservation->store($data);
            redirect('reservation');

            // if ($booking_id) {
            //     // Booking successful
            //     redirect('bookings/success/' . $booking_id); 
            // } else {
            //     // Booking failed 
            //     // ... handle the error
            // }

        } else {
            $data = array(
                'reservation_status_id' => $this->input->post('reservation_status'),
                'reservation_type_id' => $this->input->post('reservation_type'),
                'room_type_id' => $this->input->post('room_type_id'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone_number' => $this->input->post('phone_number'),
                'email' => $this->input->post('email'),
                'child' => $this->input->post('child'),
                'adult' => $this->input->post('adult'),
                'arrival' => $this->input->post('arrival'),
                'departure' => $this->input->post('departure'),
            );

            // No rooms of that type available
            $this->session->set_flashdata('error', $error_message);
            // $this->session->set_flashdata('error', 'Sorry, no rooms of that type are available');
            // $this->slice->view('reservation.create', $data);
            redirect('reservation/create');
        }
    }
    
    public function show($id) {
        $data['reservations'] = $this->model_reservation->show($id);
        // $arrival = date('Y-m-d\ H:i', strtotime($data['reservations']['arrival']));
        // $departure = date('Y-m-d\ H:i', strtotime($data['reservations']['departure']));
        // $data['reservations']['arrival'] = $arrival;
        // $data['reservations']['departure'] = $departure;
        $data['reservation_status'] = $this->model_reservation_status->index();
        $data['reservation_type'] = $this->model_reservation_type->index();
        $data['room_type'] = $this->model_room_type->index();
        // var_dump($data['reservations']);
        // var_dump($data);
        // exit();
        $this->slice->view('reservation.show', $data);
    }
    
    public function update($id) {
        $data = array(
            'reservation_status_id' => $this->input->post('reservation_status'),
            'reservation_type_id' => $this->input->post('reservation_type'),
            'room_type_id' => $this->input->post('room_type'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'phone_number' => $this->input->post("phone_number"),
            'email' => $this->input->post('email'),
            'child' => $this->input->post('child'),
            'adult' => $this->input->post('adult'),
            'arrival' => $this->input->post("arrival"),
            'departure' => $this->input->post('departure'),
            'check_in' => $this->input->post("check_in"),
            'check_out' => $this->input->post('check_out'),
        );

        // var_dump($data);
        // exit();
        
        $this->model_reservation->update($id, $data);
        redirect('reservation');
        // $available_room = $this->model_room_type->find_available_room($this->input->post('room_type_id')); 
        
        // var_dump($available_room);
        // exit();

        // if ($available_room) {
        //     // $data = array(
        //     //     'reservation_status_id' => $this->input->post('reservation_status'),
        //     //     'reservation_type_id' => $this->input->post('reservation_type'),
        //     //     'room_id' => $available_room->room_id,
        //     //     'first_name' => $this->input->post('first_name'),
        //     //     'last_name' => $this->input->post('last_name'),
        //     //     'phone_number' => $this->input->post('phone_number'),
        //     //     'email' => $this->input->post('email'),
        //     //     'address' => $this->input->post('address'),
        //     //     'arrival' => $this->input->post('arrival'),
        //     //     'departure' => $this->input->post('departure'),
        //     //     'child' => $this->input->post('child'),
        //     //     'adult' => $this->input->post('adult'),
        //     //     'created_at' => $created_at
        //     // );

        //     $data = array(
        //         'reservation_status_id' => 1,
        //         'reservation_type_id' => 1,
        //         'room_type_id' => 3,
        //         'first_name' => 'niki',
        //         'last_name' => 'lada',
        //         'phone_number' => '098765457',
        //         'email' => 'niki@email.com',
        //         'address' => 'jln sumedang barat',
        //         'arrival' => '',
        //         'departure' => '',
        //         'child' => 0,
        //         'adult' => 2
        //     );

        //     $this->model_reservation->update($id, $data);
        //     redirect('reservation');

        //     // if ($booking_id) {
        //     //     // Booking successful
        //     //     redirect('bookings/success/' . $booking_id); 
        //     // } else {
        //     //     // Booking failed 
        //     //     // ... handle the error
        //     // }

        // } else {
        //     // No rooms of that type available
        //     // $this->session->set_flashdata('error', 'Sorry, no rooms of that type are available for the selected dates.');
        //     $this->session->set_flashdata('error', 'Sorry, no rooms of that type are available');
        //     $this->slice->view('reservation.store', $data);
        // }
    }
}

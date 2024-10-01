<?php

class Model_history extends CI_Model {
    
    public function index() {
        // Current Datetime
        $date_time = new DateTimeImmutable('Asia/Jakarta');
        $currently = $date_time->format('Y-m-d');

        $this->db->select('
            rsv.reservation_id,
            rsv.first_name,
            rsv.last_name,
            rsv.phone_number,
            rsv.departure,
            rsv.arrival,
            rt.room_type_name,
            rs.reservation_status_name
        ');
        $this->db->from('reservation rsv');
        $this->db->join('room r', 'rsv.room_id = r.room_id', 'left');
        $this->db->join('room_type rt', 'r.room_type_id = rt.room_type_id', 'left');
        $this->db->join('reservation_status rs', 'rsv.reservation_status_id = rs.reservation_status_id', 'left');
        $this->db->where('date(rsv.departure) <=', $currently);
        return $this->db->get()->result();
    }
    
    public function filter_history($start_date, $end_date, $name = null) {
        $this->db->select('
            rsv.reservation_id,
            rsv.first_name,
            rsv.last_name,
            rsv.phone_number,
            rsv.departure,
            rsv.arrival,
            rt.room_type_name,
            rs.reservation_status_name
        ');
        $this->db->from('reservation rsv');
        $this->db->join('room r', 'rsv.room_id = r.room_id', 'left');
        $this->db->join('room_type rt', 'r.room_type_id = rt.room_type_id', 'left');
        $this->db->join('reservation_status rs', 'rsv.reservation_status_id = rs.reservation_status_id', 'left');
        $this->db->where('date(rsv.departure) >=', $start_date);
        $this->db->where('date(rsv.departure) <=', $end_date);
        
        if ($name) {
            $this->db->where('concat(rsv.first_name, " ", rsv.last_name) like', '%'.$name.'%');
        }
        
        return $this->db->get()->result();
    }
}
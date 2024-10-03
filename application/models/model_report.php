<?php

class Model_report extends CI_Model {
    
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
            rsv.check_in,
            rsv.check_out,
            rt.room_type_name,
            rs.reservation_status_name,
            r.room_number
        ');
        $this->db->from('reservation rsv');
        $this->db->join('room r', 'rsv.room_id = r.room_id', 'left');
        $this->db->join('room_type rt', 'r.room_type_id = rt.room_type_id', 'left');
        $this->db->join('reservation_status rs', 'rsv.reservation_status_id = rs.reservation_status_id', 'left');
        $this->db->where('date(rsv.departure) <=', $currently);
        return $this->db->get()->result();
    }
    
    public function report_filter($start_date, $end_date) {
        $this->db->select('
            rsv.reservation_id,
            rsv.first_name,
            rsv.last_name,
            rsv.phone_number,
            rsv.departure,
            rsv.arrival,
            rsv.check_in,
            rsv.check_out,
            rt.room_type_name,
            rs.reservation_status_name,
            r.room_number
        ');
        $this->db->from('reservation rsv');
        $this->db->join('room r', 'rsv.room_id = r.room_id', 'left');
        $this->db->join('room_type rt', 'r.room_type_id = rt.room_type_id', 'left');
        $this->db->join('reservation_status rs', 'rsv.reservation_status_id = rs.reservation_status_id', 'left');
        $this->db->where('date(rsv.departure) >=', $start_date);
        $this->db->where('date(rsv.departure) <=', $end_date);
        
        return $this->db->get()->result();
    }
}
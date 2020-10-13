<?php
class Main_model extends CI_MODEL{
    public function add_data($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function get_one($table, $where){
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function get_all($table, $where = "", $order = "", $by = "ASC"){
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($order)
            $this->db->order_by($order, $by);
        return $this->db->get()->result_array();
    }

    public function get_all_group_by($table, $where = "", $group = ""){
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($group)
            $this->db->group_by($group);
        return $this->db->get()->result_array();
    }

    public function edit_data($table, $where, $data){
        $this->db->where($where);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function delete_data($table, $where){
        $this->db->where($where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

    public function nominal($nominal){
        $nominal = str_replace("Rp. ", "", $nominal);
        $nominal = str_replace(".", "", $nominal);
        return $nominal;
    }

    public function get_last_id($table, $col, $where = "", $order_by = ""){
        $this->db->select($col);
        $this->db->from($table);
        if($where)
            $this->db->where($where);
        if($order_by)
            $this->db->order_by($order_by, "DESC");
        else
            $this->db->order_by($col, "DESC");
        return $this->db->get()->row_array();
    }
    
    public function get_last_id_cash(){
        $bulan = date("m", strtotime($this->input->post("tgl")));
        $tahun = date("Y", strtotime($this->input->post("tgl")));
        $this->db->select("substr(id_pembayaran, -3) as id");
        $this->db->from("pembayaran");
        $this->db->where("MONTH(tgl_pembayaran)", $bulan);
        $this->db->where("YEAR(tgl_pembayaran)", $tahun);
        $this->db->order_by("id", "DESC");
        return $this->db->get()->row_array();
    }

    public function get_last_id_transfer(){
        $bulan = date("m", strtotime($this->input->post("tgl")));
        $tahun = date("Y", strtotime($this->input->post("tgl")));
        $this->db->select("substr(id_transfer, 1, 3) as id");
        $this->db->from("transfer");
        $this->db->where("MONTH(tgl_transfer)", $bulan);
        $this->db->where("YEAR(tgl_transfer)", $tahun);
        $this->db->order_by("id", "DESC");
        return $this->db->get()->row_array();
    }
    
    public function get_last_id_ppu_cash(){
        $bulan = date("m", strtotime($this->input->post("tgl")));
        $tahun = date("Y", strtotime($this->input->post("tgl")));
        $this->db->select("substr(id, -3) as id");
        $this->db->from("ppu_cash");
        $this->db->where("MONTH(tgl)", $bulan);
        $this->db->where("YEAR(tgl)", $tahun);
        $this->db->order_by("id", "DESC");
        return $this->db->get()->row_array();
    }
    
    public function get_last_id_ppu_transfer(){
        $bulan = date("m", strtotime($this->input->post("tgl")));
        $tahun = date("Y", strtotime($this->input->post("tgl")));
        $this->db->select("substr(id, 1, 3) as id");
        $this->db->from("ppu_transfer");
        $this->db->where("MONTH(tgl)", $bulan);
        $this->db->where("YEAR(tgl)", $tahun);
        $this->db->order_by("id", "DESC");
        return $this->db->get()->row_array();
    }
}
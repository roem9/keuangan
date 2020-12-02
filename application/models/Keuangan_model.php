<?php
class Keuangan_model extends CI_MODEL{
    
    // get by
        public function get_peserta_kbm($id_kbm){
            $this->db->select("count(id_peserta) as peserta_hadir");
            $this->db->from("presensi_peserta");
            $this->db->where("id_kbm", $id_kbm);
            $this->db->where("hadir", 1);
            return $this->db->get()->row_array();
        }
        
        public function get_kelas_by_periode($bulan, $tahun, $nip){
            $periode = $bulan . " " . $tahun;
            $this->db->select("a.id_kelas, a.nip, concat(MONTH(tgl), ' ', YEAR(tgl)) as periode, a.peserta, max(a.jum_peserta) as jum_peserta, a.program_kbm, a.id_jadwal, b.hari, b.jam, b.tempat, tipe_kelas, b.ot");
            $this->db->from("kbm as a");
            $this->db->join("jadwal as b", "a.id_jadwal = b.id_jadwal");
            $this->db->join("kelas as c", "a.id_kelas = c.id_kelas");
            $this->db->where("concat(MONTH(tgl), ' ', YEAR(tgl)) = ", $periode);
            $this->db->where("a.nip", $nip);
            $this->db->group_by(array("a.id_jadwal", "concat(MONTH(tgl), ' ', YEAR(tgl))"));
            return $this->db->get()->result_array();
        }
        
        public function get_bulan($tahun){
            $this->db->select("MONTH(tgl) as bulan");
            $this->db->from("kbm");
            $this->db->where("tgl >= ", "2020-05-01");
            $this->db->where("MONTH(tgl) <>", "0");
            $this->db->where("YEAR(tgl) =", $tahun);
            $this->db->group_by("bulan");
            $this->db->order_by("bulan", "DESC");
            return $this->db->get()->result_array();
        }
        
        public function get_kbm_badal_by_periode($bulan, $tahun, $nip){
            $this->db->select("a.id_kbm, peserta, tgl, a.hari, a.jam, biaya, a.ot, nama_kpq, program_kbm, tipe_kelas, e.ot as oot");
            $this->db->from("kbm as a");
            $this->db->join("kbm_badal as b", "a.id_kbm = b.id_kbm");
            $this->db->join("kpq as c", "a.nip = c.nip");
            $this->db->join("kelas as d", "a.id_kelas = d.id_kelas");
            $this->db->join("jadwal as e", "a.id_jadwal = e.id_jadwal");
            $this->db->where("MONTH(tgl)", $bulan);
            $this->db->where("YEAR(tgl)", $tahun);
            $this->db->where("nip_badal", $nip);
            return $this->db->get()->result_array();
        }
        
        public function get_all_peserta_by_periode_by_id_kelas($bulan, $tahun, $id_kelas){
            $periode = $bulan . " " . $tahun;
            $this->db->select("b.id_peserta, c.nama_peserta, max(b.hadir) as hadir, no_hp");
            $this->db->from("kbm as a");
            $this->db->join("presensi_peserta as b", "a.id_kbm = b.id_kbm");
            $this->db->join("peserta as c", "b.id_peserta = c.id_peserta");
            $this->db->where("concat(month(tgl),' ',year(tgl)) = ", $periode);
            $this->db->where("a.id_kelas", $id_kelas);
            $this->db->group_by(array("concat(month(`a`.`tgl`),' ',year(`a`.`tgl`))" ,"`b`.`id_peserta`"));
            return $this->db->get()->result_array();
        }

        public function get_tgl_kbm_by_periode_by_id_jadwal($bulan, $tahun, $nip, $id_jadwal){
            $this->db->select("tgl, id_kbm, biaya, ot, keterangan");
            $this->db->from("kbm");
            $this->db->where("id_jadwal", $id_jadwal);
            $this->db->where("MONTH(tgl)", $bulan);
            $this->db->where("YEAR(tgl)", $tahun);
            $this->db->where("nip", $nip);
            return $this->db->get()->result_array();
        }
        
        public function dataKelasPrivat($id_kelas){
            $query = "a.id_kelas, a.status, a.program, nama_peserta, nama_kpq, pengajar, tipe_kelas";
            $this->db->select($query);
            $this->db->from("kelas as a");
            $this->db->join("kelas_koor as b", "a.id_kelas=b.id_kelas");
            $this->db->join("peserta as c", "b.id_peserta=c.id_peserta");
            $this->db->join("kpq as d", "d.nip=a.nip");
            $this->db->where("a.id_kelas", $id_kelas);
            return $this->db->get()->row_array();
        }
        
        public function dataPesertaById($id_kelas){
            $query = "nama_peserta";
            $this->db->select($query);
            $this->db->from("peserta");
            $this->db->where("id_kelas", $id_kelas);
            $this->db->where("status", "aktif");
            return $this->db->get()->result_array();
        }
        
        public function dataJadwalById($id_kelas){
            $query = "tempat, hari, jam, ot";
            $this->db->select($query);
            $this->db->from("jadwal");
            $this->db->where("id_kelas", $id_kelas);
            $this->db->where("status", 'aktif');
            return $this->db->get()->result_array();
        }
         
        public function get_tagihan_kelas($id_kelas){
            $this->db->select("*, a.status AS stat");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_kelas as b", "a.id_tagihan=b.id_tagihan");
            $this->db->join("kelas as d", "d.id_kelas = b.id_kelas");
            $this->db->where("d.id_kelas", $id_kelas);
            return $this->db->get()->result_array();
        }

        public function get_deposit_kelas($id_kelas){
            $this->db->from("deposit as a");
            $this->db->join("deposit_kelas as b", "a.id_deposit=b.id_deposit");
            $this->db->join("kelas as d", "d.id_kelas = b.id_kelas");
            $this->db->where("d.id_kelas", $id_kelas);
            return $this->db->get()->result_array();
        }
        
        public function get_pembayaran_kelas_cash($id_kelas){
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_kelas as b", "a.id_pembayaran=b.id_pembayaran");
            $this->db->join("kelas as d", "d.id_kelas = b.id_kelas");
            $this->db->where("d.id_kelas", $id_kelas);
            $this->db->where("metode !=", "Deposit");
            return $this->db->get()->result_array();
        }
        
        public function get_pembayaran_kelas_transfer($id_kelas){
            $this->db->from("transfer as a");
            $this->db->join("transfer_kelas as b", "a.id_transfer=b.id_transfer");
            $this->db->join("kelas as d", "d.id_kelas = b.id_kelas");
            $this->db->where("d.id_kelas", $id_kelas);
            $this->db->where("metode !=", "Deposit");
            return $this->db->get()->result_array();
        }
        
        public function get_invoice_kelas($id){
            $this->db->from("invoice as a");
            $this->db->join("invoice_kelas as b", "a.id_invoice = b.id_invoice", "left");
            $this->db->where("b.id_kelas", $id);
            $this->db->order_by("tgl_invoice", "desc");
            return $this->db->get()->result_array();
        }
        
        public function get_data_kbm($id){
            $kbm = [];

            $this->db->select("YEAR(tgl) as tahun");
            $this->db->from("kbm");
            $this->db->where("id_kelas", $id);
            $this->db->where("tgl !=", "0000-00-00");
            $this->db->group_by("tahun");
            $tahun = $this->db->get()->result_array();
            $i = 0;

            foreach ($tahun as $tahun) {
                $this->db->select("MONTH(tgl) as bulan");
                $this->db->from("kbm");
                $this->db->where("YEAR(tgl)", $tahun['tahun']);
                $this->db->where("id_kelas", $id);
                $this->db->group_by("bulan");
                $bulan = $this->db->get()->result_array();
                $j = 0;
                foreach ($bulan as $bulan) {
                    $kbm['kbm'][$i]['tahun'] = $tahun['tahun'];
                    $kbm['kbm'][$i]['bulan'] = $bulan['bulan'];
                    // $kbm[$i]['bulan'][$j] = $bulan['bulan'];
                    $this->db->select("COUNT(id_kbm) AS kbm");
                    $this->db->from("kbm");
                    $this->db->where("MONTH(tgl)", $bulan['bulan']);
                    $this->db->where("YEAR(tgl)", $tahun['tahun']);
                    $this->db->where("id_kelas", $id);
                    $total = $this->db->get()->row_array();
                    $kbm['kbm'][$i]['kbm'] = $total['kbm'];
                    // var_dump($bulan);
                    // $j++;
                    $i++;
                }
            }
            // ini_set("xdebug.var_display_max_children", -1);
            // ini_set("xdebug.var_display_max_data", -1);
            // ini_set("xdebug.var_display_max_depth", -1);

            // var_dump($kbm);
            return $kbm;
        }
        
        public function getDataKpq($nip){
            $this->db->from("kpq");
            $this->db->where("nip", $nip);
            return $this->db->get()->row_array();
        }
        
        public function get_tagihan_kpq($nip){
            $this->db->select("*, a.status AS stat");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_kpq as b", "a.id_tagihan=b.id_tagihan");
            $this->db->join("kpq as d", "d.nip = b.nip");
            $this->db->where("d.nip", $nip);
            return $this->db->get()->result_array();
        }
        
        public function get_deposit_kpq($nip){
            $this->db->from("deposit as a");
            $this->db->join("deposit_kpq as b", "a.id_deposit=b.id_deposit");
            $this->db->join("kpq as d", "d.nip = b.nip");
            $this->db->where("d.nip", $nip);
            return $this->db->get()->result_array();
        }
        
        public function get_pembayaran_kpq_cash($nip){
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_kpq as b", "a.id_pembayaran=b.id_pembayaran");
            $this->db->join("kpq as d", "d.nip = b.nip");
            $this->db->where("d.nip", $nip);
            $this->db->where("metode !=", "Deposit");
            return $this->db->get()->result_array();
        }
        
        public function get_pembayaran_kpq_transfer($nip){
            $this->db->from("transfer as a");
            $this->db->join("transfer_kpq as b", "a.id_transfer=b.id_transfer");
            $this->db->join("kpq as d", "d.nip = b.nip");
            $this->db->where("d.nip", $nip);
            $this->db->where("metode !=", "Deposit");
            return $this->db->get()->result_array();
        }
        
        public function get_invoice_kpq($id){
            $this->db->from("invoice as a");
            $this->db->join("invoice_kpq as b", "a.id_invoice = b.id_invoice", "left");
            $this->db->where("b.nip", $id);
            $this->db->order_by("tgl_invoice", "desc");
            return $this->db->get()->result_array();
        }
        
        public function get_tagihan_peserta($id_peserta){
            $this->db->select("*, a.status AS stat");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_peserta as b", "a.id_tagihan=b.id_tagihan");
            $this->db->join("peserta as d", "d.id_peserta = b.id_peserta");
            $this->db->where("d.id_peserta", $id_peserta);
            return $this->db->get()->result_array();
        }
        
        public function get_deposit_peserta($id_peserta){
            $this->db->from("deposit as a");
            $this->db->join("deposit_peserta as b", "a.id_deposit=b.id_deposit");
            $this->db->join("peserta as d", "d.id_peserta = b.id_peserta");
            $this->db->where("d.id_peserta", $id_peserta);
            return $this->db->get()->result_array();
        }
        
        public function get_pembayaran_peserta_cash($id_peserta){
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_peserta as b", "a.id_pembayaran=b.id_pembayaran");
            $this->db->join("peserta as d", "d.id_peserta = b.id_peserta");
            $this->db->where("d.id_peserta", $id_peserta);
            $this->db->where("metode !=", "Deposit");
            return $this->db->get()->result_array();
        }
                
        public function get_pembayaran_peserta_transfer($id_peserta){
            $this->db->from("transfer as a");
            $this->db->join("transfer_peserta as b", "a.id_transfer=b.id_transfer");
            $this->db->join("peserta as d", "d.id_peserta = b.id_peserta");
            $this->db->where("d.id_peserta", $id_peserta);
            $this->db->where("metode !=", "Deposit");
            return $this->db->get()->result_array();
        }
        
        public function get_invoice_peserta($id){
            $this->db->from("invoice as a");
            $this->db->join("invoice_peserta as b", "a.id_invoice = b.id_invoice", "left");
            $this->db->where("b.id_peserta", $id);
            $this->db->order_by("tgl_invoice", "desc");
            return $this->db->get()->result_array();
        }
        
        public function getDataPeserta($id_peserta){
            $this->db->select("a.id_peserta, a.status, tipe_peserta, b.program, nama_kpq, c.tempat, c.hari, c.jam, nama_peserta");
            $this->db->from("peserta as a");
            $this->db->join("kelas as b", "a.id_kelas = b.id_kelas", 'left');
            $this->db->join("jadwal as c", "b.id_kelas = c.id_kelas", 'left');
            $this->db->join("kpq as d", "b.nip = d.nip", 'left');
            $this->db->where("a.id_peserta", $id_peserta);
            return $this->db->get()->row_array();
        }
        
        public function get_data_pembayaran($id){
            $this->db->from("pembayaran");
            $this->db->where("id_pembayaran", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_data_pembayaran_transfer($id){
            $this->db->from("transfer");
            $this->db->where("id_transfer", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_data_invoice($id){
            $this->db->from("invoice");
            $this->db->where("id_invoice", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_data_uraian_invoice($id){
            $this->db->from("invoice_uraian");
            $this->db->where("id_invoice", $id);
            return $this->db->get()->result_array();
        }
        
        public function get_data_pembayaran_deposit($id){
            $this->db->from("tagihan");
            $this->db->where("id_tagihan", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_data_deposit($id){
            $this->db->from("deposit");
            $this->db->where("id_deposit", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_piutang_peserta_by_id($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_peserta as b", "a.id_tagihan = b.id_tagihan");
            $this->db->where("id_peserta", $id);
            $tagihan = $this->db->get()->row_array();
            
            $this->db->select("sum(nominal) as total");
            $this->db->from("deposit as a");
            $this->db->join("deposit_peserta as b", "a.id_deposit = b.id_deposit");
            $this->db->where("id_peserta", $id);
            $deposit = $this->db->get()->row_array();
            
            $this->db->select("sum(nominal) as total");
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_peserta as b", "a.id_pembayaran = b.id_pembayaran");
            $this->db->where("id_peserta", $id);
            $pembayaran = $this->db->get()->row_array();
            
            $this->db->select("sum(nominal) as total");
            $this->db->from("transfer as a");
            $this->db->join("transfer_peserta as b", "a.id_transfer = b.id_transfer");
            $this->db->where("id_peserta", $id);
            $transfer = $this->db->get()->row_array();

            return $pembayaran['total'] + $transfer['total'] - $tagihan['total'] - $deposit['total'];
        }

        public function get_total_tagihan_peserta($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_peserta as b", "a.id_tagihan = b.id_tagihan");
            $this->db->where("id_peserta", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_deposit_peserta($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("deposit as a");
            $this->db->join("deposit_peserta as b", "a.id_deposit = b.id_deposit");
            $this->db->where("id_peserta", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_cash_peserta($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_peserta as b", "a.id_pembayaran = b.id_pembayaran");
            $this->db->where("id_peserta", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_transfer_peserta($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("transfer as a");
            $this->db->join("transfer_peserta as b", "a.id_transfer = b.id_transfer");
            $this->db->where("id_peserta", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_tagihan_kelas($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_kelas as b", "a.id_tagihan = b.id_tagihan");
            $this->db->where("id_kelas", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_deposit_kelas($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("deposit as a");
            $this->db->join("deposit_kelas as b", "a.id_deposit = b.id_deposit");
            $this->db->where("id_kelas", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_cash_kelas($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_kelas as b", "a.id_pembayaran = b.id_pembayaran");
            $this->db->where("id_kelas", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_transfer_kelas($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("transfer as a");
            $this->db->join("transfer_kelas as b", "a.id_transfer = b.id_transfer");
            $this->db->where("id_kelas", $id);
            return $this->db->get()->row_array();
        }

        public function get_total_tagihan_kpq($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_kpq as b", "a.id_tagihan = b.id_tagihan");
            $this->db->where("nip", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_deposit_kpq($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("deposit as a");
            $this->db->join("deposit_kpq as b", "a.id_deposit = b.id_deposit");
            $this->db->where("nip", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_cash_kpq($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("pembayaran as a");
            $this->db->join("pembayaran_kpq as b", "a.id_pembayaran = b.id_pembayaran");
            $this->db->where("nip", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_total_transfer_kpq($id){
            $this->db->select("sum(nominal) as total");
            $this->db->from("transfer as a");
            $this->db->join("transfer_kpq as b", "a.id_transfer = b.id_transfer");
            $this->db->where("nip", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_jadwal_aktif_by_id_kelas($id_kelas){
            $this->db->from("jadwal");
            $this->db->where("status", "aktif");
            $this->db->where("id_kelas", $id_kelas);
            return $this->db->get()->result_array();
        }
        
        public function getInfaqByKet($ket){
            $this->db->select("infaq");
            $this->db->from("infaq");
            $this->db->where("tipe_kelas", $ket);
            return $this->db->get()->row_array();
        }
        
        public function get_tanggal_between_transfer(){

            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");

            $this->db->select("tgl_transfer");
            $this->db->from("transfer");
            $where = "tgl_transfer between '$tgl_awal' AND '$tgl_akhir'";
            $this->db->where($where);
            $this->db->group_by("tgl_transfer");
            return $this->db->get()->result_array();
        }
        
        public function get_transaksi_tanggal_transfer($tgl){
            $this->db->from("transfer");
            $this->db->where("tgl_transfer", $tgl);
            return $this->db->get()->result_array();
        }
        
        public function get_tanggal_between_deposit(){

            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");

            $this->db->select("tgl_deposit");
            $this->db->from("deposit");
            $where = "tgl_deposit between '$tgl_awal' AND '$tgl_akhir'";
            $this->db->where($where);
            $this->db->group_by("tgl_deposit");
            return $this->db->get()->result_array();
        }
        
        public function get_tanggal_between_invoice(){
            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");

            $this->db->from("invoice");
            $where = "tgl_invoice between '$tgl_awal' AND '$tgl_akhir'";
            $this->db->where($where);
            $this->db->group_by("id_invoice");
            return $this->db->get()->result_array();
        }

        public function get_invoice_by_id($id){
            $this->db->from("invoice as a");
            $this->db->where("a.id_invoice", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_invoice_uraian($id){
            $this->db->from("invoice_uraian");
            $this->db->where("id_invoice", $id);
            return $this->db->get()->result_array();
        }
        
        public function get_transaksi_tanggal_deposit($tgl){
            $this->db->from("deposit");
            $this->db->where("tgl_deposit", $tgl);
            return $this->db->get()->result_array();
        }
    // get by
    
    // get all
        public function get_tahun(){
            $this->db->select("YEAR(tgl) as tahun");
            $this->db->from("kbm");
            $this->db->where("tgl >= ", "2020-05-01");
            $this->db->where("YEAR(tgl) <>", "0");
            $this->db->group_by("tahun");
            $this->db->order_by("tahun", "DESC");
            return $this->db->get()->result_array();
        }

        public function get_all_nip(){
            $this->db->select("nip, nama_kpq, golongan");
            $this->db->from("kpq");
            $this->db->order_by("nama_kpq");
            return $this->db->get()->result_array();
        }
        
        public function get_peserta_reguler(){
            $this->db->from("peserta_reguler");
            $this->db->order_by("nama_peserta", "ASC");
            return $this->db->get()->result_array();
        }
        
        public function get_kelas_pv_khusus(){
            $this->db->from("kelas_pv_khusus");
            $this->db->order_by("nama_peserta", "ASC");
            return $this->db->get()->result_array();
        }
        
        public function get_kelas_pv_luar(){
            $this->db->from("kelas_pv_luar");
            $this->db->order_by("nama_peserta", "ASC");
            return $this->db->get()->result_array();
        }
        
        public function get_all_civitas(){
            $this->db->from("kpq");
            $this->db->where("status !=", 'hapus');
            $this->db->order_by("nama_kpq");
            return $this->db->get()->result_array();
        }
        
        public function getAllKelasPvAktif(){
            $this->db->select("a.id_kelas, nama_peserta, ket");
            $this->db->from("kelas as a");
            $this->db->join("kelas_koor as b", "a.id_kelas = b.id_kelas");
            $this->db->join("peserta as c", "c.id_peserta = b.id_peserta");
            $this->db->where("tipe_kelas !=", 'reguler');
            $this->db->where("a.status", 'aktif');
            return $this->db->get()->result_array();
        }
        
        public function getAllPesertaRegulerAktif(){
            $this->db->select("id_peserta, nama_peserta");
            $this->db->from("peserta");
            $this->db->where("status", "aktif");
            $this->db->where("tipe_peserta", "reguler");
            return $this->db->get()->result_array();
        }
        
        public function get_all_tagihan_reguler(){
            $this->db->from("piutang_reguler");
            $this->db->order_by("tgl_tagihan", "asc");
            return $this->db->get()->result_array();
        }
        
        public function get_all_tagihan_pv_khusus(){
            $this->db->from("piutang_pv_khusus as a");
            $this->db->join("kelas as b", "a.id_kelas = b.id_kelas");
            $this->db->order_by("tgl_tagihan", "asc");
            return $this->db->get()->result_array();
        }
        
        public function get_all_tagihan_pv_luar(){
            $this->db->from("piutang_pv_luar as a");
            $this->db->join("kelas as b", "a.id_kelas = b.id_kelas");
            $this->db->order_by("tgl_tagihan", "asc");
            return $this->db->get()->result_array();
        }
    // get all

    // edit data
        public function edit_tagihan(){
            $data = [
                "nama_tagihan" => $this->input->post("nama", TRUE),
                "tgl_tagihan" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->input->post("nominal")
            ];

            $this->db->where("id_tagihan", $this->input->post("id"));
            $this->db->update("tagihan", $data);
        }
        
        public function edit_pembayaran_cash(){
            $data = [
                "nama_pembayaran" => $this->input->post("nama", TRUE),
                "tgl_pembayaran" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->input->post("nominal")
            ];

            $this->db->where("id_pembayaran", $this->input->post("id"));
            $this->db->update("pembayaran", $data);
        }
        
        public function edit_pembayaran_transfer(){
            $data = [
                "nama_transfer" => $this->input->post("nama", TRUE),
                "tgl_transfer" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->input->post("nominal"),
                "alamat" => $this->input->post("alamat")
            ];

            $this->db->where("id_transfer", $this->input->post("id"));
            $this->db->update("transfer", $data);
        }
        
        public function edit_deposit(){
            $data = [
                "nama_deposit" => $this->input->post("nama", TRUE),
                "tgl_deposit" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->input->post("nominal")
            ];

            $this->db->where("id_deposit", $this->input->post("id"));
            $this->db->update("deposit", $data);
        }
    // edit data

    // get last
        public function idTagihanTerakhir(){
            $this->db->from("tagihan");
            $this->db->order_by("id_tagihan", "desc");
            return $this->db->get()->row_array();
        }
        
        public function getLastIdTagihan(){
            $this->db->select("id_tagihan");
            $this->db->from("tagihan");
            $this->db->order_by("id_tagihan", "DESC");
            return $this->db->get()->row_array();
        }
    // get last

    // add
        public function tambahPiutang($id){
            $nominal = $this->input->post('nominal', true);
            $nominal = str_replace("Rp. ", "", $nominal);
            $nominal = str_replace(".", "", $nominal);

            $data["tagihan"] = [
                "id_tagihan" => $id, 
                "tgl_tagihan" => $this->input->post("tgl", TRUE),
                "nama_tagihan" => $this->input->post("nama", TRUE),
                "uraian" => $this->input->post("uraian", TRUE),
                "nominal" => $nominal,
                "status" => "piutang",
                "ket" => $this->input->post("ket", TRUE)
            ];

            $this->db->insert("tagihan", $data["tagihan"]);

            $tipe = $this->input->post("tipe");

            $this->jenis_tagihan($id, $tipe);
        }
        
        public function add_pembayaran(){
            $nominal = $this->input->post('nominal', true);
            $nominal = str_replace("Rp. ", "", $nominal);
            $nominal = str_replace(".", "", $nominal);

            $bulan = date("m", strtotime($this->input->post("tgl")));
            $tahun = date("Y", strtotime($this->input->post("tgl")));

            $this->db->select("substr(id_transfer, 1, 3) as id");
            $this->db->from("transfer");
            $this->db->where("MONTH(tgl_transfer)", $bulan);
            $this->db->where("YEAR(tgl_transfer)", $tahun);
            $this->db->order_by("id", "DESC");
            $id = $this->db->get()->row_array();

            if($id){
                $id = $id['id'] + 1;
            } else {
                $id = 1;
            }

            if($id >= 1 && $id < 10){
                $id = "00".$id.date('my', strtotime($this->input->post("tgl")));
            } else if($id >= 10 && $id < 100){
                $id = "0".$id.date('my', strtotime($this->input->post("tgl")));
            } else if($id >= 100 && $id < 1000){
                $id = $id.date('my', strtotime($this->input->post("tgl")));
            }

            $data['transfer'] = [
                "id_transfer" => $id,
                "tgl_transfer" => $this->input->post("tgl"),
                "nama_transfer" => $this->input->post("nama"),
                "pengajar" => $this->input->post("pengajar"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $nominal,
                "keterangan" => $this->input->post("keterangan"),
                "metode" => $this->input->post("metode"),
                "alamat" => $this->input->post("alamat")
            ];

            $this->db->insert("transfer", $data['transfer']);

            $tipe = $this->input->post('tipe');
            if($tipe == 'kelas'){
                
                $data = [
                    "id_transfer" => $id,
                    "id_kelas" => $this->input->post('id')
                ];

                $this->db->insert("transfer_kelas", $data);

            } else if($tipe == 'peserta'){
                
                $data = [
                    "id_transfer" => $id,
                    "id_peserta" => $this->input->post('id')
                ];

                $this->db->insert("transfer_peserta", $data);

            } else if($tipe == 'kpq'){
                
                $data = [
                    "id_transfer" => $id,
                    "nip" => $this->input->post('id')
                ];

                $this->db->insert("transfer_kpq", $data);
            }
        }

        public function tambah_invoice(){
            $bulan = date("m", strtotime($this->input->post("tgl")));
            $tahun = date("Y", strtotime($this->input->post("tgl")));
    
            $this->db->select("substr(id_invoice, 1, 3) as id");
            $this->db->from("invoice");
            $this->db->where("MONTH(tgl_invoice)", $bulan);
            $this->db->where("YEAR(tgl_invoice)", $tahun);
            $this->db->order_by("id", "DESC");
            $id = $this->db->get()->row_array();
    
            if($id){
                $id = $id['id'] + 1;
            } else {
                $id = 1;
            }
    
            if($id >= 1 && $id < 10){
                $id = "00".$id.date('my', strtotime($this->input->post("tgl")));
            } else if($id >= 10 && $id < 100){
                $id = "0".$id.date('my', strtotime($this->input->post("tgl")));
            } else if($id >= 100 && $id < 1000){
                $id = $id.date('my', strtotime($this->input->post("tgl")));
            }
    
            $data['invoice'] = [
                "id_invoice" => $id,
                "tgl_invoice" => $this->input->post("tgl"),
                "nama_invoice" => $this->input->post("nama")
            ];
    
            $this->db->insert("invoice", $data['invoice']);
    
            foreach ($_POST['uraian'] as $i => $detail) {
                $data['uraian'] = [
                    "uraian" => $_POST['uraian'][$i],
                    "satuan" => $_POST['satuan'][$i],
                    "nominal" => $_POST['nominal'][$i],
                    "id_invoice" => $id
                ];
                
                $this->db->insert("invoice_uraian", $data['uraian']);
            }
    
            $tipe = $this->input->post('tipe');
            if($tipe == 'kelas'){
                
                $data = [
                    "id_invoice" => $id,
                    "id_kelas" => $this->input->post('id')
                ];
    
                $this->db->insert("invoice_kelas", $data);
    
            } else if($tipe == 'peserta'){
                
                $data = [
                    "id_invoice" => $id,
                    "id_peserta" => $this->input->post('id')
                ];
    
                $this->db->insert("invoice_peserta", $data);
    
            } else if($tipe == 'kpq'){
                
                $data = [
                    "id_invoice" => $id,
                    "nip" => $this->input->post('id')
                ];
    
                $this->db->insert("invoice_kpq", $data);
            }
        }
        
        public function add_uraian(){
            $data = [
                "uraian" => $this->input->post("uraian"),
                "satuan" => $this->ganti_nominal($this->input->post("satuan")),
                "nominal" => $this->ganti_nominal($this->input->post("nominal")),
                "id_invoice" => $this->input->post("id")
            ];
            // var_dump($data);
            // exit();
            
            $this->db->insert("invoice_uraian", $data);
        }
        
        public function insert_tagihan($data){
            $this->db->insert("tagihan", $data);
        }
        
        public function insert_tagihan_kelas($data){
            $this->db->insert("tagihan_kelas", $data);
        }

        public function insert_tagihan_peserta($data){
            $this->db->insert("tagihan_peserta", $data);
        }
        
        public function add_pembayaran_by_deposit(){
            // get id deposit terakhir
            $this->db->from("deposit");
            $this->db->order_by("id_deposit", "DESC");
            $id = $this->db->get()->row_array();
            $id = $id['id_deposit'] + 1;

            $data = [
                "id_deposit" => $id,
                "tgl_deposit" => $this->input->post("tgl"),
                "nama_deposit" => $this->input->post("nama"),
                "pengajar" => $this->input->post("pengajar"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->ganti_nominal($this->input->post("nominal")),
                "keterangan" => $this->input->post("keterangan"),
                "metode" => $this->input->post("metode")
            ]; 
            
            $this->db->insert("deposit", $data);

            
            $tipe = $this->input->post('tipe');
            if($tipe == 'kelas'){
                
                $data = [
                    "id_deposit" => $id,
                    "id_kelas" => $this->input->post('id')
                ];

                $this->db->insert("deposit_kelas", $data);

            } else if($tipe == 'peserta'){
                
                $data = [
                    "id_deposit" => $id,
                    "id_peserta" => $this->input->post('id')
                ];

                $this->db->insert("deposit_peserta", $data);

            } else if($tipe == 'kpq'){
                
                $data = [
                    "id_deposit" => $id,
                    "nip" => $this->input->post('id')
                ];

                $this->db->insert("deposit_kpq", $data);
            }
        }
        
        // cekk lagi
        public function cek_add_pembayaran($id_tagihan, $nama, $tipe, $id){
            // id terakhir
            $metode = $this->input->post("metode");
            if($metode != 'Deposit'){
                $this->add_piutang($id_tagihan, $nama, $tipe, $id);
                $this->bayar_piutang($id_tagihan);
            }

            $nominal = $this->input->post('nominal', true);
            $nominal = str_replace("Rp. ", "", $nominal);
            $nominal = str_replace(".", "", $nominal);

            $bulan = date("m", strtotime($this->input->post("tgl")));
            $tahun = date("Y", strtotime($this->input->post("tgl")));

            $this->db->select("substr(id_transfer, 1, 3) as id");
            $this->db->from("transfer");
            $this->db->where("MONTH(tgl_transfer)", $bulan);
            $this->db->where("YEAR(tgl_transfer)", $tahun);
            $this->db->order_by("id", "DESC");
            $id = $this->db->get()->row_array();

            if($id){
                $id = $id['id'] + 1;
            } else {
                $id = 1;
            }

            if($id >= 1 && $id < 10){
                $id = "00".$id.date('my', strtotime($this->input->post("tgl")));
            } else if($id >= 10 && $id < 100){
                $id = "0".$id.date('my', strtotime($this->input->post("tgl")));
            } else if($id >= 100 && $id < 1000){
                $id = $id.date('my', strtotime($this->input->post("tgl")));
            }

            $data['transfer'] = [
                "id_transfer" => $id,
                "tgl_transfer" => $this->input->post("tgl"),
                "nama_transfer" => $this->input->post("nama"),
                "pengajar" => $this->input->post("pengajar"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $nominal,
                "keterangan" => $this->input->post("keterangan"),
                "metode" => $this->input->post("metode"),
                "alamat" => $this->input->post("alamat")
            ];

            $this->db->insert("transfer", $data['transfer']);

            $tipe = $this->input->post('tipe');
            if($tipe == 'kelas'){
                
                $data = [
                    "id_transfer" => $id,
                    "id_kelas" => $this->input->post('id')
                ];

                $this->db->insert("transfer_kelas", $data);

            } else if($tipe == 'peserta'){
                
                $data = [
                    "id_transfer" => $id,
                    "id_peserta" => $this->input->post('id')
                ];

                $this->db->insert("transfer_peserta", $data);

            } else if($tipe == 'kpq'){
                
                $data = [
                    "id_transfer" => $id,
                    "nip" => $this->input->post('id')
                ];

                $this->db->insert("transfer_kpq", $data);
            }
        }
        
        public function add_piutang($id_tagihan, $nama, $tipe, $id){
            $nominal = $this->input->post('nominal', true);
            $nominal = str_replace("Rp. ", "", $nominal);
            $nominal = str_replace(".", "", $nominal);

            $data['tagihan'] = [
                "id_tagihan" => $id_tagihan,
                "tgl_tagihan" => $this->input->post("tgl"),
                "nama_tagihan" => $nama,
                "uraian" => $this->input->post('uraian', TRUE),
                "nominal" => $nominal,
                "status" => "piutang"
            ];

            $this->db->insert('tagihan', $data['tagihan']);

            $this->jenis_tagihan($id_tagihan, $tipe);
        }

        public function jenis_tagihan($id, $tipe){
            if($tipe == "peserta"){
                $piutang = [
                    "id_tagihan" => $id,
                    "id_peserta" => $this->input->post("id", TRUE)
                ];
    
                $this->db->insert("tagihan_peserta", $piutang);
            } else  if($tipe == "kelas"){
                $piutang = [
                    "id_tagihan" => $id,
                    "id_kelas" => $this->input->post("id", TRUE)
                ];
    
                $this->db->insert("tagihan_kelas", $piutang);
            } else if($tipe == "kpq"){
                $piutang = [
                    "id_tagihan" => $id,
                    "nip" => $this->input->post("id", TRUE)
                ];
    
                $this->db->insert("tagihan_kpq", $piutang);
            }
        }
    // add

    // edit
        public function edit_transaksi(){
            $id = $this->input->post("id");
            $transaksi = $this->input->post("transaksi");

            if($transaksi == "tagihan"){
                
                $data = [
                    "nama_tagihan" => $this->input->post("nama"),
                    "tgl_tagihan" => $this->input->post("tgl"),
                    "uraian" => $this->input->post("uraian"),
                    "nominal" => $this->input->post("nominal")
                ];

                $this->db->where("id_tagihan", $id);
                $this->db->update("tagihan", $data);

            } else if($transaksi == "pembayaran"){
                
                $data = [
                    "nama_pembayaran" => $this->input->post("nama"),
                    "tgl_pembayaran" => $this->input->post("tgl"),
                    "uraian" => $this->input->post("uraian"),
                    "nominal" => $this->input->post("nominal")
                ];

                $this->db->where("id_pembayaran", $id);
                $this->db->update("pembayaran", $data);

            } else if($transaksi == "invoice"){
                
                $data = [
                    "nama_invoice" => $this->input->post("nama"),
                    "tgl_invoice" => $this->input->post("tgl"),
                    "uraian" => $this->input->post("uraian"),
                    "nominal" => $this->input->post("nominal")
                ];

                $this->db->where("id_invoice", $id);
                $this->db->update("invoice", $data);

            }
        }
        
        public function edit_invoice(){
            $id = $this->input->post("id");

            $data = [
                "nama_invoice" => $this->input->post("nama"),
                "tgl_invoice" => $this->input->post("tgl")
            ];

            $this->db->where("id_invoice", $id);
            $this->db->update("invoice", $data);
        }
        
        public function edit_uraian(){
            foreach ($_POST['uraian'] as $i => $uraian) {
                $data = [
                    "uraian" => $_POST['uraian'][$i],
                    "satuan" => $_POST['satuan'][$i],
                    "nominal" => $_POST['nominal'][$i]
                ];
                
                $this->db->where("id_uraian", $_POST['id_uraian'][$i]);
                $this->db->update("invoice_uraian", $data);
            }
        }
        
        public function edit_pj($id, $data){
            $this->db->where("id_kelas", $id);
            $this->db->update("kelas", $data);
        }
        
        public function edit_status_tagihan(){
            $id = $this->input->post("id");
            $status = $this->input->post("status");
            $this->db->where("id_tagihan", $id);
            $this->db->update("tagihan", ["status" => $status]);
        }
        
        public function bayar_piutang($id){
            $data = [
                "status" => "lunas"
            ];
    
            $this->db->where("id_tagihan", $id);
            $this->db->update("tagihan", $data);
        }
    // edit

    // delete
        public function delete_uraian(){
            foreach ($_POST['uraian'] as $id) {
                $this->db->where("id_uraian", $id);
                $this->db->delete("invoice_uraian");
            }
        }
    // delete

    // other function
        public function ganti_nominal($nominal){
            // $nominal = $this->input->post('nominal', true);
            $angka = str_replace("Rp. ", "", $nominal);
            $angka = str_replace(".", "", $angka);
            return $angka;
        }

        public function start_transaction(){
            $this->db->trans_start();
            $this->db->trans_strict(FALSE);
        }
        
        public function end_transaction(){
            $this->db->trans_commit();
        }
    // other function

    // get data tidak jelas
        public function get_data_tagihan(){
            $id = $this->input->post("id");
            $this->db->from("tagihan");
            $this->db->where("id_tagihan", $id);
            return $this->db->get()->row_array();
        }
        
        public function get_data_tagihan_kelas(){
            $id = $this->input->post("id");
            $this->db->from("tagihan as a");
            $this->db->join("tagihan_kelas as b", "a.id_tagihan = b.id_tagihan", "left");
            $this->db->where("a.id_tagihan", $id);
            return $this->db->get()->row_array();
        }
}
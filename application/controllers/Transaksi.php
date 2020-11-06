<?php
class Transaksi extends CI_CONTROLLER{
    public function __construct(){
        parent::__construct();
        // $this->load->model("Keuangan_model");
        $this->load->model("Keuangan_model");
        $this->load->model("Main_model");
        if($this->session->userdata('status') != "login"){
            $this->session->set_flashdata('login', 'Maaf, Anda harus login terlebih dahulu');
			redirect(base_url("login"));
        }
    }

    public function cetak_laporan(){
        $tgl_awal = $this->input->post("tgl_awal");
        $tgl_akhir = $this->input->post("tgl_akhir");
        $tipe = $this->input->post("metode");

        if($tipe == "transfer"){
            
            $name = "Transfer " . date("d/m/y", strtotime($tgl_awal)) ." - ". date("d/m/y", strtotime($tgl_akhir));
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$name.'.xls"');

            $tgl = $this->Keuangan_model->get_tanggal_between_transfer();
    
            $data['data'] = [];
            foreach ($tgl as $i => $tgl) {
                $data['data'][$i]['tgl'] = $tgl['tgl_transfer'];
                $data['data'][$i]['transaksi'] = $this->Keuangan_model->get_transaksi_tanggal_transfer($tgl['tgl_transfer']);
            }
            $this->load->view("transaksi/excel_transfer", $data);
        } else if($tipe == "deposit"){
            
            $name = "Deposit " . date("d/m/y", strtotime($tgl_awal)) ." - ". date("d/m/y", strtotime($tgl_akhir));
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$name.'.xls"');

            $tgl = $this->Keuangan_model->get_tanggal_between_deposit();
    
            $data['data'] = [];
            foreach ($tgl as $i => $tgl) {
                $data['data'][$i]['tgl'] = $tgl['tgl_deposit'];
                $data['data'][$i]['transaksi'] = $this->Keuangan_model->get_transaksi_tanggal_deposit($tgl['tgl_deposit']);
            }
            
            $this->load->view("transaksi/excel_deposit", $data);
        } 
        
        // else if($tipe == "piutang reguler"){

        //     $data['title'] = "Laporan Piutang Peserta Reguler";
        //     $name = "Piutang Reguler";
        //     header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //     header('Content-Disposition: attachment;filename="'.$name.'.xls"');

        //     $data['data'] = $this->Keuangan_model->get_all_tagihan_reguler();

        //     $this->load->view("transaksi/excel_piutang", $data);
        // } 
        
        // else if($tipe == "piutang pv khusus"){
            
        //     $data['title'] = "Laporan Piutang Peserta PV Khusus";
        //     $name = "Piutang Pv Khusus";
        //     header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        //     header('Content-Disposition: attachment;filename="'.$name.'.xls"');

        //     $data['data'] = $this->Keuangan_model->get_all_tagihan_pv_khusus();

        //     $this->load->view("transaksi/excel_piutang", $data);
        // } 
        
        else if($tipe == "piutang pv luar"){
            $data['title'] = "Laporan Piutang Peserta PV Luar";
            
            $name = "Piutang Pv luar";
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$name.'.xls"');

            $data['data'] = $this->Keuangan_model->get_all_tagihan_pv_luar();

            $this->load->view("transaksi/excel_piutang", $data);
        } else if($tipe == "invoice"){
            $data['title'] = "Laporan Invoice";
            
            $name = "Invoice";
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$name.'.xls"');

            $id = $this->Keuangan_model->get_tanggal_between_invoice();
    
            // $data['data'] = ;
            foreach ($id as $i => $id) {
                $data['data'][$i] = $this->Keuangan_model->get_invoice_by_id($id['id_invoice']);
                $data['data'][$i]['uraian'] = $this->Keuangan_model->get_invoice_uraian($id['id_invoice']);
            }

            ini_set('xdebug.var_display_max_depth', '10');
            ini_set('xdebug.var_display_max_children', '256');
            ini_set('xdebug.var_display_max_data', '1024');

            // var_dump($data);
            $this->load->view("transaksi/excel_invoice", $data);
        } else if($tipe == "ppu"){
            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");
            
            $data['title'] = "Laporan Transaksi PPU " . date("d-m-y", strtotime($tgl_awal)) . " - " . date("d-m-y", strtotime($tgl_akhir));
            
            $name = "Transaksi PPU " . $tgl_awal . " - " . $tgl_akhir;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$name.'.xls"');

            $data['transaksi'] = [];
            $i = 0;
            // $cash = $this->Main_model->get_all("ppu_cash", "tgl between '$tgl_awal' AND '$tgl_akhir'");
            // foreach ($cash as $cash) {
            //     $data['transaksi'][$i] = $cash;
            //     $data['transaksi'][$i]['metode'] = "Cash";
            //     $data['transaksi'][$i]['id'] = "PPU".$cash['id'];
            //     $i++;
            // }
            $tgl = [];
            
            $transfer = $this->Main_model->get_all("ppu_transfer", "tgl between '$tgl_awal' AND '$tgl_akhir'");
            foreach ($transfer as $transfer) {
                $tgl[] = $transfer['tgl'];
                $data['transaksi'][$i] = $transfer;
                $data['transaksi'][$i]['metode'] = "Transfer";
                $data['transaksi'][$i]['id'] = substr($transfer['id'],0, 3)."/PPU-Im/".date('m', strtotime($transfer['tgl']))."/".date('Y', strtotime($transfer['tgl']));
                $i++;
            }
            
            $data['tgl'] = array_unique($tgl);
            
            usort($data['tgl'], function($a, $b) {
                return $a <=> $b;
            });

            usort($data['transaksi'], function($a, $b) {
                return $a['tgl'] <=> $b['tgl'];
            });

            $this->load->view("ppu/laporan_ppu", $data);
        }
    }

    public function edit_status_tagihan(){
        $this->Keuangan_model->edit_status_tagihan();
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function lainnya(){
        $data['title'] = "Transaksi Lain-Lain";
        $data['header'] = "Transaksi Lain-Lain";
        // $data['detail'] = $this->Transaksi_model->get_transaksi_lain();
        $cash = $this->Main_model->get_all("pembayaran", "id_pembayaran NOT IN(SELECT id_pembayaran FROM pembayaran_peserta) AND id_pembayaran NOT IN(SELECT id_pembayaran FROM pembayaran_kelas) AND id_pembayaran NOT IN(SELECT id_pembayaran FROM pembayaran_kpq)");
        $i = 1;
        $data['detail'] = [];

        foreach ($cash as $cash) {
            $data['detail'][$i] = $cash;
            $data['detail'][$i]['tgl'] = $cash['tgl_pembayaran'];
            $data['detail'][$i]['nama'] = $cash['nama_pembayaran'];
            $i++;
        }

        $transfer = $this->Main_model->get_all("transfer", "id_transfer NOT IN(SELECT id_transfer FROM transfer_peserta) AND id_transfer NOT IN(SELECT id_transfer FROM transfer_kelas) AND id_transfer NOT IN(SELECT id_transfer FROM transfer_kpq)");
        foreach ($transfer as $transfer) {
            $data['detail'][$i] = $transfer;
            $data['detail'][$i]['tgl'] = $transfer['tgl_transfer'];
            $data['detail'][$i]['nama'] = $transfer['nama_transfer'];
            $i++;
        }

        usort($data['detail'], function($a, $b) {
            // return $a['tgl'] <=> $b['tgl'];
            if($a['tgl']==$b['tgl']) return 0;
            return $a['tgl'] < $b['tgl']?1:-1;
        });

        $this->load->view("templates/header", $data);
        $this->load->view("templates/sidebar");
        $this->load->view("transaksi/transaksi-lain", $data);
        $this->load->view("templates/footer");
    }

    // add data
        public function add_transaksi_lain(){
            $metode = $this->input->post("metode");
            if($metode == "Cash"){
                // pembayaran
                    if($this->input->post("tgl") < "2020-10-01"){
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal menambahkan transaksi, tanggal yang Anda masukkan salah<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $bulan = date("m", strtotime($this->input->post("tgl")));
                        $tahun = date("Y", strtotime($this->input->post("tgl")));
                        $id = $this->Main_model->get_last_id_cash();
                        if($id){
                            $id = $id['id'] + 1;
                        } else {
                            $id = 1;
                        }
                        
                        // id cash
                            if($id >= 1 && $id < 10){
                                $id_pembayaran = date('ymd', strtotime($this->input->post("tgl")))."00".$id;
                            } else if($id >= 10 && $id < 100){
                                $id_pembayaran = date('ymd', strtotime($this->input->post("tgl")))."0".$id;
                            } else if($id >= 100 && $id < 1000){
                                $id_pembayaran = date('ymd', strtotime($this->input->post("tgl"))).$id;
                            }
                        // id cash

                        // $id_pembayaran = $id_pembayaran['id_pembayaran'] + 1;
                        
                        $data = [
                            "id_pembayaran" => $id_pembayaran,
                            "tgl_pembayaran" => $this->input->post("tgl"),
                            "nama_pembayaran" => $this->input->post("nama_pembayaran"),
                            "keterangan" => $this->input->post("keterangan"),
                            "metode" => $this->input->post("metode"),
                            "uraian" => $this->input->post("uraian"),
                            "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                            "pengajar" => "-"
                        ];
                        $this->Main_model->add_data("pembayaran", $data);
                        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menambahkan transaksi cash<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
            } else if($metode == "Transfer"){
                // transfer
                    $id = $this->Main_model->get_last_id_transfer();
                    $id = $id['id'] + 1;
                    
                    // id transfer
                        if($id >= 1 && $id < 10){
                            $id_transfer = "00".$id.date('my', strtotime($this->input->post("tgl")));
                        } else if($id >= 10 && $id < 100){
                            $id_transfer = "0".$id.date('my', strtotime($this->input->post("tgl")));
                        } else if($id >= 100 && $id < 1000){
                            $id_transfer = $id.date('my', strtotime($this->input->post("tgl")));
                        }
                    // id transfer
                    
                    if($this->input->post("alamat")){
                        $alamat = $this->input->post("alamat");
                    } else {
                        $alamat = "-";
                    }

                    $data = [
                        "id_transfer" => $id_transfer,
                        "tgl_transfer" => $this->input->post("tgl"),
                        "nama_transfer" => $this->input->post("nama_pembayaran"),
                        "pengajar" => "-",
                        "uraian" => $this->input->post("uraian"),
                        "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                        "keterangan" => $this->input->post("keterangan"),
                        "metode" => $this->input->post("metode"),
                        "alamat" => $alamat
                    ];
                    $result = $this->Main_model->add_data("transfer", $data);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menambahkan transaksi transfer<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                // transfer
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    // add data
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ppu extends CI_CONTROLLER{
    public function __construct(){
        parent::__construct();
        $this->load->model("Main_model");
        if($this->session->userdata("status") != "login"){
            $this->session->set_flashdata("flash", "Maaf, Anda harus login terlebih dahulu");
            redirect(base_url('login'));
        }
    }

    public function index(){
        $data['title'] = "Transaksi PPU";

        // get_all($table, $where = "", $order = "", $by = "ASC")
        $transfer = $this->Main_model->get_all("ppu_transfer", "", "tgl", "DESC");
        $cash = $this->Main_model->get_all("ppu_cash", "", "tgl", "DESC");
        
        $i = 0;
        $data['ppu'] = [];

        foreach ($transfer as $trf) {
            $data['ppu'][$i] = $trf;
            $data['ppu'][$i]['metode'] = "Transfer";
            $i++;
        }
        
        foreach ($cash as $cash) {
            $data['ppu'][$i] = $cash;
            $data['ppu'][$i]['metode'] = "Cash";
            $i++;
        }

        usort($data['ppu'], function($a, $b) {
            return $a['tgl'] < $b['tgl']?1:-1;
        });

        // var_dump($data);
        $this->load->view("templates/header", $data);
        $this->load->view("templates/sidebar");
        $this->load->view("ppu/transaksi", $data);
        $this->load->view("templates/footer");
    }

    public function kuitansi_transfer($id){
        
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'margin_top' => '14', 'fontDir' => array_merge($fontDirs, [__DIR__ . 'assets/font',]),
        'fontdata' => $fontData + [
            'candara' => [
                'R' => 'Candara.ttf'
            ]
        ],
        'default_font' => 'candara']);
        
        $kwitansi['data'] = $this->Main_model->get_one("ppu_transfer", ["id" => $id]);
        
        
        $kwitansi['id'] = substr($kwitansi['data']['id'],0, 3)."/PPU-Im/".date('m', strtotime($kwitansi['data']['tgl']))."/".date('Y', strtotime($kwitansi['data']['tgl']));

        // var_dump($kwitansi);
        $data = $this->load->view('ppu/kuitansi_transfer', $kwitansi, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

    public function kuitansi_cash($id){
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        
        // $kwitansi['kwitansi'] = $this->Fo_model->get_data_pembayaran($id);
        $kwitansi['kwitansi'] = $this->Fo_model->get_one("pembayaran", ["MD5(id_pembayaran) = " => $id]);
        $bulan = date("m", strtotime($kwitansi['kwitansi']['tgl_pembayaran']));
        $tahun = date("y", strtotime($kwitansi['kwitansi']['tgl_pembayaran']));
        $tgl = date("d", strtotime($kwitansi['kwitansi']['tgl_pembayaran']));
        $id = $kwitansi['kwitansi']['id_pembayaran'];
        if($id > 0 && $id < 10){
            $id = '00000'.$id;
        } else if($id >= 10 && $id < 100){
            $id = '0000'.$id;
        } else if($id >= 100 && $id < 1000){
            $id = '000'.$id;
        } else if($id >= 1000 && $id < 10000){
            $id = '00'.$id;
        } else if($id >= 10000 && $id < 100000){
            $id = '0'.$id;
        } else {
            $id = $id;
        };

        $kwitansi['id'] = $tahun.$bulan.$id;
        // var_dump($kwitansi);
		$data = $this->load->view('transaksi/cetak_kuitansi', $kwitansi, TRUE);
        $mpdf->WriteHTML($data);
		$mpdf->Output();
    }

    // add
        public function add_transaksi(){
            // var_dump($_POST);
            // exit();
            $metode = $this->input->post("metode", TRUE);

            if($this->input->post("lainnya", TRUE)){
                $jenis = $this->input->post("lainnya", TRUE);
            } else {
                $jenis = $this->input->post("jenis", TRUE);
            }

            $data = [
              "nama" => $this->input->post("nama", TRUE),
              "jenis" => $jenis,
              "tgl" => $this->input->post("tgl", TRUE),
              "alamat" => $this->input->post("alamat", TRUE),
              "nominal" => $this->Main_model->nominal($this->input->post("nominal", TRUE)),
            ];

            if($metode == "Cash"){
                $bulan = date("m", strtotime($this->input->post("tgl")));
                $tahun = date("Y", strtotime($this->input->post("tgl")));
                $id = $this->Main_model->get_last_id("ppu_cash", "id", "MONTH(tgl) = '$bulan' AND YEAR(tgl) = '$tahun'");
                $id = substr($id['id'], -3) + 1;
                
                // id cash
                    if($id >= 1 && $id < 10){
                        $id_cash = date('ymd', strtotime($this->input->post("tgl")))."00".$id;
                    } else if($id >= 10 && $id < 100){
                        $id_cash = date('ymd', strtotime($this->input->post("tgl")))."0".$id;
                    } else if($id >= 100 && $id < 1000){
                        $id_cash = date('ymd', strtotime($this->input->post("tgl"))).$id;
                    }
                // id cash
                
                $data['id'] = $id_cash;
                $this->Main_model->add_data("ppu_cash", $data);
            } else {
                // $data['id'] = ;
                $bulan = date("m", strtotime($this->input->post("tgl")));
                $tahun = date("Y", strtotime($this->input->post("tgl")));
                $id = $this->Main_model->get_last_id("ppu_transfer", "id", "MONTH(tgl) = '$bulan' AND YEAR(tgl) = '$tahun'");
                $id = substr($id['id'], 0, 3) + 1;
                    
                // id transfer
                    if($id >= 1 && $id < 10){
                        $id_transfer = "00".$id.date('my', strtotime($this->input->post("tgl")));
                    } else if($id >= 10 && $id < 100){
                        $id_transfer = "0".$id.date('my', strtotime($this->input->post("tgl")));
                    } else if($id >= 100 && $id < 1000){
                        $id_transfer = $id.date('my', strtotime($this->input->post("tgl")));
                    }
                // id transfer
                $data['id'] = $id_transfer;
                $this->Main_model->add_data("ppu_transfer", $data);
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menambahkan transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    // add

    // get
        public function get_transaksi(){

            if($this->input->post("id_cash")){
                $data = $this->Main_model->get_one("ppu_cash", ["id" => $this->input->post("id_cash")]);
            } else {
                $data = $this->Main_model->get_one("ppu_transfer", ["id" => $this->input->post("id_transfer")]);
            }

            echo json_encode($data);
        }
    // get 

    // edit 
        public function edit_transaksi(){
            var_dump($_POST);
            if($this->input->post("lainnya", TRUE)){
                $jenis = $this->input->post("lainnya", TRUE);
            } else {
                $jenis = $this->input->post("jenis", TRUE);
            }

            $data = [
                "nama" => $this->input->post("nama", TRUE),
                "jenis" => $jenis,
                "tgl" => $this->input->post("tgl", TRUE),
                "alamat" => $this->input->post("tgl", TRUE),
                "nominal" => $this->Main_model->nominal($this->input->post("nominal", TRUE))
            ];

            if($this->input->post("metode") == "Cash"){
                $this->Main_model->edit_data("ppu_cash", ["id" => $this->input->post("id")], $data);
            } else {
                $this->Main_model->edit_data("ppu_transfer", ["id" => $this->input->post("id")], $data);
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil mengubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
}
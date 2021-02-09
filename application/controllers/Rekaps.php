<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends CI_CONTROLLER{
    public function __construct(){
        parent::__construct();
        $this->load->model("Keuangan_model");
        $this->load->model("Main_model");
        if($this->session->userdata("status") != 'login'){
            $this->session->set_flashdata("flash", "Maaf, Anda harus login terlebih dahulu");
            redirect(base_url('login'));
        }
        
        ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');
    }

    public function honor(){
        $data['title'] = "List Rekap Honor";
        $data['month'] = ["1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli","8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"];
        $data['periode'] = [];

        $tahun = $this->Keuangan_model->get_tahun();
        
        foreach ($tahun as $key => $tahun) {
            $data['periode'][$key]['tahun'] = $tahun['tahun'];
            $bulan = $this->Keuangan_model->get_bulan($tahun['tahun']);
            foreach ($bulan as $i => $bulan) {
                $data['periode'][$key]['bulan'][$i] = $bulan['bulan'];
            }
        };

        $this->load->view("templates/header", $data);
        $this->load->view("templates/sidebar");
        $this->load->view("rekap/rekap-honor", $data);
        $this->load->view("templates/footer");
    }

    public function exporthonor($bulan, $tahun){

        $filename = "Rekap_Honor_{$bulan}_{$tahun}";

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');

        $month = ["1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli","8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"];
        $data['header'] = "List Rekap Honor {$month[$bulan]} {$tahun}";
        $data["pengajar"] = [];
        
        // $nip = $this->Keuangan_model->get_all_nip();
        $nip = $this->Main_model->get_all("kpq");
        $data['pengajar'] = [];

        foreach ($nip as $key => $nip) {
            $data['pengajar'][$key] = $nip;
            $kelas = $this->Keuangan_model->get_kelas_by_periode($bulan, $tahun, $nip['nip']);
            foreach ($kelas as $i => $kelas) {
                $data['pengajar'][$key]['kelas'][$i] = $kelas;
                $data['pengajar'][$key]['kelas'][$i]['jum_peserta'] = COUNT($this->Keuangan_model->get_all_peserta_by_periode_by_id_kelas($bulan, $tahun, $kelas['id_kelas']));
                $kbm = $this->Keuangan_model->get_tgl_kbm_by_periode_by_id_jadwal($bulan, $tahun, $nip['nip'], $kelas['id_jadwal']);
                foreach ($kbm as $j => $kbm) {
                    $data['pengajar'][$key]['kelas'][$i]['kbm'][$j] = $kbm;
                    $peserta_hadir = $this->Keuangan_model->get_peserta_kbm($kbm['id_kbm']);
                    $data['pengajar'][$key]['kelas'][$i]['kbm'][$j]['peserta'] = $peserta_hadir['peserta_hadir'];
                }
            }
            
            $badal = $this->Keuangan_model->get_kbm_badal_by_periode($bulan, $tahun, $nip['nip']);
            foreach ($badal as $k => $badal) {
                $data['pengajar'][$key]['kbm_badal'][$k] = $badal;
            }

            // if($key == 10){
            //     break;
            // }
        }

        // var_dump($data);
        // exit();
        $this->load->view("rekap/rekap-bulanan", $data);
    }
}
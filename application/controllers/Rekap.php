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
        
        // $nip = $this->Keuangan_model->get_all_nip();
        $nip = $this->Main_model->get_all("kpq", "", "nama_kpq", "ASC");
        $data['pengajar'] = [];

        foreach ($nip as $key => $nip) {
            $data['pengajar'][$key] = $nip;

            // kelas 
                $kbm = $this->Main_model->get_all("kbm", ["MONTH(tgl)" => $bulan, "YEAR(tgl)" => $tahun, "nip" => $nip['nip']]);
                $id_jadwal = [];
                foreach ($kbm as $i => $kbm) {
                    $id_jadwal[] = $kbm['id_jadwal'];
                }
                $id_jadwal = array_unique($id_jadwal);
                $i = 0;
                foreach ($id_jadwal as $id_jadwal) {
                    $jadwal = $this->Main_model->get_one("jadwal", ["id_jadwal" => $id_jadwal]);
                    $kelas = $this->Main_model->get_one("kelas", ["id_kelas" => $jadwal['id_kelas']]);
                    $kbm_kelas = $this->Main_model->get_all("kbm", ["MONTH(tgl)" => $bulan, "YEAR(tgl)" => $tahun, "nip" => $nip['nip'], "id_kelas" => $jadwal['id_kelas'], "id_jadwal" => $jadwal['id_jadwal']]);

                    $jum_peserta = [];

                    foreach ($kbm_kelas as $j => $kbm) {
                        $peserta = COUNT($this->Main_model->get_all("presensi_peserta", ["id_kbm" => $kbm['id_kbm'], "hadir" => 1]));
                        $kbm_kelas[$j]['pj'] = $kbm['peserta'];
                        $kbm_kelas[$j]['peserta'] = $peserta;
                        
                        $jum_peserta[] = $kbm['jum_peserta'];
                    }

                    $data['pengajar'][$key]['kelas'][$i] = [
                        'id_kelas' => $kelas['id_kelas'],
                        'nip' => $kelas['nip'],
                        // 'periode' => string '5 2020' (length=6)
                        'peserta' => $kbm_kelas[0]['pj'],
                        'jum_peserta' => max($jum_peserta),
                        'program_kbm' => $kbm_kelas[0]['program_kbm'],
                        'id_jadwal' => $jadwal['id_jadwal'],
                        'hari' => $jadwal['hari'],
                        'jam' => $jadwal['jam'],
                        'tempat' => $jadwal['tempat'],
                        'tipe_kelas' => $kelas['tipe_kelas'],
                        'ot' => $jadwal['ot'],
                        'kbm' => $kbm_kelas
                    ];
                    $i++;
                }
                
                // pembinaan 
                // $kbm = $this->Main_model->get_all("kbm_pembinaan", ["MONTH(tgl)" => $bulan, "YEAR(tgl)" => $tahun, "nip" => $nip['nip']]);
                // $id_kelas = [];
                // foreach ($kbm as $kbm) {
                //     $id_kelas[] = $kbm['id_kelas'];
                // }
                // $id_kelas = array_unique($id_kelas);
                // // $i = 0;
                // foreach ($id_kelas as $id_kelas) {
                //     $kelas = $this->Main_model->get_one("kelas_pembinaan", ["id_kelas" => $id_kelas]);
                //     $kelas['tipe_kelas'] = "Pembinaan";
                    
                //     $kbm_kelas = $this->Main_model->get_all("kbm_pembinaan", ["MONTH(tgl)" => $bulan, "YEAR(tgl)" => $tahun, "nip" => $nip['nip'], "id_kelas" => $id_kelas]);

                //     $jum_peserta = [];

                //     foreach ($kbm_kelas as $j => $kbm) {
                //         $peserta = COUNT($this->Main_model->get_all("presensi_kpq", ["id_kbm" => $kbm['id_kbm'], "hadir" => 1]));
                //         $kbm_kelas[$j]['pj'] = $kbm['peserta'];
                //         $kbm_kelas[$j]['peserta'] = $peserta;
                        
                //         $jum_peserta[] = $kbm['jum_peserta'];
                //     }

                //     $data['pengajar'][$key]['kelas'][$i] = [
                //         'id_kelas' => $kelas['id_kelas'],
                //         'nip' => $kelas['nip'],
                //         // 'periode' => string '5 2020' (length=6)
                //         'peserta' => $kbm_kelas[0]['pj'],
                //         'jum_peserta' => max($jum_peserta),
                //         'program_kbm' => $kbm_kelas[0]['program_kbm'],
                //         // 'id_jadwal' => $jadwal['id_jadwal'],
                //         'hari' => $kelas['hari'],
                //         'jam' => $kelas['jam'],
                //         'tempat' => $kelas['tempat'],
                //         'tipe_kelas' => $kelas['tipe_kelas'],
                //         'ot' => "0",
                //         'kbm' => $kbm_kelas
                //     ];
                //     $i++;
                // }

                $id_badal = $this->Main_model->get_all("kbm_badal", ["nip_badal" => $nip['nip']]);
                $k = 0;
                foreach ($id_badal as $badal) {
                    $kbm = $this->Main_model->get_one("kbm", ["id_kbm" => $badal['id_kbm'], "MONTH(tgl)" => $bulan, "YEAR(tgl)" => $tahun]);
                    if($kbm){
                        $kpq = $this->Main_model->get_one("kpq", ["nip" => $kbm['nip']]);
                        $kelas = $this->Main_model->get_one("kelas", ["id_kelas" => $kbm['id_kelas']]);
                        $jadwal = $this->Main_model->get_one("jadwal", ["id_jadwal" => $kbm['id_jadwal']]);
        
                        $data['pengajar'][$key]['kbm_badal'][$k] = [
                            'id_kbm' => $badal['id_kbm'],
                            'peserta' => $kbm['peserta'],
                            'tgl' => $kbm['tgl'],
                            'hari' => $kbm['hari'],
                            'jam' => $kbm['jam'],
                            'biaya' => $kbm['biaya'],
                            'ot' => $kbm['ot'],
                            'nama_kpq' => $kpq['nama_kpq'],
                            'program_kbm' => $kbm['program_kbm'],
                            'tipe_kelas' => $kelas['tipe_kelas'],
                            'oot' => $jadwal['ot']
                        ];
                        $k++;
                    }
                }
                
                // pembinaan 
                // $id_badal = $this->Main_model->get_all("kbm_badal_pembinaan", ["nip_badal" => $nip['nip']]);
                // foreach ($id_badal as $badal) {
                //     $kbm = $this->Main_model->get_one("kbm_pembinaan", ["id_kbm" => $badal['id_kbm'], "MONTH(tgl)" => $bulan, "YEAR(tgl)" => $tahun]);
                //     if($kbm){
                //         $kpq = $this->Main_model->get_one("kpq", ["nip" => $kbm['nip']]);
                //         $kelas = $this->Main_model->get_one("kelas", ["id_kelas" => $kbm['id_kelas']]);
                //         $kelas['tipe_kelas'] = "Pembinaan";
        
                //         $data['pengajar'][$key]['kbm_badal'][$k] = [
                //             'id_kbm' => $badal['id_kbm'],
                //             'peserta' => $kbm['peserta'],
                //             'tgl' => $kbm['tgl'],
                //             'hari' => $kbm['hari'],
                //             'jam' => $kbm['jam'],
                //             'biaya' => $kbm['biaya'],
                //             'ot' => $kbm['ot'],
                //             'nama_kpq' => $kpq['nama_kpq'],
                //             'program_kbm' => $kbm['program_kbm'],
                //             'tipe_kelas' => $kelas['tipe_kelas'],
                //             'oot' => "0"
                //         ];
                //         $k++;
                //     }
                // }
            // kelas 
        }

        // var_dump($data);
        // exit();

        $this->load->view("rekap/rekap-bulanan", $data);
    }
}
<?php
    class Piutang extends CI_CONTROLLER{
        public function __construct(){
            parent::__construct();
            $this->load->model('Keuangan_model');
            $this->load->model('Main_model');
            
            if($this->session->userdata('status') != "login"){
                $this->session->set_flashdata('flash', 'Maaf, Anda harus login terlebih dahulu');
                redirect(base_url("login"));
            }
            
            ini_set("xdebug.var_display_max_children", -1);
            ini_set("xdebug.var_display_max_data", -1);
            ini_set("xdebug.var_display_max_depth", -1);
        }

        public function reguler(){
            $data['title'] = 'Piutang Peserta Reguler';
            
            $data["peserta"] = [];

            $peserta = $this->Keuangan_model->get_peserta_reguler();
            foreach ($peserta as $key => $peserta) {
                $data['peserta'][$key] = $peserta;

                // tagihan
                $tagihan = $this->Keuangan_model->get_total_tagihan_peserta($peserta['id_peserta']);
                // deposit
                $deposit = $this->Keuangan_model->get_total_deposit_peserta($peserta['id_peserta']);
                // bayar cash
                $cash = $this->Keuangan_model->get_total_cash_peserta($peserta['id_peserta']);
                // bayar transfer
                $transfer = $this->Keuangan_model->get_total_transfer_peserta($peserta['id_peserta']);

                $data['peserta'][$key]['piutang'] =  $tagihan['total'] + $deposit['total'] ;

                $data['peserta'][$key]['bayar'] = $transfer['total'] + $cash['total'];
            }
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('piutang/piutang_peserta', $data);
            $this->load->view('templates/footer');
        }

        public function pvKhusus(){
            $data['title'] = 'Piutang Kelas Pv Khusus';

            $data['kelas'] = [];

            $kelas = $this->Keuangan_model->get_kelas_pv_khusus();
            foreach ($kelas as $key => $kelas) {
                $data['kelas'][$key] = $kelas;
                
                // tagihan
                $tagihan = $this->Keuangan_model->get_total_tagihan_kelas($kelas['id_kelas']);
                // deposit
                $deposit = $this->Keuangan_model->get_total_deposit_kelas($kelas['id_kelas']);
                // bayar cash
                $cash = $this->Keuangan_model->get_total_cash_kelas($kelas['id_kelas']);
                // bayar transfer
                $transfer = $this->Keuangan_model->get_total_transfer_kelas($kelas['id_kelas']);

                $data['kelas'][$key]['piutang'] =  $tagihan['total'] + $deposit['total'] ;

                $data['kelas'][$key]['bayar'] = $transfer['total'] + $cash['total'];
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('piutang/piutang_kelas', $data);
            $this->load->view('templates/footer');
        }
        
        public function pvLuar(){
            $data['title'] = 'Piutang Kelas Pv Luar';

            $data['kelas'] = [];

            $kelas = $this->Main_model->get_all("kelas_pv_luar", "ket <> 'pv instansi'", "nama_peserta");
            foreach ($kelas as $key => $kelas) {
                $data['kelas'][$key] = $kelas;
                // tagihan
                $tagihan = $this->Keuangan_model->get_total_tagihan_kelas($kelas['id_kelas']);
                // deposit
                $deposit = $this->Keuangan_model->get_total_deposit_kelas($kelas['id_kelas']);
                // bayar cash
                $cash = $this->Keuangan_model->get_total_cash_kelas($kelas['id_kelas']);
                // bayar transfer
                $transfer = $this->Keuangan_model->get_total_transfer_kelas($kelas['id_kelas']);

                $data['kelas'][$key]['piutang'] =  $tagihan['total'] + $deposit['total'] ;

                $data['kelas'][$key]['bayar'] = $transfer['total'] + $cash['total'];
                $data['kelas'][$key]['tagihan'] = $this->Keuangan_model->get_tagihan_kelas($kelas['id_kelas']);
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('piutang/piutang_kelas', $data);
            $this->load->view('templates/footer');
        }

        public function pvInstansi(){
            $data['title'] = 'Piutang Kelas Pv Instansi';

            $data['kelas'] = [];

            $kelas = $this->Main_model->get_all("kelas_pv_luar", ["ket" => "pv instansi"], "nama_peserta");
            foreach ($kelas as $key => $kelas) {
                $data['kelas'][$key] = $kelas;
                // tagihan
                $tagihan = $this->Keuangan_model->get_total_tagihan_kelas($kelas['id_kelas']);
                // deposit
                $deposit = $this->Keuangan_model->get_total_deposit_kelas($kelas['id_kelas']);
                // bayar cash
                $cash = $this->Keuangan_model->get_total_cash_kelas($kelas['id_kelas']);
                // bayar transfer
                $transfer = $this->Keuangan_model->get_total_transfer_kelas($kelas['id_kelas']);

                $data['kelas'][$key]['piutang'] =  $tagihan['total'] + $deposit['total'] ;

                $data['kelas'][$key]['bayar'] = $transfer['total'] + $cash['total'];
                $data['kelas'][$key]['tagihan'] = $this->Keuangan_model->get_tagihan_kelas($kelas['id_kelas']);
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('piutang/piutang_kelas', $data);
            $this->load->view('templates/footer');
        }

        public function kpq(){
            $data['title'] = 'Piutang Civitas';
            $data['tabs'] = 'kpq';
            
            $data['kpq'] = [];
            $kpq = $this->Keuangan_model->get_all_civitas();
            foreach ($kpq as $key => $kpq) {
                $data['kpq'][$key] = $kpq;
                
                // tagihan
                $tagihan = $this->Keuangan_model->get_total_tagihan_kpq($kpq['nip']);
                // deposit
                $deposit = $this->Keuangan_model->get_total_deposit_kpq($kpq['nip']);
                // bayar cash
                $cash = $this->Keuangan_model->get_total_cash_kpq($kpq['nip']);
                // bayar transfer
                $transfer = $this->Keuangan_model->get_total_transfer_kpq($kpq['nip']);

                $data['kpq'][$key]['piutang'] =  $tagihan['total'] + $deposit['total'] ;

                $data['kpq'][$key]['bayar'] = $transfer['total'] + $cash['total'];
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('piutang/piutang_kpq', $data);
            $this->load->view('templates/footer');
        }

        public function generatePiutangPrivat(){
            $bulan = ["1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"];

            $kelas = $this->Keuangan_model->getAllKelasPvAktif();

            $data['kelas'] = [];
            foreach ($kelas as $i => $kelas) {
                $data['kelas'][$i] = $kelas;
                $jadwal = $this->Keuangan_model->get_jadwal_aktif_by_id_kelas($kelas['id_kelas']);
                $nominal = 0;
                $data['kelas'][$i]['ot'] = 0;
                foreach ($jadwal as $jadwal) {
                    if($jadwal['ot'] != 0){
                        $data['kelas'][$i]['ot'] += 1; 
                    }
                }
                $data['kelas'][$i]['jadwal']= COUNT($this->Keuangan_model->get_jadwal_aktif_by_id_kelas($kelas['id_kelas']));
                
                // infaq overtime
                    $ot = $this->Keuangan_model->getInfaqByKet("ot");
                    $data['kelas'][$i]['pembayaran']['ot'] = $data['kelas'][$i]['ot'] * $ot['infaq'];
                // infaq overtime

                // infaq jadwal
                    $biayajadwal = $this->Keuangan_model->getInfaqByKet($kelas['ket']);
                    $data['kelas'][$i]['pembayaran']['jadwal'] = $data['kelas'][$i]['jadwal'] * $biayajadwal['infaq']; 
                // infaq jadwal

                if ($data['kelas'][$i]['ot'] == 0){
                    $uraian = $bulan[date('n')] . " " . date('Y') . " " . $data['kelas'][$i]['jadwal'] . " jadwal";
                } else {
                    $uraian = $bulan[date('n')] . " " . date('Y') . " " . $data['kelas'][$i]['jadwal'] . " jadwal + " . $data['kelas'][$i]['ot'] . " OT";
                }

                // var_dump($data);
                $nominal = $data['kelas'][$i]['pembayaran']['jadwal'] + $data['kelas'][$i]['pembayaran']['ot'];

                // tentukan tagihannya
                $id = $this->Keuangan_model->getLastIdTagihan();
                $id_tagihan = $id['id_tagihan'] + 1;

                $data = [
                    "id_tagihan" => $id_tagihan,
                    "tgl_tagihan" => date("Y-m-d"),
                    "nama_tagihan" => $kelas['nama_peserta'],
                    "uraian" => $uraian,
                    "nominal" => $nominal,
                    "status" => "piutang",
                    "ket" => "bulanan"
                ];

                $this->Keuangan_model->insert_tagihan($data);
                
                $data = [
                    "id_tagihan" => $id_tagihan,
                    "id_kelas" => $kelas['id_kelas']
                ];

                $this->Keuangan_model->insert_tagihan_kelas($data);
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil <strong>mengenerate</strong> piutang peserta privat<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            
            redirect('piutang/pvluar');
        }
        
        public function generatePiutangReguler(){
            $bulan = ["1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"];

            $reguler = $this->Keuangan_model->getInfaqByKet("reguler");
            $peserta = $this->Keuangan_model->getAllPesertaRegulerAktif();
            $uraian = $bulan[date('n')] . " " . date('Y');
            foreach ($peserta as $peserta) {
                $id = $this->Keuangan_model->getLastIdTagihan();
                $id_tagihan = $id['id_tagihan'] + 1;
                
                $data = [
                    "id_tagihan" => $id_tagihan,
                    "tgl_tagihan" => date("Y-m-d"),
                    "nama_tagihan" => $peserta['nama_peserta'],
                    "uraian" => $uraian,
                    "nominal" => $reguler['infaq'],
                    "status" => "piutang",
                    "ket" => "bulanan"
                ];

                $this->Keuangan_model->insert_tagihan($data);

                $data = [
                    "id_tagihan" => $id_tagihan,
                    "id_peserta" => $peserta['id_peserta']
                ];

                $this->Keuangan_model->insert_tagihan_peserta($data);

            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil <strong>mengenerate</strong> piutang peserta reguler<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            
            redirect('piutang/pvluar');
        }

        public function pembayaran(){
            $tipe = $_POST['tipe'];
            $metode = $_POST['metode'];
            $id = $this->input->post("id", TRUE);
            $nama = $_POST['nama'];

            if($metode == "Deposit"){
                $this->Keuangan_model->add_pembayaran_by_deposit();
            } else {
                $id_tagihan = $this->Keuangan_model->getLastIdTagihan();
    
                $id_tagihan = $id_tagihan['id_tagihan']+1;
    
                $this->Keuangan_model->cek_add_pembayaran($id_tagihan, $nama, $tipe, $id);
            }
            
            $this->session->set_flashdata('piutang', 'ditambahkan');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        public function edit_pj(){
            $id = $this->input->post("id", TRUE);
            $data = [
                "pj" => $this->input->post("nama", TRUE)
            ];

            $this->Keuangan_model->edit_pj($id, $data);
            
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil <strong>mengubah</strong> pj kelas<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            redirect($_SERVER['HTTP_REFERER']);
        }

        public function edit_ket($id, $ket){
            if($ket == "pvinstansi"){
                $data = [
                    "ket" => "pv luar"
                ];
                $this->Main_model->edit_data("kelas", ["id_kelas" => $id], $data);
            } else if($ket == "pvluar"){
                $data = [
                    "ket" => "pv instansi"
                ];
                $this->Main_model->edit_data("kelas", ["id_kelas" => $id], $data);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil <strong>mengubah</strong> tipe kelas<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

?>
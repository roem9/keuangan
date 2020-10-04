<?php
class KartuPiutang extends CI_CONTROLLER{
    public function __construct(){
        parent::__construct();
        $this->load->model('Keuangan_model');
        $this->load->model('Main_model');
        $this->load->model('KartuPiutang_model');
        
        if($this->session->userdata('status') != "login"){
            $this->session->set_flashdata('flash', 'Maaf, Anda harus login terlebih dahulu');
            redirect(base_url("login"));
        }
    }

    // page
        public function kelas($id_kelas){
            $data['bulan'] = ["1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"];

            $data['kelas'] = $this->KartuPiutang_model->dataKelasPrivat($id_kelas);
            $data['peserta'] = $this->KartuPiutang_model->dataPesertaById($id_kelas);
            $data['jadwal'] = $this->KartuPiutang_model->dataJadwalById($id_kelas);

            $data['header'] = "Kartu Piutang {$data['kelas']['nama_peserta']}";
            $data['title'] = "Kartu Piutang {$data['kelas']['nama_peserta']}";

            $data['total'] = 0;
            $data['detail'] = [];
            $i = 0;
            $piutang = $this->KartuPiutang_model->get_tagihan_kelas($id_kelas);
            foreach ($piutang as $piutang) {
                $data['detail'][$i] = $piutang;
                $data['detail'][$i]['tgl'] = $piutang['tgl_tagihan'];
                $data['detail'][$i]['status'] = "tagihan";
                $data['detail'][$i]['ket'] = $piutang['stat'];
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $deposit = $this->KartuPiutang_model->get_deposit_kelas($id_kelas);
            foreach ($deposit as $deposit) {
                $data['detail'][$i] = $deposit;
                $data['detail'][$i]['tgl'] = $deposit['tgl_deposit'];
                $data['detail'][$i]['status'] = "deposit";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }

            $data['total'] = $data['total'] * -1;

            $pembayaran = $this->KartuPiutang_model->get_pembayaran_kelas_cash($id_kelas);
            foreach ($pembayaran as $pembayaran) {
                $data['detail'][$i] = $pembayaran;
                $data['detail'][$i]['tgl'] = $pembayaran['tgl_pembayaran'];
                $data['detail'][$i]['status'] = "cash";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $pembayaran = $this->KartuPiutang_model->get_pembayaran_kelas_transfer($id_kelas);
            foreach ($pembayaran as $pembayaran) {
                $data['detail'][$i] = $pembayaran;
                $data['detail'][$i]['tgl'] = $pembayaran['tgl_transfer'];
                $data['detail'][$i]['status'] = "transfer";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $data['invoice'] = $this->KartuPiutang_model->get_invoice_kelas($id_kelas);

            usort($data['detail'], function($a, $b) {
                return $a['tgl'] <=> $b['tgl'];
                // if($a['tgl']==$b['tgl']) return 0;
                // return $a['tgl'] < $b['tgl']?1:-1;
            });

            $data['id'] = $id_kelas;
            $data['kbm'] = $this->KartuPiutang_model->get_data_kbm($id_kelas);
            
            // data modal
                // $kelas = $this->Main_model->get_data_kelas_by_id($id_kelas);
                $kelas = $this->Main_model->get_one("kelas", ["id_kelas" => $id_kelas]);
                // $kpq = $this->Main_model->get_kpq_by_id($kelas['nip']);
                $kpq = $this->Main_model->get_one("kpq", ["nip" => $kelas['nip']]);
                $data['kpq'] = $kpq['nama_kpq'];
                $data['tipe'] = "kelas";
                $data['id'] = $id_kelas;
                $data['nama'] = $data['kelas']['nama_peserta'];
            // data modal

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('modal/modal_tambah_invoice');
            $this->load->view('modal/modal_edit_invoice');
            $this->load->view('modal/modal_transaksi', $data);
            // $this->load->view('modal/modal_edit_status_tagihan');
            $this->load->view('modal/modal_edit_tagihan');
            $this->load->view('piutang/kartu-piutang-kelas', $data);
            $this->load->view('templates/footer');
        }

        public function kpq($nip){
            $data['kpq'] = $this->Keuangan_model->getDataKpq($nip);
            $data['header'] = "Kartu Piutang {$data['kpq']['nama_kpq']}";
            $data['title'] = "Kartu Piutang {$data['kpq']['nama_kpq']}";
            $data['total'] = 0;
            $data['detail'] = [];
            $i = 0;
            $piutang = $this->Keuangan_model->get_tagihan_kpq($nip);
            foreach ($piutang as $piutang) {
                $data['detail'][$i] = $piutang;
                $data['detail'][$i]['tgl'] = $piutang['tgl_tagihan'];
                $data['detail'][$i]['status'] = "tagihan";
                $data['detail'][$i]['ket'] = $piutang['stat'];
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $deposit = $this->Keuangan_model->get_deposit_kpq($nip);
            foreach ($deposit as $deposit) {
                $data['detail'][$i] = $deposit;
                $data['detail'][$i]['tgl'] = $deposit['tgl_deposit'];
                $data['detail'][$i]['status'] = "deposit";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }

            $data['total'] = $data['total'] * -1;

            $pembayaran = $this->Keuangan_model->get_pembayaran_kpq_cash($nip);
            foreach ($pembayaran as $pembayaran) {
                $data['detail'][$i] = $pembayaran;
                $data['detail'][$i]['tgl'] = $pembayaran['tgl_pembayaran'];
                $data['detail'][$i]['status'] = "cash";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $pembayaran = $this->Keuangan_model->get_pembayaran_kpq_transfer($nip);
            foreach ($pembayaran as $pembayaran) {
                $data['detail'][$i] = $pembayaran;
                $data['detail'][$i]['tgl'] = $pembayaran['tgl_transfer'];
                $data['detail'][$i]['status'] = "transfer";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $data['invoice'] = $this->Keuangan_model->get_invoice_kpq($nip);
            $data['id'] = $nip;
            
            usort($data['detail'], function($a, $b) {
                return $a['tgl'] <=> $b['tgl'];
                // if($a['tgl']==$b['tgl']) return 0;
                // return $a['tgl'] < $b['tgl']?1:-1;
            });
            
            // data modal
                $data['nama'] = $data['kpq']['nama_kpq'];
                $data['kpq'] = "-";
                $data['tipe'] = "kpq";
                $data['id'] = $nip;
            // data modal
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('modal/modal_tambah_invoice');
            $this->load->view('modal/modal_edit_invoice');
            $this->load->view('modal/modal_edit_status_tagihan');
            $this->load->view('modal/modal_transaksi', $data);
            $this->load->view('modal/modal_edit_tagihan');
            $this->load->view('piutang/kartu-piutang-kpq', $data);
            $this->load->view('templates/footer');
        }

        public function peserta($id_peserta){
            $data['total'] = 0;
            $data['detail'] = [];
            $i = 0;

            $piutang = $this->Keuangan_model->get_tagihan_peserta($id_peserta);
            foreach ($piutang as $piutang) {
                $data['detail'][$i] = $piutang;
                $data['detail'][$i]['tgl'] = $piutang['tgl_tagihan'];
                $data['detail'][$i]['status'] = "tagihan";
                $data['detail'][$i]['ket'] = $piutang['stat'];
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $deposit = $this->Keuangan_model->get_deposit_peserta($id_peserta);
            foreach ($deposit as $deposit) {
                $data['detail'][$i] = $deposit;
                $data['detail'][$i]['tgl'] = $deposit['tgl_deposit'];
                $data['detail'][$i]['status'] = "deposit";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }

            $data['total'] = $data['total'] * -1;

            $pembayaran = $this->Keuangan_model->get_pembayaran_peserta_cash($id_peserta);
            foreach ($pembayaran as $pembayaran) {
                $data['detail'][$i] = $pembayaran;
                $data['detail'][$i]['tgl'] = $pembayaran['tgl_pembayaran'];
                $data['detail'][$i]['status'] = "cash";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $pembayaran = $this->Keuangan_model->get_pembayaran_peserta_transfer($id_peserta);
            foreach ($pembayaran as $pembayaran) {
                $data['detail'][$i] = $pembayaran;
                $data['detail'][$i]['tgl'] = $pembayaran['tgl_transfer'];
                $data['detail'][$i]['status'] = "transfer";
                $data['total'] += $data['detail'][$i]['nominal'];
                $i++;
            }
            
            $data['invoice'] = $this->Keuangan_model->get_invoice_peserta($id_peserta);

            $data['peserta'] = $this->Keuangan_model->getDataPeserta($id_peserta);
            $data['header'] = "Kartu Piutang {$data['peserta']['nama_peserta']}";
            $data['title'] = "Kartu Piutang {$data['peserta']['nama_peserta']}";
            $data['id'] = $id_peserta;
            
            usort($data['detail'], function($a, $b) {
                return $a['tgl'] <=> $b['tgl'];
                // if($a['tgl']==$b['tgl']) return 0;
                // return $a['tgl'] < $b['tgl']?1:-1;
            });
            
            // data modal
                // $peserta = $this->Main_model->get_data_peserta_by_id($id_peserta);
                $peserta = $this->Main_model->get_one("peserta", ["id_peserta" => $id_peserta]);
                // $kelas = $this->Main_model->get_data_kelas_by_id($peserta['id_kelas']);
                $kelas = $this->Main_model->get_one("kelas", ["id_kelas" => $peserta['id_kelas']]);
                if($kelas){
                    // $kpq = $this->Main_model->get_kpq_by_id($kelas['nip']);
                    $kpq = $this->Main_model->get_one("kpq", ["nip" => $kelas['nip']]);
                    $data['kpq'] = $kpq['nama_kpq'];
                } else {
                    $data['kpq'] = "-";
                }
                $data['tipe'] = "peserta";
                $data['id'] = $id_peserta;
                $data['nama'] = $peserta['nama_peserta'];
            // data modal
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('modal/modal_tambah_invoice');
            $this->load->view('modal/modal_edit_invoice');
            $this->load->view('modal/modal_edit_tagihan', $data);
            $this->load->view('modal/modal_edit_status_tagihan');
            $this->load->view('modal/modal_transaksi', $data);
            $this->load->view('piutang/kartu-piutang-peserta', $data);
            $this->load->view('templates/footer');
        }
    // page
    
    public function getDataPeserta(){
        $id_peserta = $this->input->post("id_peserta");
        echo json_encode($this->Keuangan_model->getDataPeserta($id_peserta));
    }

    public function getDataKelas(){
        $id_kelas = $this->input->post("id_kelas");
        echo json_encode($this->Keuangan_model->dataKelasPrivat($id_kelas));
    }

    public function getDataKpq(){
        $nip = $this->input->post("nip");
        echo json_encode($this->Keuangan_model->getDataKpq($nip));
    }

    // public function tambah_piutang(){
    //     // tampilkan id terakhir dari tagihan kemudian tambah 1 
    //     $id = $this->Keuangan_model->idTagihanTerakhir();
    //     $id_tagihan = $id['id_tagihan'] + 1;

    //     // var_dump($_POST);
    //     $this->Keuangan_model->tambahPiutang($id_tagihan);
        
    //     $this->session->set_flashdata('piutang', 'ditambahkan');
    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    // public function add_pembayaran(){
    //     $this->Keuangan_model->add_pembayaran();

    //     $this->session->set_flashdata('piutang', 'ditambahkan');
    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    public function edit_transaksi(){
        $this->Keuangan_model->edit_transaksi();
        // $this->session->set_flashdata('piutang', 'ditambahkan');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function kwitansi($id){
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        
        $kwitansi['kwitansi'] = $this->Keuangan_model->get_data_pembayaran($id);
        $bulan = date("m", strtotime($kwitansi['kwitansi']['tgl_pembayaran']));
        $tahun = date("y", strtotime($kwitansi['kwitansi']['tgl_pembayaran']));
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
        $data = $this->load->view('piutang/cetak_kwitansi', $kwitansi, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

    public function kwitansi_transfer($id){
        
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
        
        $kwitansi['data'] = $this->Keuangan_model->get_data_pembayaran_transfer($id);
        
        
        $kwitansi['id'] = substr($kwitansi['data']['id_transfer'],0, 3)."/Keu-Im/".date('m', strtotime($kwitansi['data']['tgl_transfer']))."/".date('Y', strtotime($kwitansi['data']['tgl_transfer']));

        // var_dump($kwitansi);
        $data = $this->load->view('piutang/cetak_kwitansi_transfer', $kwitansi, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

    public function invoice($id){
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A5-L', 'margin_top' => '3', 'margin_left' => '3', 'margin_right' => '3', 'margin_bottom' => '3', 'fontDir' => array_merge($fontDirs, [__DIR__ . 'assets/font',]),
        'fontdata' => $fontData + [
            'candara' => [
                'R' => 'Candara.ttf'
            ]
        ],
        'default_font' => 'candara']);
        
        $invoice['invoice'] = $this->Keuangan_model->get_data_invoice($id);
        $invoice['detail'] = $this->Keuangan_model->get_data_uraian_invoice($id);

        $invoice['id'] = substr($invoice['invoice']['id_invoice'],0, 3)."/Tag-Im/".date('m', strtotime($invoice['invoice']['tgl_invoice']))."/".date('Y', strtotime($invoice['invoice']['tgl_invoice']));

        // var_dump($kwitansi);
        $data = $this->load->view('piutang/cetak_invoice', $invoice, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();

    }

    public function tambah_invoice(){
        $this->Keuangan_model->tambah_invoice();
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_invoice(){
        $aksi = $this->input->post("aksi");
        
        if($aksi == 'doc'){
            $this->Keuangan_model->edit_invoice();
        } else if($aksi == 'edit') {
            $this->Keuangan_model->edit_uraian();
        } else if($aksi == 'tambah'){
            $this->Keuangan_model->add_uraian();
        } else if($aksi == 'hapus'){
            $this->Keuangan_model->delete_uraian();
        }
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function deposit($id){
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'margin_top' => '3', 'margin_left' => '3', 'margin_right' => '3', 'margin_bottom' => '3']);
        
        $kwitansi['kwitansi'] = $this->Keuangan_model->get_data_pembayaran_deposit($id);

        // var_dump($kwitansi);
        $data = $this->load->view('piutang/cetak_kwitansi', $kwitansi, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output();
    }

    // add
        public function add_transaksi_langsung(){
            $tipe = $this->input->post("tipe");
            $id = $this->input->post("id");
            $pengajar = $this->input->post("pengajar");
            $nama = $this->input->post("nama");
            $metode = $this->input->post("metode");

            if($metode == "Deposit"){
                // $id_deposit = $this->Main_model->get_last_id_deposit();
                $id_deposit = $this->Main_model->get_last_id("deposit", "id_deposit");
                $id_deposit = $id_deposit['id_deposit'] + 1;
                $data = [
                    "id_deposit" => $id_deposit,
                    "tgl_deposit" => $this->input->post("tgl"),
                    "nama_deposit" => $this->input->post("nama"),
                    "pengajar" => $this->input->post("pengajar"),
                    "uraian" => $this->input->post("uraian"),
                    "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                    "keterangan" => $this->input->post("keterangan"),
                    "metode" => $this->input->post("metode")
                ]; 
                $this->Main_model->add_data("deposit", $data);
                // deposit sesuai tipe
                    if($tipe == 'kelas'){
                        $data = [
                            "id_deposit" => $id_deposit,
                            "id_kelas" => $this->input->post('id')
                        ];
                        $this->Main_model->add_data("deposit_kelas", $data);
                    } else if($tipe == 'peserta'){
                        $data = [
                            "id_deposit" => $id_deposit,
                            "id_peserta" => $this->input->post('id')
                        ];
                        $this->Main_model->add_data("deposit_peserta", $data);
                    } else if($tipe == 'kpq'){
                        $data = [
                            "id_deposit" => $id_deposit,
                            "nip" => $this->input->post('id')
                        ];
                        $this->Main_model->add_data("deposit_kpq", $data);
                    }
                // deposit sesuai tipe
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil melakukan transaksi langsung dengan metode <b>deposit</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else if($metode == "Cash"){
                // saat pembayaran cash insert tagihan yang berstatus lunas dan pembayaran
                if($this->input->post("tgl") >= "2020-10-01"){
                    // tagihan
                        // $id_tagihan = $this->Main_model->get_last_id_tagihan();
                        $id_tagihan = $this->Main_model->get_last_id("tagihan", "id_tagihan");
                        $id_tagihan = $id_tagihan['id_tagihan'] + 1;
    
                        $data = [
                            "id_tagihan" => $id_tagihan,
                            "tgl_tagihan" => $this->input->post("tgl"),
                            "nama_tagihan" => $this->input->post("nama"),
                            "uraian" => $this->input->post("uraian"),
                            "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                            "status" => "lunas"
                        ];
                        $this->Main_model->add_data("tagihan", $data);
    
                        // tagihan sesuai tipe
                            if($tipe == "peserta"){
                                $data = [
                                    "id_tagihan" => $id_tagihan,
                                    "id_peserta" => $this->input->post("id", TRUE)
                                ];
                                $this->Main_model->add_data("tagihan_peserta", $data);
                            } else  if($tipe == "kelas"){
                                $data = [
                                    "id_tagihan" => $id_tagihan,
                                    "id_kelas" => $this->input->post("id", TRUE)
                                ];
                                $this->Main_model->add_data("tagihan_kelas", $data);
                            } else if($tipe == "kpq"){
                                $data = [
                                    "id_tagihan" => $id_tagihan,
                                    "nip" => $this->input->post("id", TRUE)
                                ];
                                $this->Main_model->add_data("tagihan_kpq", $data);
                            }
                        // tagihan sesuai tipe
                    // tagihan
                }
                // pembayaran
                    // $id_pembayaran = $this->Main_model->get_last_id_pembayaran();
                    if($this->input->post("tgl") < "2020-10-01"){
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal menambahkan transaksi, tanggal yang Anda masukkan salah<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $bulan = date("m", strtotime($this->input->post("tgl")));
                        $tahun = date("Y", strtotime($this->input->post("tgl")));
                        $id = $this->Main_model->get_last_id("pembayaran", "id_pembayaran", "MONTH(tgl_pembayaran) = '$bulan' AND YEAR(tgl_pembayaran) = '$tahun'");
                        $id = substr($id['id_pembayaran'], -3) + 1;
                        
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
                            "nama_pembayaran" => $this->input->post("nama"),
                            "uraian" => $this->input->post('uraian', TRUE),
                            "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                            "metode" => $metode,
                            "tgl_pembayaran" => $this->input->post("tgl"),
                            "keterangan" => $this->input->post("keterangan", TRUE),
                            "pengajar" => $this->input->post("pengajar", TRUE)
                        ];
                        $this->Main_model->add_data("pembayaran", $data);
                    }

                    // pembayaran sesuai tipe
                        if($tipe == "peserta"){
                            $data = [
                                "id_pembayaran" => $id_pembayaran,
                                "id_peserta" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("pembayaran_peserta", $data);
                        } else  if($tipe == "kelas"){
                            $data = [
                                "id_pembayaran" => $id_pembayaran,
                                "id_kelas" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("pembayaran_kelas", $data);
                        } else if($tipe == "kpq"){
                            $data = [
                                "id_pembayaran" => $id_pembayaran,
                                "nip" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("pembayaran_kpq", $data);
                        }
                    // pembayaran sesuai tipe
                // pembayaran
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil melakukan transaksi langsung dengan metode <b>cash</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else if($metode == "Transfer"){
                // saat pembayaran cash insert tagihan yang berstatus lunas dan transfer
                // tagihan
                    // $id_tagihan = $this->Main_model->get_last_id_tagihan();
                    $id_tagihan = $this->Main_model->get_last_id("tagihan", "id_tagihan");
                    $id_tagihan = $id_tagihan['id_tagihan'] + 1;

                    $data = [
                        "id_tagihan" => $id_tagihan,
                        "tgl_tagihan" => $this->input->post("tgl"),
                        "nama_tagihan" => $this->input->post("nama"),
                        "uraian" => $this->input->post("uraian"),
                        "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                        "status" => "lunas"
                    ];
                    $this->Main_model->add_data("tagihan", $data);
                    
                    // tagihan sesuai tipe
                        if($tipe == "peserta"){
                            $data = [
                                "id_tagihan" => $id_tagihan,
                                "id_peserta" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("tagihan_peserta", $data);
                        } else  if($tipe == "kelas"){
                            $data = [
                                "id_tagihan" => $id_tagihan,
                                "id_kelas" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("tagihan_kelas", $data);
                        } else if($tipe == "kpq"){
                            $data = [
                                "id_tagihan" => $id_tagihan,
                                "nip" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("tagihan_kpq", $data);
                        }
                    // tagihan sesuai tipe
                // tagihan
                // transfer
                    $id = $this->KartuPiutang_model->get_last_id_transfer();
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

                    $data = [
                        "id_transfer" => $id_transfer,
                        "tgl_transfer" => $this->input->post("tgl"),
                        "nama_transfer" => $this->input->post("nama"),
                        "pengajar" => $this->input->post("pengajar"),
                        "uraian" => $this->input->post("uraian"),
                        "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                        "keterangan" => $this->input->post("keterangan"),
                        "metode" => $this->input->post("metode"),
                        "alamat" => ''
                    ];
                    $this->Main_model->add_data("transfer", $data);
                    // transfer sesuai tipe
                        if($tipe == "peserta"){
                            $data = [
                                "id_transfer" => $id_transfer,
                                "id_peserta" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("transfer_peserta", $data);
                        } else  if($tipe == "kelas"){
                            $data = [
                                "id_transfer" => $id_transfer,
                                "id_kelas" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("transfer_kelas", $data);
                        } else if($tipe == "kpq"){
                            $data = [
                                "id_transfer" => $id_transfer,
                                "nip" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("transfer_kpq", $data);
                        }
                    // transfer sesuai tipe
                // transfer
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil melakukan transaksi langsung dengan metode <b>transfer</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
            redirect($_SERVER['HTTP_REFERER']);
        }

        public function add_piutang(){
            $tipe = $this->input->post("tipe");
            // tagihan
                $id_tagihan = $this->Main_model->get_last_id("tagihan", "id_tagihan");
                $id_tagihan = $id_tagihan['id_tagihan'] + 1;
                $data = [
                    "id_tagihan" => $id_tagihan,
                    "tgl_tagihan" => $this->input->post("tgl"),
                    "nama_tagihan" => $this->input->post("nama"),
                    "uraian" => $this->input->post("uraian"),
                    "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                    "status" => "piutang"
                ];
                $this->Main_model->add_data("tagihan", $data);
                // tagihan sesuai tipe
                    if($tipe == "peserta"){
                        $data = [
                            "id_tagihan" => $id_tagihan,
                            "id_peserta" => $this->input->post("id", TRUE)
                        ];
                        $this->Main_model->add_data("tagihan_peserta", $data);
                    } else  if($tipe == "kelas"){
                        $data = [
                            "id_tagihan" => $id_tagihan,
                            "id_kelas" => $this->input->post("id", TRUE)
                        ];
                        $this->Main_model->add_data("tagihan_kelas", $data);
                    } else if($tipe == "kpq"){
                        $data = [
                            "id_tagihan" => $id_tagihan,
                            "nip" => $this->input->post("id", TRUE)
                        ];
                        $this->Main_model->add_data("tagihan_kpq", $data);
                    }
                // tagihan sesuai tipe
            // tagihan
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil menambahkan piutang<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }

        public function add_pembayaran(){
            $tipe = $this->input->post("tipe");
            $id = $this->input->post("id");
            $pengajar = $this->input->post("pengajar");
            $nama = $this->input->post("nama");
            $metode = $this->input->post("metode");
            if($metode == "Cash"){
                $bulan = date("m", strtotime($this->input->post("tgl")));
                $tahun = date("Y", strtotime($this->input->post("tgl")));
                $id = $this->Main_model->get_last_id("pembayaran", "id_pembayaran", "MONTH(tgl_pembayaran) = '$bulan' AND YEAR(tgl_pembayaran) = '$tahun'");
                $id = substr($id['id_pembayaran'], -3) + 1;
                
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
                    "nama_pembayaran" => $this->input->post("nama"),
                    "uraian" => $this->input->post('uraian', TRUE),
                    "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                    "metode" => $metode,
                    "tgl_pembayaran" => $this->input->post("tgl"),
                    "keterangan" => $this->input->post("keterangan", TRUE),
                    "pengajar" => $this->input->post("pengajar", TRUE)
                ];
                $this->Main_model->add_data("pembayaran", $data);

                // pembayaran
                    // $id_pembayaran = $this->Main_model->get_last_id_pembayaran();
                    // $id_pembayaran = $this->Main_model->get_last_id("pembayaran", "id_pembayaran");
                    // $id_pembayaran = $id_pembayaran['id_pembayaran'] + 1;
                    // $data = [
                    //     "id_pembayaran" => $id_pembayaran,
                    //     "nama_pembayaran" => $this->input->post("nama"),
                    //     "uraian" => $this->input->post('uraian', TRUE),
                    //     "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                    //     "metode" => $metode,
                    //     "tgl_pembayaran" => $this->input->post("tgl"),
                    //     "keterangan" => $this->input->post("keterangan", TRUE),
                    //     "pengajar" => $this->input->post("pengajar", TRUE)
                    // ];
                    // $this->Main_model->add_data("pembayaran", $data);

                    // pembayaran sesuai tipe
                        if($tipe == "peserta"){
                            $data = [
                                "id_pembayaran" => $id_pembayaran,
                                "id_peserta" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("pembayaran_peserta", $data);
                        } else  if($tipe == "kelas"){
                            $data = [
                                "id_pembayaran" => $id_pembayaran,
                                "id_kelas" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("pembayaran_kelas", $data);
                        } else if($tipe == "kpq"){
                            $data = [
                                "id_pembayaran" => $id_pembayaran,
                                "nip" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("pembayaran_kpq", $data);
                        }
                    // pembayaran sesuai tipe
                // pembayaran
                
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil melakukan pembayaran dengan metode <b>cash</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else if($metode == "Transfer"){
                // transfer
                    $id = $this->KartuPiutang_model->get_last_id_transfer();
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

                    $data = [
                        "id_transfer" => $id_transfer,
                        "tgl_transfer" => $this->input->post("tgl"),
                        "nama_transfer" => $this->input->post("nama"),
                        "pengajar" => $this->input->post("pengajar"),
                        "uraian" => $this->input->post("uraian"),
                        "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                        "keterangan" => $this->input->post("keterangan"),
                        "metode" => $this->input->post("metode"),
                        "alamat" => ''
                    ];
                    $this->Main_model->add_data("transfer", $data);
                    // transfer sesuai tipe
                        if($tipe == "peserta"){
                            $data = [
                                "id_transfer" => $id_transfer,
                                "id_peserta" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("transfer_peserta", $data);
                        } else  if($tipe == "kelas"){
                            $data = [
                                "id_transfer" => $id_transfer,
                                "id_kelas" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("transfer_kelas", $data);
                        } else if($tipe == "kpq"){
                            $data = [
                                "id_transfer" => $id_transfer,
                                "nip" => $this->input->post("id", TRUE)
                            ];
                            $this->Main_model->add_data("transfer_kpq", $data);
                        }
                    // transfer sesuai tipe
                // transfer
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil melakukan pembayaran dengan metode <b>transfer</b><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    // add
    
    // edit
        public function edit_status_piutang($id, $status){
            $result = $this->Main_model->edit_data("tagihan", ["MD5(id_tagihan)" => $id], ["status" => $status]);
            if($result)
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil merubah status piutang<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            else
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal merubah status piutang<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    // edit

    // edit
        public function edit_tagihan(){
                // $this->KartuPiutang_model->edit_tagihan();
                $id = $this->input->post("id");
                $data = [
                    "nama_tagihan" => $this->input->post("nama", TRUE),
                    "tgl_tagihan" => $this->input->post("tgl"),
                    "uraian" => $this->input->post("uraian"),
                    "nominal" => $this->Main_model->nominal($this->input->post("nominal"))
                ];
                $result = $this->Main_model->edit_data("tagihan", ["id_tagihan" => $id], $data);
                // $this->db->where("id_tagihan", $this->input->post("id"));
                // $this->db->update("tagihan", $data);

            if($result)
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            else
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
            // $this->Keuangan_model->edit_tagihan();
            // redirect($_SERVER['HTTP_REFERER']);
        }

        public function edit_pembayaran_cash(){
            // $this->Keuangan_model->edit_pembayaran_cash();
            // redirect($_SERVER['HTTP_REFERER']);

            // $this->KartuPiutang_model->edit_pembayaran_cash();
            $id = $this->input->post("id");
            $data = [
                "nama_pembayaran" => $this->input->post("nama", TRUE),
                "tgl_pembayaran" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->Main_model->nominal($this->input->post("nominal"))
            ];
            $result = $this->Main_model->edit_data("pembayaran", ["id_pembayaran" => $id], $data);
            // $this->db->where("id_pembayaran", $this->input->post("id"));
            // $this->db->update("pembayaran", $data);

            if($result)
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            else
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }

        public function edit_pembayaran_transfer(){
            // $this->Keuangan_model->edit_pembayaran_transfer();
            // redirect($_SERVER['HTTP_REFERER']);
            $id_transfer = $this->input->post("id");
            $data = [
                "nama_transfer" => $this->input->post("nama", TRUE),
                "tgl_transfer" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->Main_model->nominal($this->input->post("nominal")),
                "alamat" => $this->input->post("alamat")
            ];
            
            $result = $this->Main_model->edit_data("transfer", ["id_transfer" => $id_transfer], $data);
            if($result)
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            else
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }

        public function edit_deposit(){
            // $this->Keuangan_model->edit_deposit();
            // redirect($_SERVER['HTTP_REFERER']);
            $id_deposit = $this->input->post("id");
            $data = [
                "nama_deposit" => $this->input->post("nama", TRUE),
                "tgl_deposit" => $this->input->post("tgl"),
                "uraian" => $this->input->post("uraian"),
                "nominal" => $this->Main_model->nominal($this->input->post("nominal"))
            ];
            
            $result = $this->Main_model->edit_data("deposit", ["id_deposit" => $id_deposit], $data);
            if($result)
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Berhasil merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            else
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal merubah data transaksi<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    // edit
    
    // get data for ajax
        public function get_data_tagihan(){
            $id = $this->input->post("id");
            $data = $this->Main_model->get_one("tagihan", ["id_tagihan" => $id]);
            echo json_encode($data);
            // $data = $this->Keuangan_model->get_data_tagihan();
            // echo json_encode($data);
        }
        
        public function get_data_tagihan_kelas(){
            $data = $this->Keuangan_model->get_data_tagihan_kelas();
            echo json_encode($data);
        }

        public function get_data_pembayaran(){
            $id = $this->input->post("id");
            $data = $this->Main_model->get_one("pembayaran", ["id_pembayaran" => $id]);
            echo json_encode($data);
            // $id = $this->input->post("id");
            // $data = $this->Keuangan_model->get_data_pembayaran($id);
            // echo json_encode($data);
        }

        public function get_data_pembayaran_transfer(){
            $id = $this->input->post("id");
            $data = $this->Main_model->get_one("transfer", ["id_transfer" => $id]);
            echo json_encode($data);
            // $id = $this->input->post("id");
            // $data = $this->Keuangan_model->get_data_pembayaran_transfer($id);
            // echo json_encode($data);
        }

        public function get_data_deposit(){
            $id = $this->input->post("id");
            $data = $this->Main_model->get_one("deposit", ["id_deposit" => $id]);
            echo json_encode($data);
            // $id = $this->input->post("id");
            // $data = $this->Keuangan_model->get_data_deposit($id);
            // echo json_encode($data);
        }

        public function get_data_invoice(){
            $id = $this->input->post("id");
            $data = $this->Main_model->get_one("invoice", ["id_invoice" => $id]);
            echo json_encode($data);
            // $id = $this->input->post("id");
            // $data = $this->Keuangan_model->get_data_invoice($id);
            // echo json_encode($data);
        }

        public function get_data_uraian_invoice(){
            $id = $this->input->post("id");
            // $data = $this->Keuangan_model->get_data_uraian_invoice($id);
            $data = $this->Main_model->get_all("invoice_uraian", ["id_invoice" => $id]);
            echo json_encode($data);
        }
    // get data for ajax
}
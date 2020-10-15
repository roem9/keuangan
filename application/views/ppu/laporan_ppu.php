<?php
    function rupiah($angka){
            
        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="d-flex justify-content-begin mt-3">
                    <h1 class="h3 mb-0 text-gray-800 mr-3"><?= $title?></h1>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-dark" style="font-size: 12px" border=1>
                    <thead class="thead-light">
                        <tr>
                            <th rowspan=2>No</th>
                            <th rowspan=2>Tanggal</th>
                            <th rowspan=2>Nama</th>
                            <th rowspan=2>No. Kuitansi</th>
                            <th rowspan=2>Infaq</th>
                            <th rowspan=2>Waqaf</th>
                            <th rowspan=2>Al-Quran</th>
                            <th rowspan=2>Zakat</th>
                            <th rowspan=2>Ambulance</th>
                            <th rowspan=2>P2J</th>
                            <th colspan=2>Lainnya</th>
                            <th rowspan=2>Keterangan</th>
                        </tr>
                        <tr>
                            <th>ket</th>
                            <th>nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach ($transaksi as $data) :?>

                            <tr>
                                <td><?= $no++?></td>
                                <td><?= $data['tgl']?></td>
                                <td><?= $data['nama']?></td>
                                <td><?= $data['id']?></td>
                                <?php if($data['jenis'] == "Infaq") :?>
                                    <td><?= rupiah($data['nominal'])?></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                <?php elseif ($data['jenis'] == "Waqaf") :?>
                                    <td></td><td><?= rupiah($data['nominal'])?></td>
                                    <td></td><td></td><td></td><td></td><td></td><td></td>
                                <?php elseif ($data['jenis'] == "Al-Quran") :?>
                                    <td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                    <td></td><td></td><td></td><td></td><td></td>
                                <?php elseif ($data['jenis'] == "Zakat") :?>
                                    <td></td><td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                    <td></td><td></td><td></td><td></td>
                                <?php elseif ($data['jenis'] == "Ambulance") :?>
                                    <td></td><td></td><td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                    <td></td><td></td><td></td>
                                <?php elseif ($data['jenis'] == "P2J") :?>
                                    <td></td><td></td><td></td><td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                    <td></td><td></td>
                                <?php else :?>
                                    <td></td><td></td><td></td><td></td><td></td><td></td><td><?= $data['jenis']?></td><td><?= rupiah($data['nominal'])?></td>
                                <?php endif;?>
                                <td><?= $data['keterangan']?></td>
                            </tr>

                        <?php
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
                            <th rowspan=2>No. Kuitansi</th>
                            <th rowspan=2>Nama</th>
                            <th rowspan=2>Ambulance</th>
                            <th rowspan=2>Infaq</th>
                            <th rowspan=2>P2J</th>
                            <th rowspan=2>Waqaf Al-Quran</th>
                            <th rowspan=2>Waqaf Gedung</th>
                            <th rowspan=2>Zakat</th>
                            <th colspan=2>Lainnya</th>
                            <th rowspan=2>Keterangan</th>
                            <th rowspan=2>Total</th>
                        </tr>
                        <tr>
                            <th>ket</th>
                            <th>nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total = ["ambulance" => 0, "infaq" => 0, "p2j" => 0, "waqaf_al_quran" => 0, "waqaf_gedung" => 0, "zakat" => 0, "lainnya" => 0];
                            $no = 1;
                            foreach ($tgl as $tgl) :
                                $subtotal = ["ambulance" => 0, "infaq" => 0, "p2j" => 0, "waqaf_al_quran" => 0, "waqaf_gedung" => 0, "zakat" => 0, "lainnya" => 0];
                                foreach ($transaksi as $data) :   
                                    if($data['tgl'] == $tgl) :
                        ?>
                                        <tr>
                                            <td><?= $no++?></td>
                                            <td><?= $data['tgl']?></td>
                                            <td><?= $data['id']?></td>
                                            <td><?= $data['nama']?></td>
                                            <?php if ($data['jenis'] == "Ambulance") :
                                                $subtotal['ambulance'] += $data['nominal'];
                                            ?>
                                                <td><?= rupiah($data['nominal'])?></td>
                                                <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                            <?php elseif($data['jenis'] == "Infaq") :
                                                $subtotal['infaq'] += $data['nominal'];
                                            ?>
                                                <td></td><td><?= rupiah($data['nominal'])?></td>
                                                <td></td><td></td><td></td><td></td><td></td><td></td>
                                            <?php elseif ($data['jenis'] == "P2J") :
                                                $subtotal['p2j'] += $data['nominal'];
                                            ?>
                                                <td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                                <td></td><td></td><td></td><td></td><td></td>
                                            <?php elseif ($data['jenis'] == "Waqaf Al-Quran") :
                                                $subtotal['waqaf_al_quran'] += $data['nominal'];
                                            ?>
                                                <td></td><td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                                <td></td><td></td><td></td><td></td>
                                            <?php elseif ($data['jenis'] == "Waqaf Gedung") :
                                                $subtotal['waqaf_gedung'] += $data['nominal'];
                                            ?>
                                                <td></td><td></td><td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                                <td></td><td></td><td></td>
                                            <?php elseif ($data['jenis'] == "Zakat") :
                                                $subtotal['zakat'] += $data['nominal'];
                                            ?>
                                                <td></td><td></td><td></td><td></td><td></td><td><?= rupiah($data['nominal'])?></td>
                                                <td></td><td></td>
                                            <?php else :
                                                $subtotal['lainnya'] += $data['nominal'];
                                            ?>
                                                <td></td><td></td><td></td><td></td><td></td><td></td><td><?= $data['jenis']?></td><td><?= rupiah($data['nominal'])?></td>
                                            <?php endif;?>
                                            <td><?= $data['keterangan']?></td>
                                        </tr>
                        <?php
                                    endif;
                                endforeach;?>
                                <tr style="background-color: yellow">
                                    <td colspan="4">Subtotal</td>
                                    <?php $total['ambulance'] += $subtotal['ambulance']?>
                                    <td><?= rupiah($subtotal['ambulance'])?></td>
                                    <?php $total['infaq'] += $subtotal['infaq']?>
                                    <td><?= rupiah($subtotal['infaq'])?></td>
                                    <?php $total['p2j'] += $subtotal['p2j']?>
                                    <td><?= rupiah($subtotal['p2j'])?></td>
                                    <?php $total['waqaf_al_quran'] += $subtotal['waqaf_al_quran']?>
                                    <td><?= rupiah($subtotal['waqaf_al_quran'])?></td>
                                    <?php $total['waqaf_gedung'] += $subtotal['waqaf_gedung']?>
                                    <td><?= rupiah($subtotal['waqaf_gedung'])?></td>
                                    <?php $total['zakat'] += $subtotal['zakat']?>
                                    <td><?= rupiah($subtotal['zakat'])?></td>
                                    <td></td>
                                    <?php $total['lainnya'] += $subtotal['lainnya']?>
                                    <td><?= rupiah($subtotal['lainnya'])?></td>
                                    <td></td>
                                    <td><?= rupiah($subtotal['ambulance'] + $subtotal['infaq'] + $subtotal['p2j'] + $subtotal['waqaf_al_quran'] + $subtotal['waqaf_gedung'] + $subtotal['zakat'] + $subtotal['lainnya'])?></td>
                                </tr>
                        <?php
                            endforeach;
                        ?>
                        <tr style="background-color: red">
                            <td colspan="4">Total</td>
                            <td><?= rupiah($total['ambulance'])?></td>
                            <td><?= rupiah($total['infaq'])?></td>
                            <td><?= rupiah($total['p2j'])?></td>
                            <td><?= rupiah($total['waqaf_al_quran'])?></td>
                            <td><?= rupiah($total['waqaf_gedung'])?></td>
                            <td><?= rupiah($total['zakat'])?></td>
                            <td></td>
                            <td><?= rupiah($total['lainnya'])?></td>
                            <td></td>
                            <td><?= rupiah($total['ambulance'] + $total['infaq'] + $total['p2j'] + $total['waqaf_al_quran'] + $total['waqaf_gedung'] + $total['zakat'] + $total['lainnya'])?></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
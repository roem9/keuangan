<?php
    $bulan = ["1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"];
?>

<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        
        <!-- Page Heading -->
        <div class="row ml-2 mb-3">
            <h1 class="h3 mb-0 text-gray-800 mt-3"><?= $header?></h1>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                            <a href="#" class='nav-link' id="btn-1"><i class="fas fa-book"></i></a>
                            </li>
                            <li class="nav-item">
                            <a href="#" class='nav-link' id="btn-2"><i class="fas fa-user"></i></a>
                            </li>
                            <li class="nav-item">
                            <a href="#" class='nav-link' id="btn-3"><i class="fas fa-clock"></i></a>
                            </li>
                            <li class="nav-item">
                            <a href="#" class='nav-link' id="btn-4">KBM</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body cus-font">
                        <ul class="list-group" id="data-btn-1">
                            <li class="list-group-item list-group-item-info">Data Akademik</li>
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                Status
                                </div>
                                <div class="col-6" id="status"> 
                                    <?= $kelas['status']?>
                                </div>
                            </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                Tipe Kelas
                                </div>
                                <div class="col-6" id="status"> 
                                    <?= $kelas['tipe_kelas']?>
                                </div>
                            </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                Program
                                </div>
                                <div class="col-6" id="program"> 
                                    <?= $kelas['program']?>
                                </div>
                            </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                Koordinator
                                </div>
                                <div class="col-6" id="koordinator"> 
                                    <?= $kelas['nama_peserta']?>
                                </div>
                            </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                Pengajar
                                </div>
                                <div class="col-6" id="kpq"> 
                                    <?= $kelas['nama_kpq']?>
                                </div>
                            </div>
                            </li>
                            <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                Tipe Pengajar
                                </div>
                                <div class="col-6" id="pengajar"> 
                                    <?= $kelas['pengajar']?>
                                </div>
                            </div>
                            </li>
                        </ul>

                        <ul class="list-group" id="data-btn-2">
                            <li class="list-group-item list-group-item-info">List Peserta <span class="badge badge-danger badge-pill" id="totalPeserta"><?= COUNT($peserta)?></span></li>
                            <?php foreach ($peserta as $peserta) :?>
                                <li class="list-group-item"><?= $peserta['nama_peserta']?></li>
                            <?php endforeach;?>
                        </ul>
                        
                        <div id="data-btn-3">
                            <div class="table-responsive">
                                <table class="table-sm w-100" border=1>
                                    <thead>
                                    <tr>
                                        <th colspan=3><center><b>List Jadwal</b></center></th>
                                    </tr>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th>Jadwal</th>
                                        <th><center>OT</center></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $no = 0;
                                            foreach ($jadwal as $jadwal) :?>
                                                <tr>
                                                    <td><center><?= ++$no?></center></td>
                                                    <td><?=$jadwal['tempat'] . " (" . $jadwal['hari'] . " " . $jadwal['jam'] . ")"?></td>
                                                    <td><center><?= $jadwal['ot']?></center></td>
                                                </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="data-btn-4">
                            
                            <div class="table-responsive">
                                <table class="table-sm w-100" border=1>
                                    <thead>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center>Periode</center></th>
                                        <th><center>KBM</center></th>
                                        <?php 
                                            $no = 0;
                                            foreach ($kbm['kbm'] as $kbm) :?>
                                            <tr>
                                                <td><center><?= ++$no?></center></td>
                                                <td><?= $bulan[$kbm['bulan']] . " " . $kbm['tahun'] ?></td>
                                                <td><center><?= $kbm['kbm']?></center></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#" class='nav-link active' id="btn-kartu-1">Kartu Piutang</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class='nav-link' id="btn-kartu-2">Invoice</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class='nav-link bg-success text-light modalTransaksi' data-toggle="modal" data-target="#modalTransaksi" data-id="<?= $id?>">Transaksi</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class='nav-link bg-danger text-light modalTambahInvoice' data-toggle="modal" data-target="#modal_tambah_invoice" data-id="<?= $id?>">Invoice</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div id="data-btn-kartu-1">
                            <h5>Saldo : <?= rupiah($total)?></h5>
                            <table class="table table-sm cus-font">
                                <thead>
                                    <th><center>No</center></th>
                                    <!-- <th>Tagihan</th> -->
                                    <th>Tgl</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Print</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($detail as $detail) :?>
                                        <tr>
                                            <td><?= ++$no?></td>
                                            <td><?= date("d-M-Y", strtotime($detail['tgl']))?></td>
                                                <?php if($detail['status'] == 'tagihan'):?>
                                                    
                                                    <td><?= $detail['uraian']?></td>
                                                    <td><?= rupiah($detail['nominal'])?></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <?php
                                                        $color = $detail['ket'] == "piutang" ? $color = "danger" : $color = "success";
                                                    ?>
                                                    <td><a href="#modal_edit_status_tagihan" data-id="<?= $detail['id_tagihan']?>|<?=$detail['ket']?>" data-toggle="modal" class="badge badge-<?= $color?> modal_edit_status_tagihan"><?= $detail['ket']?></a></td>
                                                    <td><a href="#" class="badge badge-success modalEditTagihan" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id_tagihan']?>">edit</a></td>
                                                    <td>-</td>

                                                <?php elseif($detail['status'] == 'deposit') : ?>

                                                    <td><?= $detail['uraian']?></td>
                                                    <td><?= rupiah($detail['nominal'])?></td>
                                                    <td>-</td>
                                                    <td><center><?=$detail['metode']?></center></td>
                                                    <td>-</td>
                                                    <td><a href="#" class="badge badge-success modalEditDeposit" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id_deposit']?>">edit</a></td>
                                                    <td>-</td>                                                

                                                <?php elseif($detail['status'] == 'cash') :?>
                                                    
                                                    <td><?= $detail['uraian']?></td>
                                                    <td>-</td>
                                                    <td><?= rupiah($detail['nominal'])?></td>
                                                    <td><center><?=$detail['metode']?></center></td>
                                                    <td>-</td>
                                                    <td><a href="#" class="badge badge-success modalEditCash" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id_pembayaran']?>">edit</a></td>
                                                    <td><a href="<?=base_url()?>kartupiutang/kwitansi/<?= $detail['id_pembayaran']?>" target=_blank><center><i class="fa fa-print"></i></center></a></td>

                                                <?php elseif($detail['status'] == 'transfer') :?>
                                                    
                                                    <td><?= $detail['uraian']?></td>
                                                    <td>-</td>
                                                    <td><?= rupiah($detail['nominal'])?></td>
                                                    <td><center><?=$detail['metode']?></center></td>
                                                    <td>-</td>
                                                    <td><a href="#" class="badge badge-success modalEditTransfer" data-toggle="modal" data-target="#modal_edit" data-id="<?= $detail['id_transfer']?>">edit</a></td>
                                                    <td><a href="<?=base_url()?>kartupiutang/kwitansi_transfer/<?= $detail['id_transfer']?>" target=_blank><center><i class="fa fa-print"></i></center></a></td>

                                                <?php endif;?>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                        <div id="data-btn-kartu-2">
                            <table class="table table-sm cus-font w-75">
                                <thead>
                                    <td>No</td>
                                    <td>Tgl Tagihan</td>
                                    <td>No Tagihan</td>
                                    <td>Edit</td>
                                    <td>Print</td>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 0;
                                        foreach ($invoice as $invoice) :?>
                                        <tr>
                                            <td><?= ++$no?></td>
                                            <td><?= date("d-m-Y", strtotime($invoice['tgl_invoice']))?></td>
                                            <td><?= substr($invoice['id_invoice'],0, 3)?>/Tag-Im/<?= date('n', strtotime($invoice['tgl_invoice']))?>/<?= date('Y', strtotime($invoice['tgl_invoice']))?></a></td>
                                            
                                            <td><a href="#" data-target="#modal_edit_invoice" data-id="<?=$invoice['id_invoice']?>" data-toggle="modal" class="badge badge-success modalEditInvoice">edit</a></td>
                                            
                                            <td><center><a target="_blank" href="<?= base_url()?>kartupiutang/invoice/<?=$invoice['id_invoice']?>"><i class="fa fa-print"></i></a></center></td>
                                        </tr>

                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
</div>

<script>
    $("#piutang").addClass("active")
    $("#btn-1").removeClass('active');
    $("#btn-2").removeClass('active');
    $("#btn-3").removeClass('active');
    $("#btn-4").addClass('active');
    $("#data-btn-1").hide();
    $("#data-btn-2").hide();
    $("#data-btn-3").hide();
    $("#data-btn-4").show();

    $("#btn-1").click(function(){
        const id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url : "<?=base_url()?>kelas/datakelasbyid",
            method : "POST",
            data : {id_kelas : id},
            async : true,
            dataType : 'json',
            success : function(data){
                $("#status").html(data.status);
                $("#program").html(data.program);
                $("#koordinator").html(data.nama_peserta);
                $("#kpq").html(data.nama_kpq);
                $("#pengajar").html(data.pengajar);
            }
        })

        $("#btn-1").addClass('active');
        $("#btn-2").removeClass('active');
        $("#btn-3").removeClass('active');
        $("#btn-4").removeClass('active');
        $("#data-btn-1").show();
        $("#data-btn-2").hide(); 
        $("#data-btn-3").hide();
        $("#data-btn-4").hide();
    })
    
    $("#btn-2").click(function(){
        const id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url : "<?=base_url()?>kelas/datapesertabyid",
            method : "POST",
            data : {id_kelas : id},
            async : true,
            dataType : 'json',
            success : function(data){
                // console.log(data)
                $('#totalPeserta').html(data.length);
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<li class="list-group-item">'+data[i].nama_peserta+'</li>';
                }
                $('#list-peserta').html(html);
            }
        })

        $("#btn-1").removeClass('active');
        $("#btn-2").addClass('active');
        $("#btn-3").removeClass('active');
        $("#btn-4").removeClass('active');
        $("#data-btn-1").hide();
        $("#data-btn-2").show(); 
        $("#data-btn-3").hide();
        $("#data-btn-4").hide();
    })

    $("#btn-3").click(function(){
        const id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url : "<?=base_url()?>kelas/datajadwalbyid",
            method : "POST",
            data : {id_kelas : id},
            async : true,
            dataType : 'json',
            success : function(data){
                // console.log(data)
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<li class="list-group-item">'+data[i].tempat+' ('+data[i].hari+' '+data[i].jam+')</li>';
                }
                $('#list-jadwal').html(html);
            }
        })

        $("#btn-1").removeClass('active');
        $("#btn-2").removeClass('active');
        $("#btn-3").addClass('active');
        $("#btn-4").removeClass('active');
        $("#data-btn-1").hide();
        $("#data-btn-2").hide(); 
        $("#data-btn-3").show();
        $("#data-btn-4").hide();
    })
    
    $("#btn-4").click(function(){

        $("#btn-1").removeClass('active');
        $("#btn-2").removeClass('active');
        $("#btn-3").removeClass('active');
        $("#btn-4").addClass('active');
        $("#data-btn-1").hide();
        $("#data-btn-2").hide(); 
        $("#data-btn-3").hide();
        $("#data-btn-4").show();
    })

    $("#dataTable").DataTable({
        paging: false,
        searching: false
    })
    
    $(".modalEditTagihan").click(function(){
        $("#modal-edit").html("Edit Tagihan");
        let id = $(this).data("id");
        $("#form-edit").attr("action", "<?= base_url()?>kartupiutang/edit_tagihan")
        $("#edit_alamat").attr("readonly", "readonly");
        $("#edit_alamat").val("");

        $.ajax ({
            url : "<?=base_url()?>kartupiutang/get_data_tagihan",
            method : "POST",
            data : {id: id},
            async : true,
            dataType : 'json',
            success : function(data){
                $("#transaksi").val("tagihan");
                $("#id").val(data.id_tagihan);
                $("#nama").val(data.nama_tagihan);
                $("#tgl_transaksi").val(data.tgl_tagihan);
                $("#keterangan").val(data.uraian);
                $("#nominal_uang").val(data.nominal);
            }
        })
    })
    
    $(".modalEditCash").click(function(){
        $("#modal-edit").html("Edit Pembayaran");
        let id = $(this).data("id");
        $("#form-edit").attr("action", "<?=base_url()?>kartupiutang/edit_pembayaran_cash")
        $("#edit_alamat").attr("readonly", "readonly");
        $("#edit_alamat").val("");

        $.ajax ({
            url : "<?=base_url()?>kartupiutang/get_data_pembayaran",
            method : "POST",
            data : {id: id},
            async : true,
            dataType : 'json',
            success : function(data){
                $("#transaksi").val("pembayaran");
                $("#id").val(data.id_pembayaran);
                $("#nama").val(data.nama_pembayaran);
                $("#tgl_transaksi").val(data.tgl_pembayaran);
                $("#keterangan").val(data.uraian);
                $("#nominal_uang").val(data.nominal);
            }
        })
    })
    
    $(".modalEditTransfer").click(function(){
        $("#modal-edit").html("Edit Pembayaran");
        let id = $(this).data("id");
        $("#form-edit").attr("action", "<?=base_url()?>kartupiutang/edit_pembayaran_transfer")
        $("#edit_alamat").removeAttr("readonly");

        $.ajax ({
            url : "<?=base_url()?>kartupiutang/get_data_pembayaran_transfer",
            method : "POST",
            data : {id: id},
            async : true,
            dataType : 'json',
            success : function(data){
                $("#transaksi").val("pembayaran");
                $("#edit_alamat").val(data.alamat);
                $("#id").val(data.id_transfer);
                $("#nama").val(data.nama_transfer);
                $("#tgl_transaksi").val(data.tgl_transfer);
                $("#keterangan").val(data.uraian);
                $("#nominal_uang").val(data.nominal);
            }
        })
    })
    
    $(".modalEditDeposit").click(function(){
        $("#modal-edit").html("Edit Pembayaran");
        let id = $(this).data("id");
        $("#form-edit").attr("action", "<?=base_url()?>kartupiutang/edit_deposit")
        $("#edit_alamat").attr("readonly", "readonly");
        $("#edit_alamat").val("");

        $.ajax ({
            url : "<?=base_url()?>kartupiutang/get_data_deposit",
            method : "POST",
            data : {id: id},
            async : true,
            dataType : 'json',
            success : function(data){
                $("#transaksi").val("pembayaran");
                $("#id").val(data.id_deposit);
                $("#nama").val(data.nama_deposit);
                $("#tgl_transaksi").val(data.tgl_deposit);
                $("#keterangan").val(data.uraian);
                $("#nominal_uang").val(data.nominal);
            }
        })
    })
    
    $(".modalTambahInvoice").click(function(){
        $("#modal-invoice").html("Tambah Invoice");
        $("#id_invoice").val($(this).data("id"));
        $("#tipe_invoice").val("kelas");
    })
    
    var x = 0;
    var urut = 1;
    $("#tambah_uraian").click(function(e){
        e.preventDefault();
        x++;
        urut++;
        $("#uraian").append(
            '<div class="form-group" id="u'+x+'">'+
                '<label for="uraian_invoice['+x+']">Uraian '+ urut +'</label>'+
                '<textarea name="uraian['+x+']" id="uraian_invoice['+x+']" rows="2" class="form-control form-control-sm"></textarea>'+
            '</div>'+
            '<div class="form-group" id="n'+x+'">'+
                '<label for="nominal_invoice['+x+']">Nominal '+ urut +'</label>'+
                '<input type="text" name="nominal['+x+']" id="nominal_invoice['+x+']" class="form-control form-control-sm">'+
            '</div>');
    })

    $("#hapus_uraian").click(function(e){
        e.preventDefault();
        $("#u"+x).remove();
        $("#n"+x).remove();
        x--;
        urut--;
    })

    $(".modalTransaksi").click(function(){
      $("#tipe_tagihan").val("kelas");
      $("#tipe_kwitansi").val("kelas");
      $("#tipe_deposit").val("kelas");
      const id = $(this).data('id');
      $.ajax({
            url : "<?=base_url()?>kartupiutang/getdatakelas",
            method : "POST",
            data : {id_kelas : id},
            async : true,
            dataType : 'json',
            success : function(data){
                $(".nama-title").html(data.nama_peserta);
                $("#pengajar_deposit").val(data.nama_kpq);
                $("#pengajar_kwitansi").val(data.nama_kpq);
                $("#id_kwitansi").val(data.id_kelas);
                $("#id_tagihan").val(data.id_kelas);
                $("#id_deposit").val(data.id_kelas);
                $("#nama_tagihan").val(data.nama_peserta);
                $("#nama_kwitansi").val(data.nama_peserta);
                $("#nama_deposit").val(data.nama_peserta);
            }
        })
    })
    
    $("#form-2").hide();
    $("#form-3").hide();
    $("#btn-form-1").addClass("active");

    $("#btn-form-1").click(function(){
      $("#form-1").show();
      $("#form-2").hide();
      $("#form-3").hide();

      $("#btn-form-1").addClass("active");
      $("#btn-form-2").removeClass("active");
      $("#btn-form-3").removeClass("active");
    })
    
    $("#btn-form-2").click(function(){
      $("#form-1").hide();
      $("#form-2").show();
      $("#form-3").hide();

      $("#btn-form-1").removeClass("active");
      $("#btn-form-2").addClass("active");
      $("#btn-form-3").removeClass("active");
    })
    
    $("#btn-form-3").click(function(){
      $("#form-1").hide();
      $("#form-2").hide();
      $("#form-3").show();

      $("#btn-form-1").removeClass("active");
      $("#btn-form-2").removeClass("active");
      $("#btn-form-3").addClass("active");
    })
    
    $("#data-btn-kartu-2").hide();

    $("#btn-kartu-1").click(function(){
      $("#data-btn-kartu-1").show();
      $("#data-btn-kartu-2").hide();

      $("#btn-kartu-1").addClass("active");
      $("#btn-kartu-2").removeClass("active");
    })
    
    $("#btn-kartu-2").click(function(){
      $("#data-btn-kartu-1").hide();
      $("#data-btn-kartu-2").show();

      $("#btn-kartu-1").removeClass("active");
      $("#btn-kartu-2").addClass("active");
    })

    // modal edit invoice
        $(".modalEditInvoice").click(function(){
            let id = $(this).data("id");
            $("#id-1").val(id);
            $("#id-2").val(id);
            $("#id-3").val(id);
            $("#id-4").val(id);

            $.ajax({
                url : "<?= base_url()?>kartupiutang/get_data_invoice",
                method : "POST",
                data : {id : id},
                async: true,
                dataType : "json",
                success : function(data){
                    $("#nama_invoice_edit").val(data.nama_invoice);
                    $("#tgl_invoice_edit").val(data.tgl_invoice);
                }
            })
            
            $.ajax({
                url : "<?= base_url()?>kartupiutang/get_data_uraian_invoice",
                method : "POST",
                data : {id : id},
                async: true,
                dataType : "json",
                success : function(data){
                    let html = "";
                    let html2 = "<table class='table'>";
                    let urut = 1;
                    for (let i = 0; i < data.length; i++) {
                        html += 
                        '<input type="hidden" name="id_uraian['+i+']" value="'+data[i].id_uraian+'">'+
                        '<div class="form-group">'+
                            '<label for="uraian">Uraian '+ urut +'</label>'+
                            '<input type="text" name="uraian['+i+']" id="uraian" class="form-control form-control-sm" value="'+data[i].uraian+'">'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label for="nominal">Nominal '+ urut +'</label>'+
                            '<input type="text" name="nominal['+i+']" id="nominal" class="form-control form-control-sm" value="'+data[i].nominal+'">'+
                        '</div>';

                        html2 +=
                                '<tr>'+
                                    '<td><input type="checkbox" name="uraian['+i+']" value="'+data[i].id_uraian+'"></td>'+
                                    '<td>'+data[i].uraian+'</td>'+
                                    '<td>'+data[i].nominal+'</td>'+
                                '</tr>';

                        urut++;
                    }

                    $("#data-uraian-edit").html(html);
                    $("#data-uraian-hapus").html(html2);
                }
            })
        })

        $("#data-invoice-2").hide();
        $("#data-invoice-3").hide();
        $("#data-invoice-4").hide();
        
        $("#aksi-1").val("doc");
        $("#aksi-2").val("edit");
        $("#aksi-3").val("tambah");
        $("#aksi-4").val("hapus");
        
        $("#btn-invoice-1").click(function(){
            $("#btn-invoice-1").addClass('active');
            $("#btn-invoice-2").removeClass('active');
            $("#btn-invoice-3").removeClass('active');
            $("#btn-invoice-4").removeClass('active');
            
            $("#data-invoice-1").show();
            $("#data-invoice-2").hide();
            $("#data-invoice-3").hide();
            $("#data-invoice-4").hide();
        })
        
        $("#btn-invoice-2").click(function(){
            $("#btn-invoice-1").removeClass('active');
            $("#btn-invoice-2").addClass('active');
            $("#btn-invoice-3").removeClass('active');
            $("#btn-invoice-4").removeClass('active');
            
            $("#data-invoice-1").hide();
            $("#data-invoice-2").show();
            $("#data-invoice-3").hide();
            $("#data-invoice-4").hide();
        })
        
        $("#btn-invoice-3").click(function(){
            $("#btn-invoice-1").removeClass('active');
            $("#btn-invoice-2").removeClass('active');
            $("#btn-invoice-3").addClass('active');
            $("#btn-invoice-4").removeClass('active');
            
            $("#data-invoice-1").hide();
            $("#data-invoice-2").hide();
            $("#data-invoice-3").show();
            $("#data-invoice-4").hide();
        })
        
        
        $("#btn-invoice-4").click(function(){
            $("#btn-invoice-1").removeClass('active');
            $("#btn-invoice-2").removeClass('active');
            $("#btn-invoice-3").removeClass('active');
            $("#btn-invoice-4").addClass('active');
            
            $("#data-invoice-1").hide();
            $("#data-invoice-2").hide();
            $("#data-invoice-3").hide();
            $("#data-invoice-4").show();
        })
    // modal invoice
    
    // validasi
        $("#nominal").keyup(function(){
            $("#nominal").val(formatRupiah(this.value, 'Rp. '))
        })

        $("#nominal_pembayaran").keyup(function(){
            $("#nominal_pembayaran").val(formatRupiah(this.value, 'Rp. '))
        })

        $("#nominal_piutang").keyup(function(){
            $("#nominal_piutang").val(formatRupiah(this.value, 'Rp. '))
        })

        $("#nominal_deposit").keyup(function(){
            $("#nominal_deposit").val(formatRupiah(this.value, 'Rp. '))
        })
    // validasi

    // submit
        $("#btn-submit-1, #btn-submit-2, #btn-submit-3, #btn-submit-4").click(function(){
        var c = confirm("Yakin akan menambahkan data?");
        return c;
        })

        $("#btn-submit-invoice-1, #btn-submit-invoice-2, #btn-submit-invoice-3, #btn-submit-invoice-4").click(function(){
            var c = confirm("Yakin akan mengubah invoice?");
            return c;
        })
</script>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">
            <div class="row ml-2 mb-3">
                <h1 class="h3 mb-0 text-gray-800 mt-3"><?= $header?></h1>
            </div>
            <div class="row">
                <?php if( $this->session->flashdata('pesan') ) : ?>
                    <div class="col-6">
                        <?= $this->session->flashdata('pesan');?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card" style="max-width: 900px">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a href="#" class='nav-link active'>Invoice</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class='nav-link bg-success text-light modalTambahInvoice' data-toggle="modal" data-target="#modal_tambah_invoice">Tambah Invoice</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm cus-font" id="dataTable">
                                <thead>
                                    <th width="7%"><center>No</center></th>
                                    <th width="12%"><center>Tgl</center></th>
                                    <th width="16%"><center>No. Inv</center></th>
                                    <th>Nama</th>
                                    <th width="16%">Total</th>
                                    <th width="5%">Print</th>
                                    <th width="10%">Edit</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                        foreach ($invoice as $invoice) : ?>
                                        <tr>
                                            <td><center><?= $no++?></center></td>
                                            <td><?= date("d-m-Y", strtotime($invoice['tgl_invoice']))?></td>
                                            <td><?= substr($invoice['id_invoice'],0, 3)?>/Tag-Im/<?= date('n', strtotime($invoice['tgl_invoice']))?>/<?= date('Y', strtotime($invoice['tgl_invoice']))?></a></td>
                                            <td><?= $invoice['nama_invoice']?></td>
                                            <td><?= rupiah($invoice['total'])?></td>
                                            <td><center><a target="_blank" href="<?= base_url()?>kartupiutang/invoice/<?=$invoice['id_invoice']?>"><i class="fa fa-print"></i></a></center></td>
                                            <td><center><a href="#" data-target="#modal_edit_invoice" data-id="<?=$invoice['id_invoice']?>" data-toggle="modal" class="btn btn-sm btn-info modalEditInvoice">edit</a></center></td>
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
</div>

<script>
    $("#lain").addClass("active")
                
    
    // tambah invoice
        $(".modalTambahInvoice").click(function(){
            $("#modal-invoice").html("Tambah Invoice");
            $("#tipe_invoice").val("other");
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
                '<div class="form-group" id="o'+x+'">'+
                    '<label for="satuan_invoice['+x+']">Satuan '+ urut +'</label>'+
                    '<input type="text" name="satuan[]" id="satuan_invoice['+x+']" class="form-control form-control-sm">'+
                '</div>'+
                '<div class="form-group" id="n'+x+'">'+
                    '<label for="nominal_invoice['+x+']">Nominal '+ urut +'</label>'+
                    '<input type="text" name="nominal['+x+']" id="nominal_invoice['+x+']" class="form-control form-control-sm">'+
                '</div>'
                );
        })

        $("#hapus_uraian").click(function(e){
            e.preventDefault();
            $("#u"+x).remove();
            $("#n"+x).remove();
            $("#o"+x).remove();
            x--;
            urut--;
        })
    // tambah invoice

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
                        '<div class="form-group" id="o'+x+'">'+
                            '<label for="satuan_invoice['+x+']">Satuan '+ urut +'</label>'+
                            '<input type="text" name="satuan['+i+']" id="satuan_invoice['+x+']" class="form-control form-control-sm" value="'+data[i].satuan+'">'+
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
    // modal eit invoice

    // validasi
        $("input[name='nominal']").keyup(function(){
            $(this).val(formatRupiah(this.value, 'Rp. '))
        })
    // validasi

    // submit
        $("#submitModalAddData").click(function(){
        var c = confirm("Yakin akan menambahkan transaksi?");
        return c;
        })

        $("#submitModalEditData").click(function(){
            var c = confirm("Yakin akan mengubah data transaksi?");
            return c;
        })
    // submit
</script>
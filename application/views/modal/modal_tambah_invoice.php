<div class="modal fade" id="modal_tambah_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-invoice">Tambah Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body cus-font">
        <form action="<?=base_url()?>kartupiutang/tambah_invoice" method="POST">
            <input type="hidden" name="id" id="id_invoice">
            <input type="hidden" name="tipe" id="tipe_invoice">
            <div class="form-group">
                <label for="nama_invoice">Nama Invoice</label>
                <input type="text" name="nama" id="nama_invoice" class="form-control form-control-sm" required>
            </div>
            <div class="form-group">
                <label for="tgl_invoice">Tgl Invoice</label>
                <input type="date" name="tgl" id="tgl_invoice" class="form-control form-control-sm" required>
            </div>
            <div id="uraian">
              <div class="form-group">
                  <label for="uraian_invoice[0]">Uraian 1</label>
                  <textarea name="uraian[]" id="uraian_invoice[0]" rows="2" class="form-control form-control-sm"></textarea>
              </div>
              <div class="form-group">
                  <label for="satuan_invoice[0]">Satuan 1</label>
                  <input type="text" name="satuan[]" id="satuan_invoice[0]" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                  <label for="nominal_invoice[0]">Nominal 1</label>
                  <input type="text" name="nominal[]" id="nominal_invoice[0]" class="form-control form-control-sm">
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <a href="#" class="btn btn-sm btn-danger mr-1" id="hapus_uraian">hapus</a>
              <a href="#" id="tambah_uraian" class="btn btn-sm btn-success" id="tambah_uraian">tambah</a>
            </div>
        </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success btn-sm" value="Tambah Invoice" id="btn-submit-4">
            </div>
      </form>
    </div>
  </div>
</div>
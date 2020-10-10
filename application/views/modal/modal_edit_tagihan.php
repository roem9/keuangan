<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-edit"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body cus-font">
        <form action="" method="POST" id="form-edit">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control form-control-sm">
          </div>
          <div class="form-group">
            <label for="tgl_transaksi">Tanggal</label>
            <input type="date" name="tgl" id="tgl_transaksi" class="form-control form-control-sm" readonly>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="uraian" id="keterangan" rows="2" class="form-control form-control-sm"></textarea>
          </div>
          <div class="form-group">
            <label for="nominal_uang">Nominal</label>
            <input type="text" name="nominal" id="nominal_uang" class="form-control form-control-sm">
          </div>
          <div class="form-group">
            <label for="edit_alamat">Alamat</label>
            <input type="text" name="alamat" id="edit_alamat" class="form-control form-control-sm" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-success btn-sm" value="Edit" id="submitModalEditData">
        </div>
      </form>
    </div>
  </div>
</div>
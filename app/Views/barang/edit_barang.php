<!-- /.Modal Tambah Barang -->
<div class="modal fade" id="modaledit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modaledit">Edit Data Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('barang/updatedata', ['class' => 'formbarang']); ?>
            <!-- /.untuk menjaga form kita dari kejahatan para hacker -->
            <?= csrf_field(); ?>
            <!---------------------------------------------------------->
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">(1) Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?= $kode_barang; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(2) Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="<?= $nama_barang; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(3) Satuan</label>
                        <input type="text" name="satuan" class="form-control" id="satuan" value="<?= $satuan; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(4) Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga" value="<?= $harga; ?>">
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php form_close() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $(document).ready(function() {
        $('.formbarang').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disabled');
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable');
                    $('.btnsimpan').html('Update');
                },
                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'berhasil',
                        text: response.sukses
                    })

                    $('#modaledit').modal('hide');
                    databarang();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;

        });
    });
</script>
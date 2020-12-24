<!-- /.Modal Tambah Barang -->
<div class="modal fade" id="modaltambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalbarang">Tambah Data Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('barang/simpandata', ['class' => 'formbarang']); ?>
            <!-- /.untuk menjaga form kita dari kejahatan para hacker -->
            <?= csrf_field(); ?>
            <!---------------------------------------------------------->
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">(1) Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang">
                        <div class="invalid-feedback errorkode_barang">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(1) Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang">
                        <div class="invalid-feedback errornama_barang">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(2) Satuan</label>
                        <input type="text" name="satuan" class="form-control" id="satuan">
                        <div class="invalid-feedback errorsatuan">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(3) Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga">
                        <div class="invalid-feedback errorharga">

                        </div>
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
                    $('.btnsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.kode_barang) {
                            $('#kode_barang').addClass('is-invalid');
                            $('.errorkode_barang').html(response.error.kode_barang);
                        } else {
                            $('#kode_barang').removeClass('is-invalid');
                            $('.errorkode_barang').html('');
                        }

                        if (response.error.nama_barang) {
                            $('#nama_barang').addClass('is-invalid');
                            $('.errornama_barang').html(response.error.nama_barang);
                        } else {
                            $('#nama_barang').removeClass('is-invalid');
                            $('.errornama_barang').html('');
                        }

                        if (response.error.satuan) {
                            $('#satuan').addClass('is-invalid');
                            $('.errorsatuan').html(response.error.satuan);
                        } else {
                            $('#satuan').removeClass('is-invalid');
                            $('.errorsatuan').html('');
                        }

                        if (response.error.harga) {
                            $('#harga').addClass('is-invalid');
                            $('.errorharga').html(response.error.harga);
                        } else {
                            $('#harga').removeClass('is-invalid');
                            $('.errorharga').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'berhasil',
                            text: response.sukses
                        })

                        $('#modaltambah').modal('hide');
                        databarang();
                    };

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;

        });
    });
</script>
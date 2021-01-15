<!-- /.Modal Tambah Barang -->
<div class="modal fade" id="modalmasuk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modaledit">Masuk Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('hpp/masukbarang', ['class' => 'formbarang']); ?>
            <!-- /.untuk menjaga form kita dari kejahatan para hacker -->
            <?= csrf_field(); ?>
            <!---------------------------------------------------------->
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">(1) Kode Barang</label>
                        <input type="text" name="id_persediaan" class="form-control" id="id_persediaan" value="<?= $id_persediaan; ?>" hidden>
                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?= $kode_barang; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(2) Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="<?= $nama_barang; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(3) qty</label>
                        <input type="text" name="qty" class="form-control" id="qty" value="<?= $qty + $masuk - $keluar; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(4) IN</label>
                        <input type="number" name="masuk" class="form-control" id="masuk" autofocus>
                        <div class="invalid-feedback errormasuk">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(5) Retur Pembelian</label>
                        <input type="number" name="retur_pembelian" class="form-control" id="retur_pembelian">
                        <div class="invalid-feedback errorretur">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(6) Potongan Pembelian</label>
                        <input type="number" name="pot_pembelian" class="form-control" id="pot_pembelian">
                        <div class="invalid-feedback errorpot">

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
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
                        if (response.error.masuk) {
                            $('#masuk').addClass('is-invalid');
                            $('.errormasuk').html(response.error.masuk);
                        } else {
                            $('#masuk').removeClass('is-invalid');
                            $('.errormasuk').html('');
                        }

                        if (response.error.retur) {
                            $('#retur_pembelian').addClass('is-invalid');
                            $('.errorretur').html(response.error.retur);
                        } else {
                            $('#retur_pembelian').removeClass('is-invalid');
                            $('.errorretur').html('');
                        }

                        if (response.error.pot) {
                            $('#pot_pembelian').addClass('is-invalid');
                            $('.errorpot').html(response.error.pot);
                        } else {
                            $('#pot_pembelian').removeClass('is-invalid');
                            $('.errorpot').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'berhasil',
                            text: response.sukses
                        })

                        $('#modalmasuk').modal('hide');
                        datalaporan();
                        datatransaksi();
                        datapersediaan();
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
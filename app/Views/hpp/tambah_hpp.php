<!-- /.Modal Tambah Barang -->
<div class="modal fade" id="modaltambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalhpp">Tambah Data HPP</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('hpp/simpandatahpp', ['class' => 'formhpp']); ?>
            <!-- /.untuk menjaga form kita dari kejahatan para hacker -->
            <?= csrf_field(); ?>
            <!---------------------------------------------------------->
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">(1) Tanggal</label>
                        <input type="date" name="date" class="form-control" id="date">
                        <div class="invalid-feedback errordate">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">(2) Nama Hpp</label>
                        <input type="text" name="nama_hpp" class="form-control" id="nama_hpp">
                        <div class="invalid-feedback errornama_hpp">

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
        $('.formhpp').submit(function(e) {
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
                        if (response.error.tanggal) {
                            $('#date').addClass('is-invalid');
                            $('.errordate').html(response.error.tanggal);
                        } else {
                            $('#date').removeClass('is-invalid');
                            $('.errordate').html('');
                        }

                        if (response.error.nama_hpp) {
                            $('#nama_hpp').addClass('is-invalid');
                            $('.errornama_hpp').html(response.error.nama_hpp);
                        } else {
                            $('#nama_hpp').removeClass('is-invalid');
                            $('.errornama_hpp').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'berhasil',
                            text: response.sukses
                        })

                        $('#modaltambah').modal('hide');

                        datahpp();

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
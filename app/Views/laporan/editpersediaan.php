<div class="form-group">
    <h4>Edit Persediaan <?= $hpp->id_persediaan; ?></h4>
</div>
<div class="form-group">

    <div class="form-group">
        <button type="button" class="btn btn-warning btnkembali">
            <i class="fa fa-arrow-left"></i>&nbsp; Kembali
        </button>
    </div>
    <div class="form-group">
        <?= form_open('hpp/hapusbanyakpersediaan/' .  $hpp->id_persediaan, ['class' => 'formhapusbanyak']) ?>

        <p>
            <button type="submit" class="btn btn-danger btn-sm float-left">
                <i class="fa fa-trash"></i>&nbsp; Hapus
            </button>
        </p>

        <table id="datapersediaan" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="centangSemua">
                    </th>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Stock Awal</th>
                    <th>in</th>
                    <th>out</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($persediaan as $persediaans) :
                ?>

                    <tr>
                        <td>
                            <input type="checkbox" name="kode_barang[]" class="centangkode_barang" value="<?= $persediaans['kode_barang']; ?>">
                        </td>
                        <td><?= $persediaans['kode_barang']; ?></td>
                        <td><?= $persediaans['nama_barang']; ?></td>
                        <td><?= $persediaans['satuan']; ?></td>
                        <td><?= $persediaans['qty']; ?></td>
                        <td><?= $persediaans['masuk']; ?></td>
                        <td><?= $persediaans['keluar'] ?></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7"></th>
                </tr>
            </tfoot>
        </table>
        <?= form_close(); ?>
    </div>
    <script>
        $(document).ready(function() {
            $('#datapersediaan').DataTable({});

            $('#centangSemua').click(function(e) {

                if ($(this).is(':checked')) {
                    $('.centangkode_barang').prop('checked', true);
                } else {
                    $('.centangkode_barang').prop('checked', false);
                }

            });

            $('.formhapusbanyak').submit(function(e) {

                e.preventDefault();

                let jmldata = $('.centangkode_barang:checked');

                if (jmldata.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maaf',
                        text: 'Pilih data terlebih dahulu sebelum di delete'
                    });
                } else {
                    Swal.fire({
                        title: 'DATA AKAN TERHAPUS',
                        text: `Apakah anda yakin ingin menghapus data sebanyak ${jmldata.length} data`,
                        icon: 'warning',
                        showDenyButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Iya',
                        denyButtonText: 'tidak',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                url: $(this).attr('action'),
                                data: $(this).serialize(),
                                dataType: "json",
                                success: function(response) {
                                    if (response.sukses) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'berhasil',
                                            text: response.sukses
                                        });
                                        datapersediaan();
                                    }
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }

                    });
                };
            });
        });

        $(document).ready(function(e) {
            $('.btnkembali').click(function(e) {
                e.preventDefault();
                datalaporan();
                datatransaksi();
                datapersediaan();
            });
        });
    </script>
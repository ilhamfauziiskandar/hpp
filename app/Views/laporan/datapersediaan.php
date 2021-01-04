<div class="form-group">
    <strong>
        <h5>PERSEDIAAN BARANG</h5>
    </strong>
    <table>
        <tr>
            <td>Tanggal &nbsp;</td>
            <td>&nbsp; : &nbsp;</td>
            <td><?= date('d M Y', strtotime($hpp->date)); ?></td>
        </tr>
        <tr>
            <td>ID HPP &nbsp;</td>
            <td>&nbsp; : &nbsp;</td>
            <td><?= $hpp->id_hpp; ?></td>
        </tr>
        <tr>
            <td>ID Persediaan &nbsp;</td>
            <td>&nbsp; : &nbsp;</td>
            <td><?= $hpp->id_persediaan; ?></td>
        </tr>
    </table>
    <hr>
</div>

<div class="form-group">
    <button type="button" class="btn btn-info" onclick="tambahbanyak('<?= $hpp->id_persediaan; ?>')">
        <i class="fa fa-plus-circle"></i>&nbsp; Tambah Persediaan
    </button>
</div>
<div class="form-group">
    <?= form_open('hpp/hapusbanyakpersediaan', ['class' => 'formhapusbanyak']) ?>

    <p>
        <button type="submit" class="btn btn-danger btn-sm float-left">
            <i class="fa fa-trash"></i>&nbsp; Hapus
        </button>
    </p>

    <table id="datapersediaan" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="5%">
                    <input type="checkbox" id="centangSemua">
                </th>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>qty</th>
                <th>in</th>
                <th>out</th>
                <th>Harga</th>
                <th>Saldo Awal</th>
                <th>Saldo Masuk</th>
                <th>Saldo Keluar</th>
                <th>Saldo Akhir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($persediaan as $persediaans) :
                $saldo_awal = $persediaans['qty'] * $persediaans['harga'];
                $saldo_masuk = $persediaans['masuk'] * $persediaans['harga'];
                $saldo_keluar = $persediaans['keluar'] * $persediaans['harga'];

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
                    <td>Rp.<?= number_format($persediaans['harga'], 0, ",", "."); ?></td>
                    <td>Rp.<?= number_format($saldo_awal, 0, ",", "."); ?></td>
                    <td>Rp.<?= number_format($saldo_masuk, 0, ",", "."); ?></td>
                    <td>Rp.<?= number_format($saldo_keluar, 0, ",", "."); ?></td>
                    <td></td>
                    <td>
                        <button class="btn btn-block btn-success btn-xs" data-toggle="modal" data-target="#modal-in<?= $persediaans['kode_barang']; ?>">IN</button>
                        <button class="btn btn-block btn-danger btn-xs" data-toggle="modal" data-target="#modal-out<?= $persediaans['kode_barang']; ?>">OUT</button>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
        <tfoot>
            <tr>
                <th colspan="13"></th>
            </tr>
        </tfoot>
    </table>
    <?= form_close(); ?>
</div>
<script>
    $(document).ready(function() {
        $('#datapersediaan').DataTable();

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

    function tambahbanyak(id_persediaan) {
        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/form_tambahpersediaan') ?>",
            dataType: "json",
            data: {
                id_persediaan: id_persediaan
            },
            beforeSend: function() {
                $('.viewdata1').html('<i class="fa fa-spin fa-sync"></i>')
            },
            success: function(response) {
                $('.viewdata1').html(response.data).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    };
</script>
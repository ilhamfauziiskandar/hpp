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
        <i class="fa fa-plus-circle"></i>&nbsp; Tambah Persediaan Awal
    </button>
</div>
<p>
    <button type="button" class="btn btn-warning btn-sm float-left" onclick="edit('<?= $hpp->id_persediaan; ?>')">
        <i class="fa fa-edit"></i>&nbsp; Edit
    </button>
</p>

<table id="datapersediaan" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Unit</th>
            <th>Stock Awal</th>
            <th>in</th>
            <th>out</th>
            <th>Stock Akhir</th>
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
        ?>

            <tr>
                <td><?= $persediaans['kode_barang']; ?></td>
                <td><?= $persediaans['nama_barang']; ?></td>
                <td><?= $persediaans['satuan']; ?></td>
                <td><?= $persediaans['qty']; ?></td>
                <td><?= $persediaans['masuk']; ?></td>
                <td><?= $persediaans['keluar'] ?></td>
                <td><?= $persediaans['stock_akhir']; ?></td>
                <td>Rp.<?= number_format($persediaans['harga'], 0, ",", "."); ?></td>
                <td>Rp.<?= number_format($persediaans['saldo_awal'], 0, ",", "."); ?></td>
                <td>Rp.<?= number_format($persediaans['saldo_masuk'], 0, ",", "."); ?></td>
                <td>Rp.<?= number_format($persediaans['saldo_keluar'], 0, ",", "."); ?></td>
                <td>Rp.<?= number_format($persediaans['saldo_akhir'], 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-block btn-success btn-xs" onclick="masuk('<?= $persediaans['kode_barang']; ?>', '<?= $persediaans['id_persediaan']; ?>')">
                        IN
                    </button>
                    <button type="button" class="btn btn-block btn-danger btn-xs" onclick="keluar('<?= $persediaans['kode_barang']; ?>', '<?= $persediaans['id_persediaan']; ?>')">
                        OUT
                    </button>
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
<script>
    $(document).ready(function() {
        $('#datapersediaan').DataTable({
            "responsive": true,
            "autoWidth": false,
        });

    });

    function edit(id_persediaan) {
        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/editpersediaan') ?>",
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

    function masuk(kode_barang, id_persediaan) {
        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/form_masuk_barang') ?>",
            data: {
                id_persediaan: id_persediaan,
                kode_barang: kode_barang
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalmasuk').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    };


    function keluar(kode_barang, id_persediaan) {
        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/form_keluar_barang') ?>",
            data: {
                id_persediaan: id_persediaan,
                kode_barang: kode_barang
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalkeluar').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    };
</script>
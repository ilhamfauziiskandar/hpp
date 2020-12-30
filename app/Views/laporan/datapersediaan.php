<table id="datapersediaan" class="table table-bordered table-hover">
    <thead>
        <tr>
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
        ?>

            <tr>
                <td><?= $persediaans['id_persediaan']; ?></td>
                <td><?= $persediaans['kode_barang']; ?></td>
            </tr>
        <?php endforeach; ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="12"></th>
        </tr>
    </tfoot>
</table>
<script>
    $(document).ready(function() {
        $('#datapersediaan').DataTable();
    });
</script>
<div class="card-body table-responsive p-0" style="height: 300px;">
    <table class="table table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th colspan="3" style=" text-align: center; ">History Transaksi Persediaan Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaksi as $v) : ?>
                <tr>
                    <td><?= $v['nama_barang']; ?></td>
                    <td><?= $v['jumlah']; ?></td>
                    <td><?= $v['nama_status']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style=" text-align: center; "></th>
            </tr>
        </tfoot>
    </table>
</div>
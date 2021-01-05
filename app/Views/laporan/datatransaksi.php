<div class="card-body table-responsive p-0" style="height: 300px;">
    <table class="table table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th colspan="4" style=" text-align: center; ">History Transaksi Persediaan Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaksi as $v) :
                if ($v['nama_status'] ==  "in") {
                    $status = "success";
                } else {
                    $status = "warning";
                }
            ?>
                <tr>
                    <td>Tanggal : <?= date('d M Y', strtotime($v['tanggal'])); ?></td>
                    <td>Nama Barang : &nbsp;<?= $v['nama_barang']; ?></td>
                    <td><?= $v['jumlah']; ?> Barang</td>
                    <td><button class="btn btn-<?= $status; ?> btn-sm" disabled><?= $v['nama_status']; ?></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style=" text-align: center; "></th>
            </tr>
        </tfoot>
    </table>
</div>
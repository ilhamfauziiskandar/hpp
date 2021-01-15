<div class="card-body table-responsive p-0" style="height: 300px;">
    <table class="table table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th colspan="15" style=" text-align: center; ">Transaksi Keluar dan Masuknya Persediaan Barang</th>
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
                    <td>
                        <button class="btn btn-<?= $status; ?> btn-sm" disabled><?= $v['nama_status']; ?></button>
                    </td>
                    <td>|</td>
                    <td>Tanggal : <?= date('d M Y', strtotime($v['tanggal'])); ?></td>
                    <td>|</td>
                    <td>Nama Barang : &nbsp;<?= $v['nama_barang']; ?></td>
                    <td>|</td>
                    <td><?= $v['jumlah']; ?> Barang</td>
                    <td>|</td>
                    <td>Harga : Rp. <?= number_format($v['harga'], 0, ",", "."); ?></td>
                    <td>|</td>
                    <td>Total : Rp. <?= number_format($v['total'], 0, ",", "."); ?></td>

                    <?php

                    if ($status == "success") {
                        echo "<td>|</td><td>Retur pembelian : Rp. " . number_format($v['retur_pembelian'], 0, ",", ".") . "</td>";
                    } else {
                        echo "<td></td><td></td>";
                    }

                    ?>


                    <?php

                    if ($status == "success") {
                        echo "<td>|</td> <td>Potongan pembelian : Rp. " . number_format($v['pot_pembelian'], 0, ",", ".") . "</td>";
                    } else {
                        echo "<td></td> <td></td>";
                    }

                    ?>
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
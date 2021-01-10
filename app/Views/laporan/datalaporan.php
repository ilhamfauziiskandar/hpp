<div class="form-group row">
    <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-2" style="border: 0px;">
            <!-- title row -->
            <div class="col-12">
                <small class="float-right">
                    <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>

                </small>
            </div>
            <h3>
                OneStopPolos.
            </h3>

            <br>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Laporan Harga Pokok Penjualan.</strong><br>

                        <table>
                            <tr>
                                <td>
                                    <strong>Tanggal</strong><br>
                                </td>
                                <td>
                                    <strong>&nbsp; : &nbsp;</strong>
                                </td>
                                <td>
                                    <strong> <?= date('d M Y', strtotime($hpp->date)); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>ID HPP</strong><br>
                                </td>
                                <td>
                                    <strong>&nbsp; : &nbsp;</strong>
                                </td>
                                <td>
                                    <strong><?= $hpp->id_hpp; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>ID Persediaan</strong><br>
                                </td>
                                <td>
                                    <strong>&nbsp; : &nbsp;</strong>
                                </td>
                                <td>
                                    <strong><?= $hpp->id_persediaan; ?></strong>
                                </td>
                            </tr>
                        </table>
                    </address>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td width="51%"></td>
                                <td width="27%">Persediaan Awal Barang</td>
                                <td>Rp. <?= number_format($jumlah_saldo_awal, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>Pembelian</td>
                                <td>Rp. <?= number_format($hpp->pembelian, 0, ",", "."); ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Retur Pembelian</td>
                                <td>Rp. <?= number_format($hpp->retur_pembelian, 0, ",", "."); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Potongan Pembelian</td>
                                <td>Rp. <?= number_format($hpp->pot_pembelian, 0, ",", "."); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Total Pembelian Bersih</th>
                                <td></td>
                                <td>Rp. <?= number_format($pembelian_bersih, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">

                </div>
                <!-- /.col -->
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Barang Tersedia untuk Dijual</th>
                                <td width="45%">Rp. <?= number_format($btusd, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td>Persediaan Akhir Barang</td>
                                <td>Rp. <?= number_format($jumlah_saldo_akhir, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <th>Harga Pokok Penjualan (HPP)</th>
                                <th>RP. <?= number_format($hasilhpp, 0, ",", "."); ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.invoice -->
    </div>
    <!-- /.col -->
</div>
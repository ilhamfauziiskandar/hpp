<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('user'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Gizi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cek Gizi</li>
        </ol>
    </nav>
    <?= $this->session->flashdata('info'); ?>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- <form>
                <div class="form-group row">
                    <label for="tb" class="col-sm-2 col-form-label">Tinggi Badan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="tb" name="tb" placeholder="Opsional Tinggi Badan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bb" class="col-sm-2 col-form-label">Berat Badan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="bb" name="bb" placeholder="Opsional Berat Badan">
                    </div>
                </div>
            </form>
            <br>
            <br> -->
            <form method="POST" action="<?= base_url('user/inputgizi'); ?>">
                <div class="form-group">
                    <div class="table-responsive">
                        <table id="cekgizi" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bahan Makanan<small style="color:red">*</small></th>
                                    <th>URT<small style="color:red">*</small></th>
                                    <th>Berat (gr)<small style="color:red">*</small></th>
                                    <th>Energi</th>
                                    <th>Protein</th>
                                    <th>Lemak</th>
                                    <th>Karbohidrat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor = 1; ?>
                                <?php
                                // tanggal lahir
                                $umr = $user['tanggallahir'];
                                $tanggal = strtotime($umr);
                                $sekarang = strtotime(date('y-m-d'));
                                $diff = $sekarang - $tanggal;
                                // tanggal hari ini
                                // tahun
                                $bulan = floor($diff / (60 * 60 * 24 * 30));
                                $tahun = floor($diff / (60 * 60 * 24 * 365));

                                ?>

                            </tbody>
                            <tfoot>
                                <!-- <tr>
                                    <th colspan="4">Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot> -->
                        </table>
                        <div align="right">
                            <button type="button" id="add" name="add" class="btn btn-info"><i class="fas fa-plus"></i> Tambah Baris</button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Cek Gizi</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    var i = 0;
    var smartAuto = (function() {
        var addBtn, html, rowCount, tablebody;
        addBtn = $('#add');
        rowCount = $('#cekgizi tbody tr').length + 1;
        tablebody = $('#cekgizi tbody');


        function formHtml() {
            <?php $nomor = 1; ?>
            <?php
            // tanggal lahir
            $umr = $user['tanggallahir'];
            $tanggal = strtotime($umr);
            $sekarang = strtotime(date('y-m-d'));
            $diff = $sekarang - $tanggal;
            // tanggal hari ini
            // tahun
            $bulan = floor($diff / (60 * 60 * 24 * 30));
            $tahun = floor($diff / (60 * 60 * 24 * 365));

            ?>
            console.log(rowCount);
            <?php date_default_timezone_set('Asia/Jakarta'); ?>
            html = '<tr id = "row_' + rowCount + '" >';
            html += '<td class="text-center">' + rowCount + '</td>';
            html += '<td hidden>';
            html += '<input type="text" class="form-control" data-type="id_user" id="id_user[]" name="id_user[]" value="<?= $user['id']; ?>">';
            html += '</td>';
            html += '<td hidden>';
            html += '<input type="text" data-type="tgl" class="form-control" id="tgl[]" name="tgl[]" value="<?= date('Y-m-d'); ?>">';
            html += '</td>';
            html += '<td hidden>';
            html += '<input type="text" class="form-control" data-type="jeniskelamin" id="jeniskelamin[]" name="jeniskelamin[]" value="<?= $user['jeniskelamin']; ?>">';
            html += '</td>';
            html += '<td class="delete_row text-center" id="delete_' + rowCount + '">';
            html += '<a data-toggle="tooltip" title="Hapus" id="hapusbaris" class="text-danger" ><i class="fas fa-trash"></i></a>';
            html += '</td>';
            html += '</tr>';
            rowCount++;
            return html;


        }

        function getFieldNo(type) {
            var fieldNo;
            switch (type) {
                case 'bahanmakanan':
                    fieldNo = 0;
                    break;
            }
            return fieldNo;
        }


        function handleAutocomplete() {
            var fieldName, currentEle;
            currentEle = $(this);

            fieldName = currentEle.data('field-name');
            if (typeof fieldName === 'undefined') {
                return false;
            }
            currentEle.autocomplete({
                source: function(data, cb) {
                    $.ajax({
                        url: '<?php echo site_url('User/get_autocomplete'); ?>',
                        method: 'GET',
                        dataType: 'json',
                        data: {
                            bahanmakanan: data.term,
                            fieldName: fieldName
                        },
                        success: function(res) {
                            var result;
                            result = [{
                                label: 'Bahan makanan ' + data.term + ' tidak ditemukan',
                                value: ''
                            }];
                            console.log('before format', res);
                            if (res.length) {
                                result = $.map(res, function(obj) {
                                    return {
                                        label: obj[fieldName],
                                        data: obj[fieldName],
                                        data: obj
                                    };
                                });
                            }
                            console.log("after format", result);
                            cb(result);
                        }
                    });
                },
                autoFocus: true,
                minLength: 1,
                select: function(event, selectedData) {
                    console.log(selectedData);
                    if (selectedData && selectedData.item && selectedData.item.data) {
                        var rowNo, data;
                        rowNo = getId(currentEle);
                        data = selectedData.item.data;

                        $('#bahanmakanan_' + rowNo).val(data.foodname);
                        $('#energi_' + rowNo).val(data.energy);
                        $('#lemak_' + rowNo).val(data.fats);
                        $('#protein_' + rowNo).val(data.protein);
                        $('#karbohidrat_' + rowNo).val(data.carbhdrt);
                        $('#f_edible_' + rowNo).val(data.f_edible);
                    }
                }

            });
        }

        function getId(element) {
            var id, idarr;
            id = element.attr('id');
            console.log(id);
            idarr = id.split('_');
            console.log(idarr);
            return idarr[idarr.length - 1];
        }

        function addNewRow() {
            tablebody.append(formHtml());
            tablebody.append(myFunction());

        }

        function deleteRow() {
            var currentEle, rowNo;
            currentEle = $(this);
            rowNo = getId(currentEle);
            console.log(rowNo);
            $('#row_' + rowNo).remove();
        }

        function registerEvent() {
            addBtn.on('click', addNewRow);
            $(document).on('click', '.delete_row', deleteRow);
            //register autocomplete event
            $(document).on('focus', '.autocomplete_txt', handleAutocomplete);
        }

        var i = 0;
        // hitung zat gizi
        function myFunction() {
            var rowCount = $('#cekgizi tbody tr').length + 0;
            console.log(rowCount);
            $("#berat_" + rowCount).keyup(function() {
                var berat = $(this).val();
                var energi = $('#energi_' + rowCount).val();
                var lemak = $('#lemak_' + rowCount).val();
                var protein = $('#protein_' + rowCount).val();
                var karbohidrat = $('#karbohidrat_' + rowCount).val();
                var bdd = $("#f_edible_" + rowCount).val();
                var h_energi = parseFloat(berat) * parseFloat(energi) / parseFloat(bdd);
                var h_lemak = parseFloat(berat) * parseFloat(lemak) / parseFloat(bdd);
                var h_protein = parseFloat(berat) * parseFloat(protein) / parseFloat(bdd);
                var h_karbohidrat = parseFloat(berat) * parseFloat(karbohidrat) / parseFloat(bdd);
                $("input[id=h_energi_" + rowCount + "]").val(h_energi);
                $("input[id=h_lemak_" + rowCount + "]").val(h_lemak);
                $("input[id=h_protein_" + rowCount + "]").val(h_protein);
                $("input[id=h_karbohidrat_" + rowCount + "]").val(h_karbohidrat);
            });


        }

        function init() {
            registerEvent();

        }
        return {
            init: init
        }

    })();
    $(document).ready(function() {
        smartAuto.init();
    });
</script>
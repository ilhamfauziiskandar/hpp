<div class="form-group">
    <strong>
        <h5>TAMBAH BARANG PERSEDIAAN</h5>
    </strong>
    <p>note : pastikan untuk melist barang terlebih dahulu sebelum menambahkan barang persediaan</p>
    <hr>
</div>
<?= form_open('hpp/simpanpersediaanbanyak', ['class' => 'formsimpanbanyak']); ?>
<?= csrf_field(); ?>
<p>
    <button class="btn btn-warning btnkembali" type="button">
        Kembali
    </button>
    &nbsp;
    <button class="btn btn-info simpanbanyak" type="submit">
        Submit
    </button>
</p>
<table class="table table-hover" id="persediaan_awal">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th width="15%">Quantity</th>
            <th>Kode Barang</th>
            <th>Harga</th>
            <th width="5%">Action</th>
        </tr>
    </thead>
    <tbody class="formtambah">

    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <button class="btn btn-info btnaddform float-right" id="add"><i class="fa fa-plus"></i></button>
            </td>
        </tr>
    </tfoot>
</table>
<?= form_close(); ?>
<script>
    // handling
    $(document).ready(function(e) {

        $('.formsimpanbanyak').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpanbanyak').attr('disable', 'disabled');
                    $('.btnsimpanbanyak').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpanbanyak').removeAttr('disable');
                    $('.btnsimpanbanyak').html('Simpan');
                },
                success: function(response) {
                    if (response.sukses) {

                        Swal.fire({
                            icon: 'success',
                            title: 'berhasil',
                            html: `${response.sukses}`
                        }).then((result) => {
                            if (result.value) {
                                datapersediaan();
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;

        });

    });

    // auto complete
    var i = 0;
    var smartAuto = (function() {
        var addBtn, html, rowCount, tablebody;
        addBtn = $('#add');
        rowCount = $('#persediaan_awal tbody tr').length + 1;
        tablebody = $('#persediaan_awal tbody');


        function formHtml() {
            <?php $nomor = 1; ?>
            console.log(rowCount);
            html = '<tr id = "row_' + rowCount + '" >';
            html += '<td class="text-center">' + rowCount + '</td>';
            html += '<td>';
            html += '<input type="text" class="form-control autocomplete_txt" data-type= id="id_hpp[]" name="id_hpp[]" value="">';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" class="form-control autocomplete_txt" data-type="nama_barang" id="nama_barang[]" name="nama_barang[]" value="">';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" data-type="qty" class="form-control" id="qty[]" name="qty[]" value="">';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" class="form-control" data-type="kode_barang" id="kode_barang[]" name="kode_barang[]" value="">';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" class="form-control" data-type="harga" id="harga[]" name="harga[]" value="">';
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
                case 'namabarang':
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
                        url: '<?php echo base_url('hpp/get_autocomplete'); ?>',
                        method: 'GET',
                        dataType: 'json',
                        data: {
                            namabarang: data.term,
                            fieldName: fieldName
                        },
                        success: function(res) {
                            var result;
                            result = [{
                                label: 'Barang ' + data.term + ' tidak ditemukan',
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

                        $('#harga' + rowNo).val(data.harga);
                        $('#kode_barang' + rowNo).val(data.kode_barang);
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

    $('.btnkembali').click(function(e) {
        e.preventDefault();

        datapersediaan();
    });
</script>
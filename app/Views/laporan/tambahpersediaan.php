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
<table class="table table-hover">
    <thead>
        <tr>
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
            <td colspan="5">
                <button class="btn btn-info btnaddform float-right"><i class="fa fa-plus"></i></button>
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
                                datalaporan();
                                datatransaksi();
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

        $('.btnaddform').click(function(e) {
            e.preventDefault();
            rowCount = $('#persediaan_awal tbody tr').length + 1;
            console.log(rowCount);
            $('.formtambah').append(`
                <tr>
                <tr id = "row_  ` + rowCount + `">
                    <td>
                        <input type="number" name="id_hpp[]" class="form-control" value="<?= $id_hpp ?>" hidden>
                        <input type="number" name="id_persediaan[]" class="form-control" value="<?= $id_persediaan ?>" hidden>
                        <input type="date" name="date[]" class="form-control" value="<?= $date ?>" hidden>
                        <input type="text" name="nama_barang[]" class="form-control" placeholder="Masukan Nama Barang">
                    </td>
                    <td>
                        <input type="number" name="qty[]" class="form-control" placeholder="Jumlah">
                    </td>
                    <td>
                        <input type="text" name="kode_barang[]" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="harga[]" class="form-control" disabled>
                    </td>
                    <td>
                        <button class="btn btn-danger float-right btnhapusform"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `);
        })

    });

    // listener
    $('.btnkembali').click(function(e) {
        e.preventDefault();
        datalaporan();
        datatransaksi();
        datapersediaan();
    });

    $(document).on('click', '.btnhapusform', function(e) {
        e.preventDefault();

        $(this).parents('tr').remove();
    });
</script>
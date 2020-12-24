<?= form_open('barang/simpandatabanyak', ['class' => 'formsimpanbanyak']); ?>
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
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
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
                                window.location.href = ("<?= base_url('barang/index'); ?>")
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

            $('.formtambah').append(`
                <tr>
                    <td>
                        <input type="text" name="kode_barang[]" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="nama_barang[]" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="satuan[]" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="harga[]" class="form-control">
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

        databarang();
    });

    $(document).on('click', '.btnhapusform', function(e) {
        e.preventDefault();

        $(this).parents('tr').remove();
    });
</script>
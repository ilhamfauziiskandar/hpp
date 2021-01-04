<?= form_open('barang/hapusbanyak', ['class' => 'formhapusbanyak']) ?>
<p>
    <button type="submit" class="btn btn-danger btn-sm float-left">
        <i class="fa fa-trash"></i>&nbsp; Hapus
    </button>
</p>
<table id="databarang" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th width="5%">
                <input type="checkbox" id="centangSemua">
            </th>
            <th width="5%">NO</th>
            <th width="25">KODE BARANG</th>
            <th width="35%">NAMA BARANG</th>
            <th width="5%">SATUAN</th>
            <th width="20%">HARGA</th>
            <th width="5%">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        foreach ($barang as $barangs) :
            $no++;
        ?>

            <tr>
                <td>
                    <input type="checkbox" name="kode_barang[]" class="centangkode_barang" value="<?= $barangs['kode_barang']; ?>">
                </td>
                <td><?= $no; ?></td>
                <td><?= $barangs['kode_barang']; ?></td>
                <td><?= $barangs['nama_barang']; ?></td>
                <td><?= $barangs['satuan']; ?></td>
                <td>Rp. <?= number_format($barangs['harga'], 0, ",", "."); ?></td>
                <td>
                    &nbsp;
                    <button type="button" class="btn btn-warning btn-sm" onclick="edit('<?= $barangs['kode_barang']; ?>')">
                        <i class="fa fa-edit"></i>&nbsp; Edit
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="7">&nbsp;</th>
        </tr>
    </tfoot>
</table>
<?= form_close(); ?>
<script>
    $(document).ready(function() {
        $('#databarang').DataTable();

        $('#centangSemua').click(function(e) {

            if ($(this).is(':checked')) {
                $('.centangkode_barang').prop('checked', true);
            } else {
                $('.centangkode_barang').prop('checked', false);
            }

        });

        $('.formhapusbanyak').submit(function(e) {

            e.preventDefault();

            let jmldata = $('.centangkode_barang:checked');

            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf',
                    text: 'Pilih data terlebih dahulu sebelum di delete'
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Do you want to save the changes?',
                    showDenyButton: true,
                    confirmButtonText: `Save`,
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'berhasil',
                                        text: response.sukses
                                    });
                                    databarang();
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            };
        });

    });

    function edit(kode_barang) {
        $.ajax({
            type: "post",
            url: "<?= base_url('barang/form_edit_barang') ?>",
            data: {
                kode_barang: kode_barang
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
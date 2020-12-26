<?= form_open('hpp/hapusbanyak', ['class' => 'formhapusbanyak']) ?>
<p>
    <button type="submit" class="btn btn-danger btn-sm float-left">
        <i class="fa fa-trash"></i>
    </button>
</p>
<table id="datahpp" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th width="5%">
                <input type="checkbox" id="centangSemua">
            </th>
            <th width="5%">No</th>
            <th>Laporan Harga Penjualan Produk</th>
            <th width="5%">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $no = 1;
        foreach ($hpp as $hpps) :
        ?>

            <tr>
                <td>
                    <input type="checkbox" name="id_hpp[]" class="centangid_hpp" value="<?= $hpps['id_hpp']; ?>">
                </td>
                <td>
                    <?= $no++; ?>
                </td>
                <td>
                    Tanggal &nbsp; : &nbsp;<?= date('d-M-Y', strtotime($hpps['date'])); ?>&nbsp; | &nbsp; ID HPP &nbsp; : &nbsp; <?= $hpps['id_hpp']; ?> | &nbsp; Nama &nbsp; : &nbsp; <?= $hpps['nama_hpp']; ?>
                </td>
                <td>
                    <btn class="btn btn-info btn-sm" href="<?= base_url('hpp/persediaan/' . $hpps['id_persediaan']); ?>">
                        <i class="fa  fa-search"></i>
                        Lihat
                    </btn>
                </td>

            </tr>
        <?php endforeach; ?>

    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">&nbsp;</th>
        </tr>
    </tfoot>
</table>
<?= form_close(); ?>

<script>
    $(document).ready(function() {
        $('#datahpp').DataTable();

        $('#centangSemua').click(function(e) {

            if ($(this).is(':checked')) {
                $('.centangid_hpp').prop('checked', true);
            } else {
                $('.centangid_hpp').prop('checked', false);
            }

        });

        $('.formhapusbanyak').submit(function(e) {

            e.preventDefault();

            let jmldata = $('.centangid_hpp:checked');

            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf',
                    text: 'Pilih data terlebih dahulu sebelum di delete'
                });
            } else {
                swal.fire({
                    title: 'DATA AKAN TERHAPUS',
                    text: `Apakah anda yakin ingin menghapus data sebanyak ${jmldata.length} data`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
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
                                datahpp();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                });
            };
        });

    });
</script>
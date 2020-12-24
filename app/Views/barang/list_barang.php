<?= $this->extend('layout/main'); ?>

<?= $this->extend('layout/navbar'); ?>

<?= $this->section('isi'); ?>
<!-- DataTables -->
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        <h1>List Barang</h1>
                    </div>
                    <div class="card-body ">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary tomboltambah">
                                <i class="fa fa-plus-circle"></i>&nbsp;Data Barang
                            </button>
                            &nbsp;
                            <button type="button" class="btn btn-primary tomboltambahbanyak">
                                <i class="fa fa-plus-circle"></i>&nbsp;Data Banyak
                            </button>
                        </div>

                        <p class="viewdata"></p>

                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.content -->

<div class="viewmodal" style="display: none;"></div>

<script>
    function databarang() {

        $.ajax({
            url: "<?= base_url('barang/ambildata') ?>",
            dataType: "json",
            beforeSend: function() {
                $('.viewdata').html('<i class="fa fa-spin fa-sync"></i>')
            },
            success: function(response) {
                $('.viewdata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

    }

    $(document).ready(function() {
        databarang();

        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('barang/form_tambah_barang') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();

                    $('#modaltambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $('.tomboltambahbanyak').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('barang/form_tambah_banyak_barang') ?>",
                dataType: "json",
                beforeSend: function() {
                    $('.viewdata').html('<i class="fa fa-spin fa-sync"></i>')
                },
                success: function(response) {
                    $('.viewdata').html(response.data).show();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?= $this->endsection(''); ?>
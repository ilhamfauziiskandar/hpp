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
            <div class="col-12 col-lg">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-2 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Laporan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Persediaan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Transaksi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <p class="viewdata"></p>
                            </div>
                            <div class="tab-pane fade show active" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                <p class="viewdata1"></p>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                <p class="viewdata2"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.content -->
<div class="viewmodal" style="display: none;"></div>

<script>
    function datalaporan() {

        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/ambillaporan') ?>",
            data: {
                id_persediaan: "<?= $id_persediaan ?>"
            },
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

    function datapersediaan() {

        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/ambilpersediaan') ?>",
            data: {
                id_persediaan: "<?= $id_persediaan ?>"
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewdata1').html('<i class="fa fa-spin fa-sync"></i>')
            },
            success: function(response) {
                $('.viewdata1').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function datatransaksi() {

        $.ajax({
            type: "post",
            url: "<?= base_url('hpp/ambiltransaksi') ?>",
            data: {
                id_persediaan: "<?= $id_persediaan ?>"
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewdata2').html('<i class="fa fa-spin fa-sync"></i>')
            },
            success: function(response) {
                $('.viewdata2').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    $(document).ready(function() {
        datapersediaan();
        datalaporan();
        datatransaksi();
    })
</script>
<?= $this->endsection(); ?>
<?= $this->extend('layout/main'); ?>

<?= $this->extend('layout/navbar'); ?>

<?= $this->section('isi'); ?>

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title"> Program Perhitungan Harga Pokok Produk ( HPP )</h1>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3>HELLO , <?= session('nama'); ?></h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        &nbsp;
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
<!-- /.content -->

<?= $this->endsection(); ?>
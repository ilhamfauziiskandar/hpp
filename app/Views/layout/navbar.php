<?= $this->extend('layout/main'); ?>

<?= $this->section('navbar'); ?>

<li class="nav-item">
    <a href="<?= base_url('/hpp'); ?>" class="nav-link">Laporan HPP</a>
</li>
<li class="nav-item">
    <a href="<?= base_url('/barang'); ?>" class="nav-link">List Barang</a>
</li>

<?= $this->endsection(); ?>
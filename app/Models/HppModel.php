<?php

namespace App\Models;

use CodeIgniter\Model;

class HppModel extends Model
{
    protected $table      = 'hpp';
    protected $primaryKey = 'id_hpp';
    protected $allowedFields = ['id_hpp', 'id_persediaan', 'date', 'nama_hpp', 'pembelian', 'retur_pembelian', 'pot_pembelian', 'persediaan_awal', 'persediaan_akhir'];

    public function get_hpp()
    {
        return $this->db->query("SELECT * FROM `hpp` ORDER BY `date` DESC")->getResultArray();
    }

    public function get_last()
    {
        return $this->db->query("SELECT id_hpp FROM hpp")->getLastRow();
    }

    public function get_persediaan($id_persediaan)
    {
        return $this->db->query("SELECT persediaan_barang.id_hpp, persediaan_barang.id_persediaan, barang.kode_barang, barang.nama_barang, barang.satuan, persediaan_barang.qty, persediaan_barang.masuk, persediaan_barang.keluar, barang.harga 
        FROM persediaan_barang INNER JOIN barang ON persediaan_barang.kode_barang = barang.kode_barang WHERE persediaan_barang.id_persediaan = $id_persediaan")->getResultArray();
    }

    public function get_persediaan_complete($id_persediaan)
    {
        return $this->db->query("SELECT persediaan_barang.id_hpp, persediaan_barang.id_persediaan, barang.kode_barang, barang.nama_barang, barang.satuan, persediaan_barang.qty, persediaan_barang.masuk, persediaan_barang.keluar, barang.harga, (persediaan_barang.qty + persediaan_barang.masuk - persediaan_barang.keluar) as stock_akhir, (persediaan_barang.qty * barang.harga) as saldo_awal, (persediaan_barang.masuk * barang.harga) as saldo_masuk, (persediaan_barang.keluar * barang.harga) as saldo_keluar, ((persediaan_barang.qty + persediaan_barang.masuk - persediaan_barang.keluar) * barang.harga) as saldo_akhir 
        FROM persediaan_barang INNER JOIN barang ON persediaan_barang.kode_barang = barang.kode_barang WHERE persediaan_barang.id_persediaan = '$id_persediaan'")->getResultArray();
    }

    public function get_persediaan1($id_persediaan)
    {
        return $this->db->query("SELECT * FROM hpp WHERE id_persediaan = $id_persediaan")->getRow();
    }

    public function get_kodebarang($kode_barang, $id_persediaan)
    {
        return $this->db->query("SELECT `kode_barang` FROM `persediaan_barang` WHERE `kode_barang` = '$kode_barang' && `id_persediaan` = '$id_persediaan'")->getResultArray();
    }

    public function get_stock($id_persediaan, $kode_barang)
    {
        return $this->db->query("SELECT persediaan_barang.id_persediaan, barang.kode_barang, barang.nama_barang, barang.satuan, persediaan_barang.qty, persediaan_barang.masuk, persediaan_barang.keluar FROM persediaan_barang INNER JOIN barang ON persediaan_barang.kode_barang = barang.kode_barang WHERE persediaan_barang.id_persediaan = '$id_persediaan' && barang.kode_barang = '$kode_barang'")->getRow();
    }

    public function get_id_persediaan($id_hpp)
    {
        return $this->db->query("SELECT id_persediaan FROM hpp WHERE id_hpp = $id_hpp")->getRow();
    }

    public function get_transaksi($id_persediaan)
    {
        return $this->db->query("SELECT transaksi.tanggal, transaksi.kode_barang, transaksi.jumlah, status.nama_status, barang.nama_barang
        FROM transaksi JOIN status ON transaksi.id_status = status.id_status JOIN barang ON transaksi.kode_barang = barang.kode_barang WHERE transaksi.id_persediaan = $id_persediaan")->getResultArray();
    }

    public function delete_persediaan($kode_barang, $id_persediaan)
    {
        return $this->db->table('persediaan_barang')->delete(array('kode_barang' => $kode_barang, 'id_persediaan' => $id_persediaan));
    }

    public function delete_hpp($id_hpp)
    {
        return $this->db->table('hpp')->delete(array('id_hpp' => $id_hpp));
    }

    public function delete_transaksi($id_persediaan)
    {
        return $this->db->table('transaksi')->delete(array('id_persediaan' => $id_persediaan));
    }

    public function barangmasuk($id_persediaan, $kode_barang, $data)
    {
        return $this->db->table('persediaan_barang')->update($data, array('kode_barang' => $kode_barang, 'id_persediaan' => $id_persediaan));
    }

    public function barangkeluar($id_persediaan, $kode_barang, $data)
    {
        return $this->db->table('persediaan_barang')->update($data, array('kode_barang' => $kode_barang, 'id_persediaan' => $id_persediaan));
    }

    public function edit_barang($data, $kode_barang)
    {
        return $this->db->table('barang')->update($data, array('kode_barang' => $kode_barang));
    }

    public function insert_persediaan($data)
    {
        return $this->db->table('persediaan_barang')->insert($data);
    }

    public function insert_transaksi($data)
    {
        return $this->db->table('transaksi')->insert($data);
    }
}

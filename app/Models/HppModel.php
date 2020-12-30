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
        return $this->db->query("SELECT persediaan_barang.id_persediaan, barang.kode_barang, barang.nama_barang, barang.satuan, persediaan_barang.qty, persediaan_barang.masuk, persediaan_barang.keluar, barang.harga 
        FROM persediaan_barang INNER JOIN barang ON persediaan_barang.kode_barang = barang.kode_barang WHERE persediaan_barang.id_persediaan = $id_persediaan")->getResultArray();
    }
    // public function get_persediaan()
    // {
    //     return $this->db->table('persediaan_barang')->get()->getResultArray();
    // }

    public function get_id_persediaan($id_hpp)
    {
        return $this->db->query("SELECT id_persediaan FROM hpp WHERE id_hpp = $id_hpp")->getRow();
    }

    public function delete_persediaan($id_hpp)
    {
        return $this->db->table('persediaan_barang')->delete(array('id_hpp' => $id_hpp));
    }

    public function insert_persediaan($data)
    {
        return $this->db->table('persediaan_barang')->insert($data);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class HppModel extends Model
{
    protected $table      = 'hpp';
    protected $primaryKey = 'id_hpp';
    protected $allowedFields = ['id_hpp', 'id_persediaan', 'date', 'nama_hpp', 'pembelian', 'retur_pembelian', 'pot_pembelian', 'persediaan_awal', 'persediaan_akhir'];

    public function get_last()
    {
        return $this->db->query("SELECT id_hpp FROM hpp")->getLastRow();
    }

    public function get_id_persediaan($id_hpp)
    {
        return $this->db->query("SELECT id_persediaan FROM hpp WHERE id_hpp = $id_hpp")->getResult();
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

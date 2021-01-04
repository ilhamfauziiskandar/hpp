<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Barang extends BaseController
{
    public function index()
    {
        if (session('login') == false) {

            return view('login/index');
        } else {
            $session = session();

            $pages = [
                'title' => 'Barang',
                'sub' => 'List Barang',
                'breadcrump' => 'Pages / List Barang'
            ];

            $session->set($pages);
            return view('barang/list_barang');
        }
    }

    //--------------------------------------------------------------------

    public function ambildata()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'barang' => $this->brg->findAll()
            ];

            $msg = [
                'data' => view('barang/databarang', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function form_tambah_barang()
    {
        if ($this->request->isAJAX()) {
            $id_persediaan = $this->request->getVar('id_persediaan');

            helper('form');

            $msg = [
                'data' => view('barang/tambah_barang', $id_persediaan)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function simpandata()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'kode_barang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required|is_unique[barang.kode_barang]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} kode barang sudah ada, silahkan coba yang lain'
                    ]
                ],
                'nama_barang' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'satuan' => [
                    'label' => 'Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'kode_barang' => $validation->getError('kode_barang'),
                        'nama_barang' => $validation->getError('nama_barang'),
                        'satuan' => $validation->getError('satuan'),
                        'harga' => $validation->getError('harga')
                    ],

                ];

                echo json_encode($msg);
            } else {
                $simpandata = [
                    'kode_barang' => $this->request->getVar('kode_barang'),
                    'nama_barang' => $this->request->getVar('nama_barang'),
                    'satuan' => $this->request->getVar('satuan'),
                    'harga' => $this->request->getVar('harga')
                ];

                $this->brg->insert($simpandata);

                $msg = [
                    'sukses' => 'Data Barang berhasil tersimpan'
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function form_edit_barang()
    {
        if ($this->request->isAJAX()) {

            $kode_barang = $this->request->getVar('kode_barang');

            $row = $this->brg->find($kode_barang);

            $data = [
                'kode_barang' => $row['kode_barang'],
                'nama_barang' => $row['nama_barang'],
                'satuan' => $row['satuan'],
                'harga' => $row['harga'],
            ];

            helper('form');

            $msg = [
                'sukses' => view('barang/edit_barang', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function updatedata()
    {
        if ($this->request->isAJAX()) {


            $simpandata = [
                'kode_barang' => $this->request->getVar('kode_barang'),
                'nama_barang' => $this->request->getVar('nama_barang'),
                'satuan' => $this->request->getVar('satuan'),
                'harga' => $this->request->getVar('harga')
            ];

            $kode_barang = $this->request->getVar('kode_barang');

            $this->brg->update($kode_barang, $simpandata);

            $msg = [
                'sukses' => "Data Barang dengan kode $kode_barang berhasil diupdate"
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function form_tambah_banyak_barang()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $msg = [
                'data' => view('barang/tambahbanyak')
            ];
            echo json_encode($msg);
        }
    }

    //--------------------------------------------------------------------


    public function simpandatabanyak()
    {
        if ($this->request->isAJAX()) {
            $kode_barang = $this->request->getVar('kode_barang');
            $nama_barang = $this->request->getVar('nama_barang');
            $satuan = $this->request->getVar('satuan');
            $harga = $this->request->getVar('harga');

            $jmldata = count($kode_barang);

            for ($i = 0; $i < $jmldata; $i++) {
                $this->brg->insert([
                    'kode_barang' => $kode_barang[$i],
                    'nama_barang' => $nama_barang[$i],
                    'satuan' => $satuan[$i],
                    'harga' => $harga[$i],
                ]);
            }

            $msg = [
                'sukses' => "$jmldata Data Berhasil Disimpan"
            ];

            echo json_encode($msg);
        }
    }

    //--------------------------------------------------------------------

    public function hapusbanyak()
    {
        if ($this->request->isAJAX()) {
            $kode_barang = $this->request->getVar('kode_barang');

            $jmldata = count($kode_barang);

            for ($i = 0; $i < $jmldata; $i++) {
                $this->brg->delete($kode_barang[$i]);
            };

            $msg = [
                'sukses' => "$jmldata Data Berhasil Dihapus"
            ];

            echo json_encode($msg);
        }
    }

    //--------------------------------------------------------------------

}

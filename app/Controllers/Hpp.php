<?php

namespace App\Controllers;

use App\Models\HppModel;

class Hpp extends BaseController
{
    public function index()
    {
        if (session('login') == false) {

            return view('login/index');
        } else {
            $session = session();

            $pages = [
                'title' => 'HPP',
                'sub' => 'Harga Pokok Produk',
                'breadcrump' => 'Pages / HPP'
            ];

            $session->set($pages);

            return view('hpp/viewhpp');
        }
    }

    //--------------------------------------------------------------------

    public function ambilDataHpp()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $data = [
                'hpp' => $this->hpp->get_hpp()
            ];

            $msg = [
                'data' => view('hpp/datahpp', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function form_tambahhpp()
    {
        if ($this->request->isAJAX()) {
            helper('form');

            $msg = [
                'data' => view('hpp/tambah_hpp')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function simpandatahpp()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'date' => [
                    'label' => 'Date',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'nama_hpp' => [
                    'label' => 'Nama Hpp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pembelian' => [
                    'label' => 'Pembelian',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pot_pembelian' => [
                    'label' => 'Potongan Pembelian',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'retur_pembelian' => [
                    'label' => 'Retur Pembelian',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'tanggal' => $validation->getError('date'),
                        'nama_hpp' => $validation->getError('nama_hpp'),
                        'pembelian' => $validation->getError('pembelian'),
                        'tanggal' => $validation->getError('date'),
                        'pot_pembelian' => $validation->getError('pot_pembelian'),
                        'retur_pembelian' => $validation->getError('retur_pembelian'),
                    ]

                ];

                echo json_encode($msg);
            } else {

                $getid = $this->hpp->get_last();

                if (isset($getid)) {
                    $id_hpp = $getid->id_hpp + 1;

                    $id_persediaan = $getid->id_hpp + 10001;
                } else {
                    if ($getid == NULL) {
                        $getid = 10000;

                        $id_hpp = $getid + 1;

                        $id_persediaan = $getid + 10001;
                    }
                }


                $simpandata = [
                    'id_hpp' => $id_hpp,
                    'id_persediaan' => $id_persediaan,
                    'date' => $this->request->getVar('date'),
                    'nama_hpp' => $this->request->getVar('nama_hpp'),
                    'pembelian' => $this->request->getVar('pembelian'),
                    'pot_pembelian' => $this->request->getVar('pot_pembelian'),
                    'retur_pembelian' => $this->request->getVar('retur_pembelian'),
                    'persediaan_awal' => '0',
                    'persediaan_akhir' => '0'
                ];

                $this->hpp->insert($simpandata);


                $data = [
                    'id_persediaan' => $id_persediaan,
                    'id_hpp' => $simpandata['id_hpp'],
                    'date' => $simpandata['date']
                ];

                $this->hpp->insert_persediaan($data);

                $msg = [
                    'sukses' => "Data HPP id: $id_hpp | tanggal : " . $data['date'] . "berhasil tersimpan",
                    'id_persediaan' => $id_persediaan
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function hapusbanyak()
    {
        if ($this->request->isAJAX()) {
            $id_hpp = $this->request->getVar('id_hpp');
            $jmldata = count($id_hpp);

            for ($i = 0; $i < $jmldata; $i++) {

                $this->hpp->delete($id_hpp[$i]);
                $this->hpp->delete_persediaan($id_hpp[$i]);
            };

            $msg = [
                'sukses' => "$jmldata Barang berhasil terhapus",
            ];

            echo json_encode($msg);
        }
    }

    //--------------------------------------------------------------------

    public function persediaan($id_hpp)
    {
        if (session('login') == false) {

            return view('login/index');
        } else {
            $session = session();

            $id_persediaan = $this->hpp->get_id_persediaan($id_hpp);

            $data = [
                'id_persediaan' => $id_persediaan->id_persediaan
            ];

            $pages = [
                'title' => 'Laporan HPP',
                'sub' => 'Laporan Harga Pokok Produk',
                'breadcrump' => 'Pages / HPP / Laporan'
            ];

            $session->set($pages);

            return view('laporan/viewpersediaan', $data);
        }
    }

    //--------------------------------------------------------------------

    public function ambilpersediaan()
    {
        if ($this->request->isAJAX()) {
            $id_persediaan = $this->request->getVar('id_persediaan');

            $d = [
                'persediaan' => $this->hpp->get_persediaan($id_persediaan)
            ];

            $msg = [
                'data' => view('laporan/datapersediaan', $d)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }
    //--------------------------------------------------------------------

}

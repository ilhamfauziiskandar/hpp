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
                'sub' => 'Laporan Harga Pokok Penjualan',
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
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'tanggal' => $validation->getError('date'),
                        'nama_hpp' => $validation->getError('nama_hpp')
                    ]

                ];

                echo json_encode($msg);
            } else {

                $getid = $this->hpp->get_last();

                if (isset($getid)) {
                    $id_hpp = $getid->id_hpp + 1;

                    $id_persediaan = $getid->id_persediaan + 1;
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
                    'nama_hpp' => $this->request->getVar('nama_hpp')
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

                $row = $this->hpp->find($id_hpp[$i]);
                $id_persediaan = $row['id_persediaan'];
                $this->hpp->delete_transaksi($id_persediaan);
                $this->hpp->delete_persediaan1($id_hpp[$i]);
                $this->hpp->delete($id_hpp[$i]);
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

            $hpp = $this->hpp->get_persediaan1($id_persediaan);

            $d = [
                'persediaan' => $this->hpp->get_persediaan_complete($id_persediaan),
                'hpp' => $hpp
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

    public function editpersediaan()
    {
        if ($this->request->isAJAX()) {
            $id_persediaan = $this->request->getVar('id_persediaan');

            $hpp = $this->hpp->get_persediaan1($id_persediaan);

            $d = [
                'persediaan' => $this->hpp->get_persediaan($id_persediaan),
                'hpp' => $hpp
            ];

            $msg = [
                'data' => view('laporan/editpersediaan', $d)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }
    //--------------------------------------------------------------------

    public function form_tambahpersediaan()
    {
        if ($this->request->isAJAX()) {
            $id_persediaan = $this->request->getVar('id_persediaan');

            $persediaan = $this->hpp->get_persediaan1($id_persediaan);

            $d = [
                'id_hpp' => $persediaan->id_hpp,
                'id_persediaan' => $persediaan->id_persediaan,
                'date' => $persediaan->date,
            ];

            $msg = [
                'data' => view('laporan/tambahpersediaan', $d)
            ];
            echo json_encode($msg);
        }
    }

    //--------------------------------------------------------------------

    function get_autocomplete()
    {
        $namabarang = $this->input->get('namabarang');
        $fieldName = $this->input->get('fieldName');
        $barang = $this->hpp->getfood($namabarang, $fieldName);
        echo json_encode($barang);
        exit;
    }

    //--------------------------------------------------------------------

    public function ambillaporan()
    {
        if ($this->request->isAJAX()) {
            $id_persediaan = $this->request->getVar('id_persediaan');

            $hpp = $this->hpp->get_persediaan1($id_persediaan);

            $transaksi = $this->hpp->get_transaksi($id_persediaan);

            $persediaan = $this->hpp->get_persediaan_complete($id_persediaan);
            if ($persediaan == NULL) {
                $jumlahnya_saldo_awal = 0;

                $jumlahnya_saldo_akhir = 0;

                $jumlah_barang_beli = 0;

                $pembelian = 0;

                $retur_pembelian = 0;

                $pot_pembelian = 0;

                $pembelian_bersih = $pembelian - $retur_pembelian - $pot_pembelian;

                $btusd = $jumlahnya_saldo_awal + $pembelian_bersih;

                $hasilhpp = $btusd - $jumlahnya_saldo_akhir;

                $d = [
                    'persediaan' => $persediaan,
                    'hpp' => $hpp,
                    'retur_pembelian' => $retur_pembelian,
                    'pot_pembelian' => $pot_pembelian,
                    'pembelian_bersih' => $pembelian_bersih,
                    'jumlah_saldo_akhir' => $jumlahnya_saldo_akhir,
                    'jumlah_saldo_awal' => $jumlahnya_saldo_awal,
                    'btusd' => $btusd,
                    'hasilhpp' => $hasilhpp,
                    'jumlah_barang_beli' => $jumlah_barang_beli
                ];
            } elseif ($transaksi == NULL) {
                foreach ($persediaan as $value) {

                    $jumlah_saldo_awal[] = $value['saldo_awal'];

                    $jumlah_saldo_akhir[] = $value['saldo_akhir'];
                    $barang_beli[] = $value['harga'] * $value['masuk'];

                    $jumlah_barang_beli = array_sum($barang_beli);
                    $jumlahnya_saldo_akhir = array_sum($jumlah_saldo_akhir);
                    $jumlahnya_saldo_awal = array_sum($jumlah_saldo_awal);
                }

                $pembelian = 0;

                $retur_pembelian = 0;

                $pot_pembelian = 0;

                $pembelian_bersih = $pembelian - $retur_pembelian - $pot_pembelian;

                $btusd = $jumlahnya_saldo_awal + $pembelian_bersih;

                $hasilhpp = $btusd - $jumlahnya_saldo_akhir;

                $d = [
                    'persediaan' => $persediaan,
                    'hpp' => $hpp,
                    'retur_pembelian' => $retur_pembelian,
                    'pot_pembelian' => $pot_pembelian,
                    'pembelian_bersih' => $pembelian_bersih,
                    'jumlah_saldo_akhir' => $jumlahnya_saldo_akhir,
                    'jumlah_saldo_awal' => $jumlahnya_saldo_awal,
                    'btusd' => $btusd,
                    'hasilhpp' => $hasilhpp,
                    'jumlah_barang_beli' => $jumlah_barang_beli
                ];
            } else {

                foreach ($transaksi as $t) {
                    $retur[] = $t['retur_pembelian'];
                    $pot[] = $t['pot_pembelian'];

                    $retur_pembelian = array_sum($retur);
                    $pot_pembelian = array_sum($pot);
                }

                foreach ($persediaan as $value) {

                    $jumlah_saldo_awal[] = $value['saldo_awal'];

                    $jumlah_saldo_akhir[] = $value['saldo_akhir'];
                    $barang_beli[] = $value['harga'] * $value['masuk'];

                    $jumlah_barang_beli = array_sum($barang_beli);
                    $jumlahnya_saldo_akhir = array_sum($jumlah_saldo_akhir);
                    $jumlahnya_saldo_awal = array_sum($jumlah_saldo_awal);
                }

                $pembelian_bersih_seharusnya = $jumlah_barang_beli - $retur_pembelian - $pot_pembelian;

                $btusd = $jumlahnya_saldo_awal + $pembelian_bersih_seharusnya;

                $hasilhpp = $btusd - $jumlahnya_saldo_akhir;

                $d = [
                    'persediaan' => $persediaan,
                    'hpp' => $hpp,
                    'retur_pembelian' => $retur_pembelian,
                    'pot_pembelian' => $pot_pembelian,
                    'pembelian_bersih' => $pembelian_bersih_seharusnya,
                    'jumlah_saldo_akhir' => $jumlahnya_saldo_akhir,
                    'jumlah_saldo_awal' => $jumlahnya_saldo_awal,
                    'btusd' => $btusd,
                    'hasilhpp' => $hasilhpp,
                    'jumlah_barang_beli' => $jumlah_barang_beli
                ];
            }


            $msg = [
                'data' => view('laporan/datalaporan', $d)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }
    //--------------------------------------------------------------------


    public function ambiltransaksi()
    {
        if ($this->request->isAJAX()) {
            $id_persediaan = $this->request->getVar('id_persediaan');
            $laporan = $this->hpp->get_persediaan_complete($id_persediaan);

            $d = [
                'transaksi' => $this->hpp->get_transaksi($id_persediaan)
            ];

            $msg = [
                'data' => view('laporan/datatransaksi', $d)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }
    //--------------------------------------------------------------------

    public function hapusbanyakpersediaan($id_persediaan)
    {
        if ($this->request->isAJAX()) {
            $kode_barang = $this->request->getVar('kode_barang');

            $jmldata = count($kode_barang);

            for ($i = 0; $i < $jmldata; $i++) {
                $this->hpp->delete_persediaan($kode_barang[$i], $id_persediaan);
                $this->hpp->delete_transaksi($id_persediaan);
            };

            $msg = [
                'sukses' => "$jmldata Data Berhasil Dihapus"
            ];

            echo json_encode($msg);
        }
    }
    //--------------------------------------------------------------------

    public function simpanpersediaanbanyak()
    {
        if ($this->request->isAJAX()) {
            $id_hpp = $this->request->getVar('id_hpp');

            $id_persediaan = $this->request->getVar('id_persediaan');

            $kode_barang = $this->request->getVar('kode_barang');

            $date = $this->request->getVar('date');

            $qty = $this->request->getVar('qty');

            $jmldata = count($kode_barang);

            $gagal = 0;

            $berhasil = 0;

            for ($i = 0; $i < $jmldata; $i++) {

                $x = $this->hpp->get_kodebarang($kode_barang[$i], $id_persediaan[0]);

                $y = count($x);

                if ($y > 0) {

                    $gagal = $gagal + 1;
                } else {
                    $this->hpp->insert_persediaan([
                        'id_hpp' => $id_hpp[$i],
                        'id_persediaan' => $id_persediaan[$i],
                        'kode_barang' => $kode_barang[$i],
                        'date' => $date[$i],
                        'qty' => $qty[$i],
                        'masuk' => '0',
                        'keluar' => '0'
                    ]);
                    $berhasil = $berhasil + 1;
                }
            }

            $msg = [
                'sukses' => "$berhasil Data Berhasil Disimpan, $gagal gagal tersimpan"
            ];

            echo json_encode($msg);
        }
    }

    //--------------------------------------------------------------------

    public function form_masuk_barang()
    {
        if ($this->request->isAJAX()) {

            $id_persediaan = $this->request->getVar('id_persediaan');
            $kode_barang = $this->request->getVar('kode_barang');

            $row = $this->hpp->get_stock($id_persediaan, $kode_barang);

            $data = [
                'id_persediaan' => $row->id_persediaan,
                'kode_barang' => $row->kode_barang,
                'nama_barang' => $row->nama_barang,
                'qty' => $row->qty,
                'masuk' => $row->masuk,
                'keluar' => $row->keluar
            ];
            $msg = [
                'sukses' => view('laporan/masuk_barang', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function form_keluar_barang()
    {
        if ($this->request->isAJAX()) {

            $id_persediaan = $this->request->getVar('id_persediaan');
            $kode_barang = $this->request->getVar('kode_barang');

            $row = $this->hpp->get_stock($id_persediaan, $kode_barang);

            $data = [
                'id_persediaan' => $row->id_persediaan,
                'kode_barang' => $row->kode_barang,
                'nama_barang' => $row->nama_barang,
                'qty' => $row->qty,
                'masuk' => $row->masuk,
                'keluar' => $row->keluar
            ];

            $msg = [
                'sukses' => view('laporan/keluar_barang', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function masukbarang()
    {
        if ($this->request->isAJAX()) {

            $id_persediaan = $this->request->getVar('id_persediaan');
            $kode_barang = $this->request->getVar('kode_barang');
            $masuk = $this->request->getVar('masuk');
            $retur = $this->request->getVar('retur_pembelian');
            $pot = $this->request->getVar('pot_pembelian');

            $row = $this->hpp->get_stock($id_persediaan, $kode_barang);

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'masuk' => [
                    'label' => 'Barang Masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'pot_pembelian' => [
                    'label' => 'Potongan Pembelian',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'retur_pembelian' => [
                    'label' => 'Retur Pembelian',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'masuk' => $validation->getError('masuk'),
                        'pot' => $validation->getError('retur_pembelian'),
                        'retur' => $validation->getError('pot_pembelian')
                    ]
                ];

                echo json_encode($msg);
            } else {
                $jumlah = $masuk + $row->masuk;

                $data =
                    [
                        'masuk' => $jumlah
                    ];

                $this->hpp->barangmasuk($id_persediaan, $kode_barang, $data);

                $tgl = date('Y-m-d');

                $data1 =
                    [
                        'id_persediaan' => $id_persediaan,
                        'kode_barang' => $kode_barang,
                        'id_status' => '1',
                        'jumlah' => $masuk,
                        'retur_pembelian' => $retur,
                        'pot_pembelian' => $pot,
                        'tanggal' => $tgl
                    ];

                $this->hpp->insert_transaksi($data1);

                $msg = [
                    'sukses' => "$masuk Data Barang berhasil masuk"
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

    public function keluarbarang()
    {
        if ($this->request->isAJAX()) {

            $id_persediaan = $this->request->getVar('id_persediaan');
            $kode_barang = $this->request->getVar('kode_barang');
            $keluar = $this->request->getVar('keluar');

            $row = $this->hpp->get_stock($id_persediaan, $kode_barang);

            $jumlah = $row->qty + $row->masuk - $row->keluar + 0;

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'keluar' => [
                    'label' => 'Barang keluar',
                    'rules' => 'required|less_than_equal_to[' . $jumlah . ']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'less_than_equal_to' => '{field} tidak boleh lebih dari quantity'
                    ]
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'keluar' => $validation->getError('keluar'),
                    ],

                ];

                echo json_encode($msg);
            } else {
                $jmlh_keluar = $row->keluar + $keluar + 0;

                $data =
                    [
                        'keluar' => $jmlh_keluar
                    ];

                $this->hpp->barangkeluar($id_persediaan, $kode_barang, $data);

                $tgl = date('Y-m-d');

                $data1 =
                    [
                        'id_persediaan' => $id_persediaan,
                        'kode_barang' => $kode_barang,
                        'id_status' => '2',
                        'jumlah' => $keluar,
                        'retur_pembelian' => '0',
                        'pot_pembelian' => '0',
                        'tanggal' => $tgl
                    ];

                $this->hpp->insert_transaksi($data1);

                $msg = [
                    'sukses' => "$keluar Data Barang berhasil keluar"
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }

    //--------------------------------------------------------------------

}

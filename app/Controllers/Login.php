<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Login extends BaseController
{
    public function index()
    {
        $session = session();

        $pages = [
            'title' => 'HPP',
            'sub' => 'Harga Pokok Produk',
            'breadcrump' => 'Pages / HPP'
        ];

        $session->set($pages);

        return view('login/index');
    }

    //--------------------------------------------------------------------

    public function cekuser()
    {
        $validation =  \Config\Services::validation();

        if ($this->request->isAjax()) {
            $userid = $this->request->getVar('userid');
            $pass = $this->request->getVar('pass');

            $valid = $this->validate([
                'userid' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harap di isi'
                    ]
                ],

                'pass' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harap di isi'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'userid' => $validation->getError('userid'),
                        'password' => $validation->getError('pass')
                    ]
                ];
            } else {
                $check_login = $this->login->login($userid);
                $jml = $check_login->getResult();

                if (count($jml) > 0) {
                    $row = $check_login->getRow();
                    $password_user = $row->password;

                    if ($pass == $password_user) {
                        $user = [
                            'login' => true,
                            'id' => $userid,
                            'nama' => $row->nama
                        ];

                        $this->session->set($user);

                        $msg = [
                            'sukses' => [
                                'link' => '../hpp/'
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Password Salah'
                            ]
                        ];
                    }
                } else {
                    $msg = [
                        'error' => [
                            'userid' => 'Maaf ID belum terdaftar'
                        ]
                    ];
                }
            }
        }
        echo json_encode($msg);
    }
    //--------------------------------------------------------------------

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }

    //--------------------------------------------------------------------

    public function daftar()
    {
        $session = session();

        $pages = [
            'title' => 'Daftar',
            'sub' => 'Daftar Akun Baru',
            'breadcrump' => 'Pages / HPP'
        ];

        $session->set($pages);

        return view('login/daftar');
    }

    //--------------------------------------------------------------------

    public function registration()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[user.username]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} username sudah ada, silahkan coba yang lain'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[3]|matches[password1]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'min_length' => '{field} password harus lebih dari 3 character',
                        'matches' => '{field} password tidak sama'
                    ]
                ],
                'password1' => [
                    'label' => 'Password',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'matches' => '{field} password tidak sama'
                    ]
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'nama' => $validation->getError('nama'),
                        'username' => $validation->getError('username'),
                        'password' => $validation->getError('password'),
                        'password1' => $validation->getError('password1'),
                    ],

                ];

                echo json_encode($msg);
            } else {
                $simpandata = [
                    'nama' => $this->request->getVar('nama'),
                    'username' => $this->request->getVar('username'),
                    'password' => $this->request->getVar('password')
                ];

                $this->login->insert($simpandata);

                $msg = [
                    'sukses' => 'Akun berhasil terdaftar'
                ];

                echo json_encode($msg);
            }
        } else {
            exit('Maaf tidak dapat di akses');
        }
    }
}

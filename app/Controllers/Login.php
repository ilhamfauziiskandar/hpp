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
}

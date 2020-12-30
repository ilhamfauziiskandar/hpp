<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		if (session('login') == false) {

			return view('login/index');
		} else {

			$session = session();

			$pages = [
				'title' => 'Home',
				'sub' => 'Home',
				'breadcrump' => 'Home'
			];

			$session->set($pages);

			return view('home');
		}
	}

	//--------------------------------------------------------------------

}

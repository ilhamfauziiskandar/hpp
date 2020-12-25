<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$session = session();

		$pages = [
			'title' => 'Home',
			'sub' => 'Home',
			'breadcrump' => 'Home'
		];

		$session->set($pages);

		return view('home');
	}

	//--------------------------------------------------------------------

}

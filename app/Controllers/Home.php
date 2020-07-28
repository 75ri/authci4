<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = ['title' => '75ri'];
		return view('home', $data);
	}

	//--------------------------------------------------------------------

	public function register()
	{
		return view('auth/register');
	}

	//--------------------------------------------------------------------

}

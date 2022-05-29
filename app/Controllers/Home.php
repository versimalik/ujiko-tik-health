<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $forge = \Config\Database::forge();

        //membuat database pada saat memulai aplikasi pertama kali
        if ($forge->createDatabase('tikhealth', true)){
          return redirect()->to('/home'); 
        }
    }

    public function home(){
        return view('homepage');
    }
}

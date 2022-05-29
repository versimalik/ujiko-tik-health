<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Userlogin;
use CodeIgniter\I18n\Time;

class Login extends BaseController
{
    public function index()
    {
        return view('login_form');
    }

    public function auth()
    {
        //inisiasi model Userlogin
        $userLoginModel = new Userlogin();

        //get data username dari form login
        $username = $this->request->getVar('username');

        //select dari dari table userlogin yang username = username yg diinput saat login
        $data = $userLoginModel->table('userlogin');
        $data = $userLoginModel->select('*');
        $data = $userLoginModel->join('users', 'users.username = userlogin.username');
        $data = $userLoginModel->where('userlogin.username',$username)->first();
        // $data = $userLoginModel->where('username', $username)->first();

        // jika data select ditemukan
        if ($data) {

            $session = session();

            //get data password dari form login
            $password = $this->request->getVar('password');

            //verifikasi password hashnya
            $verify_password = password_verify($password, $data['password']);

            //jika verifikasi benar
            if ($verify_password) {

                //masukkan data ke dalam session
                $session_data = [
                    'username'  => $data['username'],
                    'role'      => $data['role']
                ];

                $data['umur'] = $this->hitung_umur($data['tanggal_lahir_user']);
                $data['bmi'] = $this->hitung_bmi($data['berat_badan_user'], $data['tinggi_badan_user']);
                $data['status_konsultasi']= $this->status_konsultasi($data['umur'],$data['bmi']['hasil_bmi']);

                $data['users']= $this->getUser();

                // var_dump($data);
                // die();

                $session->set($data);
                // masuk ke halaman admin
                return view('admin_page', $data);
            //jika verifikasi salah
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                //kembali ke beranda
                return redirect()->to('/');
            }
        // jika data select tidak ditemukan
        } else {
            $session = session();
            $session->setFlashdata('msg', 'Username not Found');
            //kembali ke beranda
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function hitung_umur($tanggal_lahir)
    {
        $birthdate = Time::parse($tanggal_lahir);
        return $birthdate->getAge();
    }

    public function hitung_bmi($berat, $tinggi)
    {
        $hasil_bmi = round($berat / pow(($tinggi/100),2),1);

        $status_bmi = "";

        if ($hasil_bmi < 18.5) {
            $status_bmi = "Kurus";
        } elseif ($hasil_bmi <= 22.9 && $hasil_bmi >= 18.5) {
            $status_bmi = "Normal";
        } elseif ($hasil_bmi <=29.9 && $hasil_bmi > 22.9) {
            $statu_bmi = "Gemuk";
        } else {
            $status_bmi = "Obesitas";
        }

        $bmi=[
            'hasil_bmi' => $hasil_bmi,
            'status_bmi' => $status_bmi
        ];

        return $bmi;

    }

    public function status_konsultasi($umur,$bmi)
    {
        $status_konsultasi = "";
        if ($umur >= 17 && $bmi > 30) {
            $status_konsultasi = "Anda bisa mendapatkan konsultasi gratis";
        }

        return $status_konsultasi;
    }

    public function getUser()
    {       
        $userModel = new Userlogin();

        $data = $userModel->table('userlogin');
        $data = $userModel->select('*');
        $data = $userModel->join('users', 'users.username = userlogin.username')->find();

        return $data;
    }
}

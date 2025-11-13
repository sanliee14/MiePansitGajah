<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function login()
    {
        return view('kasir.login');
    }

    public function menu()
    {
        return view('kasir.menu');
    }

    public function accpesanan()
    {
        return view('kasir.accpesanan');
    }
    public function prosespesanan()
    {
        return view('kasir.prosespesanan');
    }
    public function history()
    {
        return view('kasir.history');
    }

    public function dashboard()
    {
        return view('kasir.dashboard');
    }

    public function transaksi()
    {
        return view('kasir.transaksi');
    }
}

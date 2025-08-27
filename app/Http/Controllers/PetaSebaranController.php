<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaSebaranController extends Controller
{
    public function index()
    {
        return view('peta-sebaran.index');
    }
}

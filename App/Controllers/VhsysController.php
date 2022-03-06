<?php

namespace App\Controllers;

use App\Models\VhsysModel;
use Core\Controller;

class VhsysController extends Controller
{
    public function index(){
        //$start = (new Controller("vhsys"))->index();
        $data = (new VhsysModel("vhsys"))->requestGet("clientes", ["limit" => 10]);
        $data = (array) json_decode($data);
        view('vhsys', $data);
    }
}

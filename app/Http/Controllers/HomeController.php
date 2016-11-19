<?php

namespace App\Http\Controllers;

use App\Disk;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $diskSpace = Disk::all();
        return view('home', ['disks' => $diskSpace]);
    }

    public function check()
    {
        abort(403, "You are not welcome");
    }
}

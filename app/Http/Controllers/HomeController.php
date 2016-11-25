<?php

namespace App\Http\Controllers;

use App\Disk;
use Illuminate\Http\Request;

/**
 * Controls the homepage
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $diskSpace = Disk::all();
        return view('home', ['disks' => $diskSpace]);
    }

    /**
     * Route intercepted by middleware.
     */
    public function check()
    {
        abort(403, "You are not welcome");
    }
}

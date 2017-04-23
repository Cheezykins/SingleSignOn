<?php

namespace App\Http\Controllers;

use App\Disk;
use App\Service;
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
        $diskSpace = Disk::orderBy('order', 'asc')->get();
        $serviceStatuses = Service::getActiveServiceStatuses();
        return view('home', ['disks' => $diskSpace, 'serviceStatuses' => $serviceStatuses]);
    }


}

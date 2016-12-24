<?php


namespace App\Http\Controllers;


use App\Service;

class StatusController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $services = Service::whereActive(true)->get();
        return view('status.index', ['services' => $services]);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('status.show', ['service' => $service]);
    }
}
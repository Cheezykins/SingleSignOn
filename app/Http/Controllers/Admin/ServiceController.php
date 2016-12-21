<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service;
use App\ServiceHeader;
use App\ServiceQueryParameter;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
            'method' => 'required|in:GET,POST,PUT,DELETE,PATCH',
            'name' => 'required|string',
            'description' => 'required|string',
            'active' => 'required|boolean',
            'slow_threshold' => 'required|integer',
            'very_slow_threshold' => 'required|integer',
            'headers.*.key' => 'filled|alpha',
            'headers.*.value' => 'required_with:headers.*.key',
            'query.*.key' => 'filled|alpha',
            'query.*.value' => 'required_with:headers.*.key'
        ]);

        $service = new Service();
        $service->url = $request->input('url');
        $service->method = $request->input('method');
        $service->name = $request->input('name');
        $service->description = $request->input('description');
        if ($request->has('payload')) {
            $service->payload = $request->input('payload');
        }
        $service->active = $request->input('active');
        $service->slow_threshold = $request->input('slow_threshold');
        $service->very_slow_threshold = $request->input('very_slow_threshold');
        $service->save();

        if ($request->has('headers')) {
            foreach ($request->input('headers') as $header) {
                $newHeader = new ServiceHeader();
                $newHeader->key = $header['key'];
                $newHeader->value = $header['value'];
                $newHeader->service()->associate($service);
                $newHeader->save();
            }
        }

        if ($request->has('query')) {
            foreach ($request->input('query') as $query) {
                $newHeader = new ServiceQueryParameter();
                $newHeader->key = $query['key'];
                $newHeader->value = $query['value'];
                $newHeader->service()->associate($service);
                $newHeader->save();
            }
        }

        $request->session()->flash('message', 'Service created successfully');
        return response()->redirectToRoute('admin.services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', ['service' => $service]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', ['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        $request->session()->flash('message', "Service {$service->name} has been deleted");
        return response()->redirectToRoute('admin.services.index');
    }
}

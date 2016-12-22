<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service;
use App\ServiceHeader;
use App\ServiceQueryParameter;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    protected $rules = [
        'url' => 'required|url',
        'enable_ssl_validation' => 'required|boolean',
        'method' => 'required|in:GET,POST,PUT,DELETE,PATCH',
        'name' => 'required|string',
        'description' => 'required|string',
        'active' => 'required|boolean',
        'slow_threshold' => 'required|integer',
        'very_slow_threshold' => 'required|integer',
        'headers.*.key' => 'filled|required_with:headers.*.value',
        'headers.*.value' => 'required_with:headers.*.key',
        'query.*.key' => 'filled|required_with:query.*.value',
        'query.*.value' => 'required_with:query.*.key'
    ];

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
        $this->validate($request, $this->rules);

        $service = new Service();

        $this->updateService($service, $request);
        $this->generateKeyValueObject($service, $request, 'headers', ServiceHeader::class);
        $this->generateKeyValueObject($service, $request, 'query', ServiceQueryParameter::class);

        $service->createInitialUpdate();

        $request->session()->flash('message', 'Service created successfully');
        return response()->redirectToRoute('admin.services.index');
    }

    /**
     * @param Service $service
     * @param Request $request
     * @param string $param
     * @param string $type
     */
    public function generateKeyValueObject(Service $service, Request $request, $param, $type)
    {
        if ($request->has($param)) {
            foreach ($request->input($param) as $item) {
                $newObject = new $type();
                $newObject->key = $item['key'];
                $newObject->value = $item['value'];
                $newObject->service()->associate($service);
                $newObject->save();
            }
        }
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
        $this->validate($request, $this->rules);

        /** @var Service $service */
        $service = Service::findOrFail($id);

        $this->updateService($service, $request);
        $service->service_headers()->delete();
        $service->service_query_parameters()->delete();

        $this->generateKeyValueObject($service, $request, 'headers', ServiceHeader::class);
        $this->generateKeyValueObject($service, $request, 'query', ServiceQueryParameter::class);

        $service->save();

        $request->session()->flash('message', "{$service->name} has been updated.");

        return response()->redirectToRoute('admin.services.index');
    }

    /**
     * Update the service
     * @param Service $service
     * @param Request $request
     */
    protected function updateService(Service $service, Request $request)
    {
        $service->url = $request->input('url');
        $service->enable_ssl_validation = $request->input('enable_ssl_validation');
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

<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function list(Request $request)
    {
        if(Auth::user() === null) {
            return redirect('/login');
        }

        return view('client.list');
    }

    public function show($id)
    {
        $client = Client::find($id);

        if($client === null) {
            return redirect('/dossier/client');
        }

        return view('client.show', [
            'client' => $client
        ]);
    }

    public function datatableClientList(Request $request)
    {
        $columns = [
            'name',
        ];

        $totalData = Client::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $name = $request->request->get('columns')[0]['search']['value'];

        $data = array();

        $clients = Client::offset($start)->limit($limit)->orderBy($order,$dir);

        if($name !== null) {
            $clients = $clients->where('name','LIKE', "%{$name}%");
        }

        $clients = $clients->get();
        $totalFiltered = $clients->count();

        foreach($clients as $client)
        {
            $route = route('client_show', ['id' => $client->id]);

            $data[] = [
                'name' => $client->name,
                'nbFolder' => $client->folders()->count(),
                'datalink' => [
                    'url' => $route,
                    'label' => 'voir'
                ]
            ];
        }

        $json = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        echo json_encode($json);
    }

    public function createClient(Request $request)
    {
        if(Auth::user() === null) {
            return redirect('/login');
        }

        return view('client.create');
    }

    public function store(Request $request)
    {
        if(Auth::user() === null) {
            return redirect('/login');
        }

        $client = new Client();
        $client->name = $request->name;
        $client->save();

        return redirect('/clients');
    }

    public function search(Request $request)
    {
        $name = $request->request->get('name');

        $client = Client::where('name', '=', $name)->first();

        if($client !== null) {
            return $client->name;
        }

        return $client;
    }
}

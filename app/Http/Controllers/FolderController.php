<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Services\FolderStepService;
use App\Services\GlobalService;
use App\User;
use App\Client;
use App\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    private $folderStepService;

    private $globalService;

    public function __construct()
    {
        $this->folderStepService = new FolderStepService();
        $this->globalService = new GlobalService();
    }

    public function create(Request $request)
    {
        if(Auth::user() === null) {
            return redirect('/login');
        }

        return view('folder.create');
    }

    public function show($id)
    {
        $folder = Folder::find($id);

        if($folder === null) {
            return redirect('/dossier/liste');
        }

        return view('folder.show', [
            'folder' => $folder
        ]);
    }

    public function datatableFolderList(Request $request)
    {
        $columns = [
            'numFolder',
            'dateArrive',
            'collaborator',
            'name',
            'piece',
            'status'
        ];

        $totalData = Folder::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $searchNumFolderValue = $request->request->get('columns')[0]['search']['value'];
        $searchDateRangeValue = $request->request->get('columns')[1]['search']['value'];
        $searchStatusValue = $request->request->get('columns')[5]['search']['value'];

        $folders = Folder::offset($start)->limit($limit)->orderBy($order,$dir);

        if($searchStatusValue !== null) {
            $folders = $folders->where('status','=',$searchStatusValue);
        }

        if($searchNumFolderValue !== null) {
            $folders = $folders->where('numFolder','LIKE', "%{$searchNumFolderValue}%");
        }

        if($searchDateRangeValue !== null && !strpos($searchDateRangeValue, '-')) {
            $folders = $folders->where('dateArrive','=', $this->globalService->getDate($searchDateRangeValue));
        } elseif ($searchDateRangeValue !== null && strpos($searchDateRangeValue, '-')) {
            $dates = explode(' - ', $searchDateRangeValue);
            $folders = $folders->where('dateArrive','>=', $this->globalService->getDate($dates[0]));
            $folders = $folders->where('dateArrive','<=', $this->globalService->getDate($dates[1]));
        }

        $folders = $folders->get();
        $totalFiltered = $folders->count();

        $data = array();

        foreach($folders as $folder) {

            $dateArrive = new \DateTime($folder->dateArrive);

            $route = null;
            $status = null;

            switch ($folder->status) {
                case 'to_scan':
                    $status = "à scanner";
                    $route = route('folder_scanner', ['id' => $folder->id]);
                    break;

                case 'to_compta':
                    $status = "à comptabiliser";
                    $route = route('folder_comptabiliser', ['id' => $folder->id]);
                    break;

                case 'to_integrer':
                    $status = "à intégrer";
                    $route = route('folder_integrer', ['id' => $folder->id]);
                    break;
                default:
                    $status = 'complet';
                break;
            }

            $data[] = [
                'numFolder' => $folder->numFolder,
                'dateArrive' => $dateArrive->format('d/m/Y'),
                'collaborator' => $folder->user->name,
                'name' => $folder->name,
                'piece' => $folder->piece,
                'status' => $status,
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

    public function list(Request $request)
    {
        if(Auth::user() === null) {
            return redirect('/login');
        }

        $countFolderToScan = Folder::where('status', '=', 'to_scan')->count();
        $countFolderToCompta = Folder::where('status', '=', 'to_compta')->count();
        $countFolderToIntegrer = Folder::where('status', '=', 'to_integrer')->count();

        $countFilesFolderToScan = Folder::where('status', '=', 'to_scan')->withCount(['files'])->sum('piece');
        $countFilesFolderToCompta = Folder::where('status', '=', 'to_compta')->withCount(['files'])->sum('piece');
        $countFilesFolderToIntegrer = Folder::where('status', '=', 'to_integrer')->withCount(['files'])->sum('piece');

        $totalFolderToDo = $countFolderToScan + $countFolderToCompta + $countFolderToIntegrer;
        $totalPieceFolderToDo = $countFilesFolderToScan + $countFilesFolderToCompta + $countFilesFolderToIntegrer;

        return view('folder.list', [
            'countFolderToScan' => $countFolderToScan,
            'countFolderToCompta' => $countFolderToCompta,
            'countFolderToIntegrer' => $countFolderToIntegrer,
            'totalFolderToDo' => $totalFolderToDo,
            'countFilesFolderToScan' => $countFilesFolderToScan,
            'countFilesFolderToCompta' => $countFilesFolderToCompta,
            'countFilesFolderToIntegrer' => $countFilesFolderToIntegrer,
            'totalPieceFolderToDo' => $totalPieceFolderToDo
        ]);
    }

    public function store(Request $request)
    {
        if(Auth::user() === null) {
            return redirect('/login');
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'numFolder' => 'required|integer|unique:folders',
            'name' => 'required',
            'piece' => 'required',
            'achat' => 'required|integer',
            'vente' => 'required|integer',
            'facture' => 'required|integer',
            'banque' => 'required|integer',
            'divers' => 'required|integer'
        ]);

        $sum = $request['achat'] + $request['vente'] + $request['facture'] + $request['banque'] + $request['divers'];

        if($validator->fails() === false) {
            if($sum != $request['piece']) {
                $validator->errors()->add('comparaisonSum',
                    'Le nombre de pièce ('. $request['piece'] .') ne correspond pas à la somme des types de fichier ('. $sum .')'
                );
            }
        }

        if(count($validator->errors()->getMessages()) !== 0) {
            return redirect('/dossier/creation')->withErrors($validator)->withInput();
        }

        $folder = new Folder();
        $client = Client::where('name', '=', $request['name'])->first();

        if($client === null) {
            $client = new Client();
            $client->name = $request['name'];
            $client->save();
        }

        $folder->name = $request['name'];
        $folder->piece = $request['piece'];
        $folder->numFolder = $request['numFolder'];
        $folder->status = 'to_scan';
        $folder->dateArrive = new \DateTime();
        $folder->achat = $request['achat'];
        $folder->vente = $request['vente'];
        $folder->facture = $request['facture'];
        $folder->banque = $request['banque'];
        $folder->divers = $request['divers'];

        $folder->user()->associate($user);
        $folder->client()->associate($client);
        $folder->save();

        return redirect('/');
    }
}
